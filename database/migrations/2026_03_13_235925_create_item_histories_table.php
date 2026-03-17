<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('item_histories', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('borrow_id')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->unsignedBigInteger('returned_by')->nullable();

            $table->string('action', 50); // Borrowed, Returned, Undo return
            $table->text('details')->nullable();
            $table->dateTime('action_at')->nullable();

            $table->timestamps();

            $table->index('borrow_id');
            $table->index('student_id');
            $table->index('item_id');
            $table->index('user_id');
            $table->index('approved_by');
            $table->index('returned_by');
            $table->index('action');

            $table->foreign('borrow_id')->references('id')->on('borrows')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('returned_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_histories');
    }
};
