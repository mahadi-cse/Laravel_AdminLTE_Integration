<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
