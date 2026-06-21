<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rescue_team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_by')->constrained('users');
            $table->text('reason');
            $table->enum('status', ['assigned', 'en_route', 'on_site', 'completed', 'cancelled'])->default('assigned');
            $table->timestamp('emailed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_assignments');
    }
};
