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
        Schema::create('entrances', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('id')->primary();
            $table->string('license_plate');
            $table->string('started_at');
            $table->string('finalized_at');
            $table->enum('state', ['ACTIVE','COMPLETED']);
            $table->foreignUuid('vehicle_type_id')
                ->nullable()
                ->references('id')
                ->on('vehicle_types')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrances');
    }
};
