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
        Schema::create('sdms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');

            $table->foreignId('project_director')->nullable()->constrained('users');
            $table->foreignId('backend_dev')->nullable()->constrained('users');
            $table->foreignId('frontend_dev')->nullable()->constrained('users');
            $table->foreignId('analis')->nullable()->constrained('users');
            $table->foreignId('engineer_android')->nullable()->constrained('users');
            $table->foreignId('engineer_ios')->nullable()->constrained('users');
            $table->foreignId('copywriter')->nullable()->constrained('users');
            $table->foreignId('uiux')->nullable()->constrained('users');
            $table->foreignId('content_creator')->nullable()->constrained('users');
            $table->foreignId('tester')->nullable()->constrained('users');

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
