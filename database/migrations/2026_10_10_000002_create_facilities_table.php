<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('client_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name'); // اسم المنشأة / الموقع
            $table->string('sector')->default('commercial'); // industrial, educational, medical, commercial, warehousing
            $table->string('city')->default('الرياض');
            $table->string('district')->nullable();
            $table->enum('zone_type', ['inside_city', 'outside_city'])->default('inside_city');
            $table->text('address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('safety_license_number')->nullable();
            $table->date('safety_license_expiry')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
