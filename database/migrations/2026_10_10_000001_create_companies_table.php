<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cr_number')->nullable(); // السجل التجاري
            $table->string('tax_number')->nullable(); // الرقم الضريبي
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->default('الرياض');
            $table->text('address')->nullable();
            $table->string('subscription_plan')->default('enterprise'); // starter, pro, enterprise
            $table->string('subscription_status')->default('active'); // active, trial, expired
            $table->string('logo')->nullable();
            $table->decimal('zone_rate_inside', 8, 2)->default(350.00);
            $table->decimal('zone_rate_outside', 8, 2)->default(650.00);
            $table->boolean('sms_reminder_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
