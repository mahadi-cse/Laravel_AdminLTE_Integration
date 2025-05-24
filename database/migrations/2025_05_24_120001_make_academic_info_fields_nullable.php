<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academic_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('ref_id')->nullable()->change();
            $table->string('education_level')->nullable()->change();
            $table->string('department')->nullable()->change();
            $table->string('institute_name')->nullable()->change();
            $table->string('passing_year')->nullable()->change();
            $table->string('cgpa')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('academic_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('ref_id')->nullable(false)->change();
            $table->string('education_level')->nullable(false)->change();
            $table->string('department')->nullable(false)->change();
            $table->string('institute_name')->nullable(false)->change();
            $table->string('passing_year')->nullable(false)->change();
            $table->string('cgpa')->nullable(false)->change();
        });
    }
};
