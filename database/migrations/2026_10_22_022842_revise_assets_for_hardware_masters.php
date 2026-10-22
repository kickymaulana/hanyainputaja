<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('processors', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('memories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::table('assets', function (Blueprint $table): void {
            $table->foreignId('brand_id')->nullable()->after('department_id')->constrained()->nullOnDelete();
            $table->foreignId('processor_id')->nullable()->after('brand_id')->constrained()->nullOnDelete();
            $table->foreignId('memory_id')->nullable()->after('processor_id')->constrained()->nullOnDelete();
            $table->dropForeign(['factory_id']);
            $table->dropForeign(['asset_status_id']);
            $table->dropUnique(['asset_code']);
            $table->dropColumn(['asset_code', 'factory_id', 'asset_status_id', 'brand']);
        });

        Schema::dropIfExists('factories');
        Schema::dropIfExists('asset_statuses');
    }

    public function down(): void
    {
        Schema::create('factories', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('asset_statuses', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::table('assets', function (Blueprint $table): void {
            $table->string('asset_code')->unique()->after('id');
            $table->foreignId('factory_id')->nullable()->after('location_id')->constrained()->nullOnDelete();
            $table->foreignId('asset_status_id')->nullable()->after('position_id')->constrained()->nullOnDelete();
            $table->string('brand')->nullable()->after('serial_number');
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['processor_id']);
            $table->dropForeign(['memory_id']);
            $table->dropColumn(['brand_id', 'processor_id', 'memory_id']);
        });

        Schema::dropIfExists('brands');
        Schema::dropIfExists('processors');
        Schema::dropIfExists('memories');
    }
};
