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
        Schema::table('forms', function (Blueprint $table) {
            // Remove old enum column if exists
            if (Schema::hasColumn('forms', 'form_status')) {
                $table->dropColumn('form_status');
            }
            // Add integer status column
            $table->integer('status')->default(-1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->enum('form_status', ['draft', 'submitted'])->default('draft');
        });
    }
};
