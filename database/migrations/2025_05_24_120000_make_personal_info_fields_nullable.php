<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_info', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('father_name')->nullable()->change();
            $table->string('mother_name')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('present_address')->nullable()->change();
            $table->string('permanent_address')->nullable()->change();
            $table->string('nationality')->nullable()->change();
            $table->string('hobby')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('gender')->nullable()->change();
            $table->string('identity_type')->nullable()->change();
            $table->string('nid_number')->nullable()->change();
            $table->string('bid_number')->nullable()->change();
            $table->string('profile_photo_path')->nullable()->change();
            $table->string('covid_certificate_path')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('personal_info', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->string('father_name')->nullable(false)->change();
            $table->string('mother_name')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
            $table->string('present_address')->nullable(false)->change();
            $table->string('permanent_address')->nullable(false)->change();
            $table->string('nationality')->nullable(false)->change();
            $table->string('hobby')->nullable(false)->change();
            $table->date('dob')->nullable(false)->change();
            $table->string('gender')->nullable(false)->change();
            $table->string('identity_type')->nullable(false)->change();
            $table->string('nid_number')->nullable(false)->change();
            $table->string('bid_number')->nullable(false)->change();

            $table->string('profile_photo_path')->nullable()->change();
            $table->string('covid_certificate_path')->nullable()->change();
            
            $table->text('description')->nullable(false)->change();
        });
    }
};
