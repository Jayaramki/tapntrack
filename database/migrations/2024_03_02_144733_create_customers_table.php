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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('franchise_id')->nullable(false);
            $table->text('name')->nullable(false);
            $table->text('phone_number')->nullable();
            $table->text('email_id')->nullable();
            $table->text('address')->nullable();
            $table->text('profession')->nullable();
            $table->text('is_active')->nullable();
            $table->text('is_deleted')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
