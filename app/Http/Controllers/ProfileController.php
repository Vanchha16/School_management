<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user->update($validated);

        return back()->with('success', 'profile-updated');
    }

    public function storePhoto(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $manager = new ImageManager(new Driver);

            $photoFile = $request->file('photo');
            $imageName = Str::uuid().'.jpg';

            $profilePath = public_path('assets/uploads/profile');
            $thumbPath = public_path('assets/uploads/thumbnails/profile');

            if (! File::exists($profilePath)) {
                File::makeDirectory($profilePath, 0755, true);
            }

            if (! File::exists($thumbPath)) {
                File::makeDirectory($thumbPath, 0755, true);
            }

            $mainImage = $manager->read($photoFile->getRealPath())
                ->cover(400, 400)
                ->toJpeg(85);

            file_put_contents($profilePath.'/'.$imageName, (string) $mainImage);

            $thumbnailImage = $manager->read($photoFile->getRealPath())
                ->cover(150, 150)
                ->toJpeg(80);

            file_put_contents($thumbPath.'/'.$imageName, (string) $thumbnailImage);

            $user->photo = $imageName;
            $user->save();
        }

        return back()->with('status', 'photo-added');
    }

    public function updatePhoto(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $manager = new ImageManager(new Driver);

            $photoFile = $request->file('photo');
            $imageName = Str::uuid().'.jpg';

            $profilePath = public_path('assets/uploads/profile');
            $thumbPath = public_path('assets/uploads/thumbnails/profile');

            if (! File::exists($profilePath)) {
                File::makeDirectory($profilePath, 0755, true);
            }

            if (! File::exists($thumbPath)) {
                File::makeDirectory($thumbPath, 0755, true);
            }

            if ($user->photo) {
                $oldMain = $profilePath.'/'.$user->photo;
                $oldThumb = $thumbPath.'/'.$user->photo;

                if (File::exists($oldMain)) {
                    File::delete($oldMain);
                }

                if (File::exists($oldThumb)) {
                    File::delete($oldThumb);
                }
            }

            $mainImage = $manager->read($photoFile->getRealPath())
                ->cover(400, 400)
                ->toJpeg(85);

            file_put_contents($profilePath.'/'.$imageName, (string) $mainImage);

            $thumbnailImage = $manager->read($photoFile->getRealPath())
                ->cover(150, 150)
                ->toJpeg(80);

            file_put_contents($thumbPath.'/'.$imageName, (string) $thumbnailImage);

            $user->photo = $imageName;
            $user->save();
        }

        return back()->with('success', 'photo-updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'password-updated');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
