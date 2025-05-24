<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experience_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('ref_id'); // Reference to personal_info.id
            $table->string('company_name');
            $table->string('designation');
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_years', 4, 2)->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ref_id')->references('id')->on('personal_info')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_info');
    }
};
