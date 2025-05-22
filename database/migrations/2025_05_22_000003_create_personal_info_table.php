<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('hobby')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('identity_type');
            $table->string('nid_number')->nullable();
            $table->string('bid_number')->nullable();
            $table->string('profile_photo_path');
            $table->string('covid_certificate_path');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_info');
    }
};
