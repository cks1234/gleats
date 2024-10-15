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
        Schema::create('test_report_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('job_id');
            $table->json('report');
            $table->text('comments')->nullable();
            $table->text('equipment')->nullable();
            $table->text('supervisor_signature');
            $table->date('supervisor_signature_date');
            $table->text('contractor_signature')->nullable();
            $table->date('contractor_signature_date')->nullable();
            $table->enum('status', ['pending', 'signed', 'rejected'])->default('pending');
            $table->timestamps();
            $table->foreign('supervisor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('job_id')
                  ->references('id')
                  ->on('jobs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_reports_certificates');
    }
};
