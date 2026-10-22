<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table): void {
            $table->foreignId('factory_id')->nullable()->after('location_id')->constrained('factories')->nullOnDelete();
            $table->foreignId('position_id')->nullable()->after('user_name')->constrained('positions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table): void {
            $table->dropForeign(['factory_id']);
            $table->dropForeign(['position_id']);
            $table->dropColumn(['factory_id', 'position_id']);
        });
    }
};
