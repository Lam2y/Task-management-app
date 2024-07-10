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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('Task');
            $table->string('Description');
            $table->date('Date_Given');
            $table->date('Due_Date');
            $table->string('Priority');
            $table->string('Status');
            $table->string('Assigned_By');
            $table->string('Assigned_By_Usertype');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
