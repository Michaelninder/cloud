<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('link_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('link_id');
            $table->ipAddress('ip_address');
            $table->string('user_agent');
            $table->timestamp('visited_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_views');
    }
};
