<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->nullOnDelete();
            $table->foreignId('maintenance_request_id')->nullable()->constrained('maintenance_requests')->nullOnDelete();
            $table->foreignId('assigned_engineer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('assigned_supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('visit_number')->unique();
            $table->enum('visit_type', ['emergency', 'quarterly_inspection', 'pre_contract_audit', 'corrective_maintenance'])->default('quarterly_inspection');
            $table->dateTime('scheduled_at');
            $table->enum('location_zone', ['inside_city', 'outside_city'])->default('inside_city');
            $table->decimal('visit_fee', 8, 2)->default(0.00);
            $table->enum('fee_status', ['covered_by_contract', 'paid', 'unpaid', 'waived'])->default('covered_by_contract');
            $table->text('purpose');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->boolean('has_unpaid_parts')->default(false);
            $table->decimal('unpaid_parts_amount', 10, 2)->default(0.00);
            $table->text('unpaid_parts_notes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
