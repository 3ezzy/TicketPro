<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_resolutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('developer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('resolution_notes');
            $table->text('admin_notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('resolved_at');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            // To ensure one resolution per ticket
            $table->unique('ticket_id');
        });
        
    
        Schema::table('tickets', function (Blueprint $table) {
            // We need to drop the existing enum column and recreate it with the new value
            DB::statement("ALTER TABLE tickets DROP CONSTRAINT tickets_status_check");
            DB::statement("ALTER TABLE tickets ADD CONSTRAINT tickets_status_check CHECK (status::text = ANY (ARRAY['open'::character varying, 'in_progress'::character varying, 'closed'::character varying, 'pending_approval'::character varying]::text[]))");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_resolutions');
        
        // Revert the tickets status enum
        Schema::table('tickets', function (Blueprint $table) {
            DB::statement("ALTER TABLE tickets DROP CONSTRAINT tickets_status_check");
            DB::statement("ALTER TABLE tickets ADD CONSTRAINT tickets_status_check CHECK (status::text = ANY (ARRAY['open'::character varying, 'in_progress'::character varying, 'closed'::character varying]::text[]))");
        });
    }
};