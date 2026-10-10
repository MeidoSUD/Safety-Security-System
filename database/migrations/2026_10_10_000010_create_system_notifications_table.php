<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type')->default('visit_reminder_48h'); // visit_reminder_48h, unpaid_parts_alert, new_maintenance_request, report_submitted, contract_expiring
            $table->string('title');
            $table->text('message');
            $table->string('target_url')->nullable();
            $table->boolean('is_read')->default(false);
            $table->enum('priority', ['normal', 'warning', 'urgent'])->default('normal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_notifications');
    }
};
