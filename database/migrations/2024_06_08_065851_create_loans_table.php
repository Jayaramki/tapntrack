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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('franchise_id')->nullable(false);
            $table->unsignedInteger('cid')->nullable(false);
            $table->text('loan_number')->nullable();
            $table->double('disbursed_amt')->nullable(false);
            $table->enum('loan_type', ['daily', 'weekly', 'monthly'])->default('daily');
            $table->unsignedInteger('line_id')->nullable();
            $table->double('interest_amt')->nullable();
            $table->integer('installment_amt')->nullable();
            $table->date('disbursed_at')->nullable(false);
            $table->date('completed_at')->nullable(false);
            $table->timestamp('is_deleted')->nullable();
            $table->unsignedInteger('created_by')->nullable(false);
            $table->unsignedInteger('updated_by')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
