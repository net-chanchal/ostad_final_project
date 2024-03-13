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
        Schema::create('job_post_attribute_others', function (Blueprint $table) {
            $table->foreignId('job_post_id')
                ->constrained('job_posts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('tags')->nullable();
            $table->string('benefits')->nullable();
            $table->string('skills')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_post_attribute_others');
    }
};
