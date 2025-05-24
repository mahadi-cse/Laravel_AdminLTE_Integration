<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('experience_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('ref_id')->nullable()->change();
            $table->string('company_name')->nullable()->change();
            $table->string('designation')->nullable()->change();
            $table->string('location')->nullable()->change();
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            $table->decimal('total_years', 4, 2)->nullable()->change();
        });
        Schema::table('training_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->unsignedBigInteger('ref_id')->nullable()->change();
            $table->string('training_title')->nullable()->change();
            $table->string('institute_name')->nullable()->change();
            $table->string('duration')->nullable()->change();
            $table->string('training_year')->nullable()->change();
            $table->string('location')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('experience_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('ref_id')->nullable(false)->change();
            $table->string('company_name')->nullable(false)->change();
            $table->string('designation')->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();
            $table->decimal('total_years', 4, 2)->nullable(false)->change();
        });
        Schema::table('training_info', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->unsignedBigInteger('ref_id')->nullable(false)->change();
            $table->string('training_title')->nullable(false)->change();
            $table->string('institute_name')->nullable(false)->change();
            $table->string('duration')->nullable(false)->change();
            $table->string('training_year')->nullable(false)->change();
            $table->string('location')->nullable(false)->change();
        });
    }
};
