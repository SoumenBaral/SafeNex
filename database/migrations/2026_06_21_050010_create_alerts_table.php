<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('message');
            $table->foreignId('district_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('upazila_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('radius_km', 8, 2)->nullable();
            $table->foreignId('sent_by')->constrained('users');
            $table->timestamp('sent_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
