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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('title'); // Title of the ticket
            $table->text('description'); // Description of the ticket
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium'); // Priority level
            $table->string('os'); // Operating system
            $table->enum('status', ['open', 'in_progress', 'closed'])->default('open'); // Status of the ticket
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('software_id')->constrained()->onDelete('cascade'); // Foreign key to software table
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
