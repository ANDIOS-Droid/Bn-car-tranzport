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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->enum('transport_type', ['car', 'bike', 'both'])->default('car');
            $table->string('vehicle_make')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_year')->nullable();
            $table->enum('vehicle_condition', ['running', 'non_running', 'damaged'])->default('running');
            $table->string('pickup_location');
            $table->string('pickup_city');
            $table->string('pickup_state');
            $table->string('pickup_pincode');
            $table->string('delivery_location');
            $table->string('delivery_city');
            $table->string('delivery_state');
            $table->string('delivery_pincode');
            $table->date('pickup_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->enum('service_type', ['open_carrier', 'enclosed_carrier', 'door_to_door', 'terminal_to_terminal'])->default('open_carrier');
            $table->text('additional_requirements')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'quoted', 'accepted', 'rejected', 'completed'])->default('pending');
            $table->decimal('quoted_price', 10, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('quoted_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Link to user if logged in
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_requests');
    }
};
