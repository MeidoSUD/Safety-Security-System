<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visit_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits')->onDelete('cascade');
            $table->string('item_name'); // e.g. محبس عدم رجوع 4 إنش, بطاريات لوحة إنذار, كواشف بصرية
            $table->string('item_category')->default('spare_part'); // pump_part, alarm_part, sprinkler_part, extinguisher, general_spare, labor
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->decimal('total_price', 10, 2)->default(0.00);
            $table->enum('condition_status', ['good', 'needs_maintenance', 'replaced', 'critical_defect', 'repaired'])->default('needs_maintenance');
            $table->enum('payment_status', ['covered_by_contract', 'paid', 'unpaid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visit_items');
    }
};
