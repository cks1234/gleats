<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_no', 20)->unique();
            $table->enum('type', ['electrical', 'hardware', 'data']);
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('license_id')->nullable();
            $table->unsignedBigInteger('work_address_id');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'completed']);
            $table->timestamps();
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                ->onDelete('cascade');
            $table->foreign('supervisor_id')
                  ->references('id')
                  ->on('users')
              ->onDelete('cascade');
            $table->foreign('license_id')
                  ->references('id')
                  ->on('licenses')
              ->onDelete('cascade');
            $table->foreign('work_address_id')
                ->references('id')
                ->on('addresses')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
