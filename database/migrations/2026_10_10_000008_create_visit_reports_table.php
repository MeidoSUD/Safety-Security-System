<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits')->onDelete('cascade');
            $table->foreignId('engineer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('report_number')->unique();
            $table->text('summary')->nullable();
            $table->enum('overall_status', ['passed', 'passed_with_notes', 'critical_action_required', 'failed'])->default('passed');
            $table->json('checklist_results')->nullable(); // Checkbox states for pumps, alarms, extinguishers, sprinklers
            $table->text('recommendations')->nullable();
            $table->text('engineer_notes')->nullable();
            $table->string('client_signature_name')->nullable();
            $table->string('pdf_path')->nullable();
            $table->enum('status', ['draft', 'submitted', 'approved', 'sent_to_client'])->default('submitted');
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_reports');
    }
};
