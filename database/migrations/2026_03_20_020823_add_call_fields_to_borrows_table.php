<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->string('call_status')->default('not_yet_called')->after('status');
            $table->text('call_note')->nullable()->after('call_status');
            $table->timestamp('called_at')->nullable()->after('call_note');
            $table->unsignedBigInteger('called_by')->nullable()->after('called_at');

            $table->foreign('called_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->dropForeign(['called_by']);
            $table->dropColumn([
                'call_status',
                'call_note',
                'called_at',
                'called_by',
            ]);
        });
    }
};