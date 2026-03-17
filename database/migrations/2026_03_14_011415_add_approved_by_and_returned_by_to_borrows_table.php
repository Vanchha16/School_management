<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->unsignedBigInteger('approved_by')->nullable()->after('notes');
            $table->unsignedBigInteger('returned_by')->nullable()->after('approved_by');

            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('returned_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['returned_by']);
            $table->dropColumn(['approved_by', 'returned_by']);
        });
    }
};