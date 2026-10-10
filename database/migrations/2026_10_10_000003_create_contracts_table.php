<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->string('contract_number')->unique();
            $table->string('title');
            $table->enum('contract_type', ['annual_comprehensive', 'preventive_maintenance', 'periodic_inspection', 'safety_compliance'])->default('annual_comprehensive');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->integer('visits_quota')->default(4);
            $table->integer('visits_used')->default(0);
            $table->enum('status', ['active', 'expiring_soon', 'expired', 'cancelled'])->default('active');
            $table->string('attachment_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
