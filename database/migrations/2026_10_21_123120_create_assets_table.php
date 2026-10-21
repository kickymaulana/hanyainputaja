<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table): void {
            $table->id();
            $table->string('asset_code')->unique();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->text('description');
            $table->foreignId('location_id')->constrained()->restrictOnDelete();
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->string('user_name')->nullable();
            $table->string('user_position')->nullable();
            $table->foreignId('asset_status_id')->constrained('asset_statuses')->restrictOnDelete();
            $table->foreignId('asset_condition_id')->constrained('asset_conditions')->restrictOnDelete();
            $table->string('serial_number')->nullable();
            $table->string('brand')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
