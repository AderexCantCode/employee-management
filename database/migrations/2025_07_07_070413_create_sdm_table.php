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
        Schema::create('sdm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');
            $table->string('project_director')->nullable();
            $table->string('engineer_web')->nullable();
            $table->string('analis')->nullable();
            $table->string('engineer_android')->nullable();
            $table->string('engineer_ios')->nullable();
            $table->string('copywriter')->nullable();
            $table->string('uiux')->nullable();
            $table->string('content_creator')->nullable();
            $table->string('tester')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sdm');
    }
};
