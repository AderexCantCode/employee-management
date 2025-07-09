<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birth')->nullable();                   // tanggal lahir cukup date
            $table->unsignedTinyInteger('work_hours')->nullable(); // 1=low, 2=medium, 3=high
            $table->enum('role', ['employee', 'admin']);
            $table->enum('status', ['ready', 'standby', 'not_ready', 'absent'])
                ->default('ready');
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
