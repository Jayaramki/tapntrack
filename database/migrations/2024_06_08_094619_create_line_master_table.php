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
        Schema::create('line_master', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('franchise_id')->nullable(false);
            $table->text('name')->nullable(false);
            $table->text('description')->nullable();
            $table->unsignedInteger('created_by')->nullable(false);
            $table->unsignedInteger('updated_by')->nullable(false);
            $table->timestamp('is_deleted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('line_master');
    }
};
