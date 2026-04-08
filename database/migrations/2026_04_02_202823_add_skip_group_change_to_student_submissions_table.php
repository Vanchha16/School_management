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
    Schema::table('student_submissions', function ($table) {
        $table->boolean('skip_group_change')->default(false)->after('is_borrow_approved');
    });
}

public function down(): void
{
    Schema::table('student_submissions', function ($table) {
        $table->dropColumn('skip_group_change');
    });
}
};
