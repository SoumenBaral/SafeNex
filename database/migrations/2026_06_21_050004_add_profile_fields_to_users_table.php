<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('phone');
            $table->foreignId('district_id')->nullable()->after('avatar')->constrained()->nullOnDelete();
            $table->foreignId('upazila_id')->nullable()->after('district_id')->constrained()->nullOnDelete();
            $table->text('fcm_token')->nullable()->after('upazila_id');
            $table->decimal('last_lat', 10, 7)->nullable()->after('fcm_token');
            $table->decimal('last_lng', 10, 7)->nullable()->after('last_lat');
            $table->enum('status', ['active', 'blocked'])->default('active')->after('last_lng');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->dropForeign(['upazila_id']);
            $table->dropColumn(['phone', 'avatar', 'district_id', 'upazila_id', 'fcm_token', 'last_lat', 'last_lng', 'status']);
        });
    }
};
