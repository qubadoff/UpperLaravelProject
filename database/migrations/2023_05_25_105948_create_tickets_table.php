<?php

declare(strict_types=1);

use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('ticket_number')->nullable()->unique();
            $table->string('customer_address', 80);
            $table->float('latitude', 8, 6);
            $table->float('longitude', 9, 6);
            $table->string('customer_name', 50);
            $table->string('customer_phone', 20);
            $table->foreignId('admin_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('appliance_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('fee_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('note', 80)->nullable();
            $table->enum('status', Status::values())->nullable();
            $table->boolean('show_home')->default(1);
            $table->text('fee_note')->nullable();
            $table->unsignedFloat('parts_fee')->nullable();
            $table->unsignedFloat('total_fee');
            $table->string('check_number', 15)->nullable();
            $table->string('credit_card_number', 15)->nullable();
            $table->unsignedFloat('cash_amount')->nullable();
            $table->unsignedFloat('check_amount')->nullable();
            $table->unsignedFloat('credit_card_amount')->nullable();
            $table->unsignedFloat('zelle_amount')->nullable();
            $table->date('reschedule_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->dateTime('executed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
