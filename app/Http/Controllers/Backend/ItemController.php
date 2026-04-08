<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $itemsQuery = Item::query();

        if ($q = $request->q) {
            $itemsQuery->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('name_kh', 'like', "%{$q}%");
            });
        }

        $items = $itemsQuery
            ->withSum(['borrows as borrowed_qty' => function ($q) {
                $q->where('status', 'BORROWED');
            }], 'qty')
            ->orderByDesc('Itemid')
            ->paginate(10)
            ->withQueryString();

        $statTotal = Item::count();
        $statActive = Item::where('status', 1)->count();
        $statInactive = Item::where('status', 0)->count();

        return view('backend.page.items.index', compact('items', 'statTotal', 'statActive', 'statInactive'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'qty' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2024',
        ]);

        if ($request->hasFile('image')) {

            $manager = new ImageManager(new Driver);
            // Get uploaded file
            $imageFile = $request->file('image');
            // Create a unique name
            $imageName = time().'.'.$imageFile->getClientOriginalExtension();

            // Resize image using Intervention Image
            $resizedImage = $manager
                ->read($imageFile->getRealPath())
                ->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->toJpeg(80); // or toPng(), toWebp() as needed

            // Save thumbnail
            $thumbnailPath = public_path('/assets/uploads/thumbnails/items/'.$imageName);
            file_put_contents($thumbnailPath, (string) $resizedImage);

            // Save original image
            $destinationPath = public_path('/assets/uploads/items');
            $imageFile->move($destinationPath, $imageName);
            Storage::disk('s3')->put('items/' . $imageName, (string) $resizedImage);

            // Save filename to DB (optional)
            $input['image'] = $imageName;
        }
        // $path = null;
        // if ($request->hasFile('image')) {
        //     $path = $request->file('image')->store('items', 'public');
        // }

        Item::create([
            'name' => $request->name,
            'name_kh' => $request->name_kh,
            'qty' => $request->qty,
            'status' => $request->status,
            'description' => $request->description,
            'image' => $input['image'] = $imageName,
            'available' => 0,
            'borrow' => 0,
        ]);

        return back()->with('success', 'Item added successfully!');
    }

    public function destroy(Request $request, $itemid)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if (! Hash::check($request->password, auth()->user()->password)) {
            return back()->withErrors(['password' => 'The password is incorrect password']);
        }

        $item = Item::where('Itemid', $itemid)->firstOrFail();

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted!');
    }

    // public function edit($itemid)
    // {
    //     $item = Item::where('Itemid', $itemid)->firstOrFail();

    //     return view('backend.page.items.edit', compact('item'));
    // }

    public function update(Request $request, $itemid)
    {
        // 1. Find the item
        $item = Item::where('Itemid', $itemid)->firstOrFail();

        // 2. Validate
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kh' => 'nullable|string|max:255',
            'qty' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // 3. Handle Image Upload
        if ($request->hasFile('image')) {
            // Optional: Delete old image files here if you want to save space
            if ($item->image && file_exists(public_path('/assets/uploads/items/'.$item->image))) {
                @unlink(public_path('/assets/uploads/items/'.$item->image));
                @unlink(public_path('/assets/uploads/thumbnails/items/'.$item->image));
            }

            $manager = new ImageManager(new Driver);
            $imageFile = $request->file('image');
            $imageName = time().'.'.$imageFile->getClientOriginalExtension();

            // Resize and Save Thumbnail
            $resizedImage = $manager->read($imageFile->getRealPath())
                ->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->toJpeg(80);

            $thumbnailPath = public_path('/assets/uploads/thumbnails/items/'.$imageName);
            file_put_contents($thumbnailPath, (string) $resizedImage);

            // Save Original
            $imageFile->move(public_path('/assets/uploads/items'), $imageName);

            // Update the item instance with the NEW filename
            $item->image = $imageName;
        }

        // 4. Update other fields
        $item->name = $request->name;
        $item->name_kh = $request->name_kh;
        $item->qty = $request->qty;
        $item->status = $request->status;
        $item->description = $request->description;

        // 5. Save the changes
        $item->save();

        // 6. Trigger that SweetAlert we set up earlier!
        return back()->with('success', 'Item updated successfully!');
    }

    public function show($itemid)
    {
        $item = Item::where('Itemid', $itemid)->firstOrFail();

        $borrowed = Borrow::where('item_id', $item->Itemid)
            ->where('status', 'BORROWED')
            ->sum('qty');

        $available = $item->qty ?? 0;

        return view('backend.page.items.show', compact('item', 'available', 'borrowed'));
    }
}
