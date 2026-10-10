<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits')->onDelete('cascade');
            $table->foreignId('facility_id')->nullable()->constrained('facilities')->nullOnDelete();
            $table->foreignId('uploaded_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->enum('stage', ['before_work', 'during_inspection', 'after_work', 'defect_evidence'])->default('during_inspection');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_images');
    }
};
