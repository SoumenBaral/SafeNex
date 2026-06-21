<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rescue_teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('leader_name');
            $table->string('leader_phone')->nullable();
            $table->string('leader_email')->nullable();
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['available', 'busy', 'offline'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rescue_teams');
    }
};
