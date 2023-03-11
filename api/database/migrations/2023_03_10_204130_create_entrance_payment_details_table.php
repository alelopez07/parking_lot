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
        Schema::create('entrance_payment_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('payment_type');
            $table->string('minutes');
            $table->double('total', 4, 2);
            $table->foreignUuid('entrance_id')
                ->references('id')
                ->on('entrances')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrance_payment_details');
    }
};
