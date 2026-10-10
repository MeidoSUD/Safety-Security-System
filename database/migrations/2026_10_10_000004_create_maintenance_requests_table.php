<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->foreignId('requester_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('request_number')->unique();
            $table->enum('type', ['emergency', 'preventive', 'inspection', 'quote_request'])->default('emergency');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('system_type')->default('fire_alarm'); // fire_alarm, fire_pumps, sprinklers, fire_extinguishers, fm200_co2, hydrants, all_systems
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('site_photos')->nullable();
            $table->enum('status', ['pending', 'scheduled', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->date('preferred_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
