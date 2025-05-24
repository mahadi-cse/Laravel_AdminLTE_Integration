<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ref_id'); // Reference to personal_info.id
            $table->string('training_title');
            $table->string('institute_name');
            $table->string('duration');
            $table->string('training_year');
            $table->string('location');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ref_id')->references('id')->on('personal_info')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_info');
    }
};
