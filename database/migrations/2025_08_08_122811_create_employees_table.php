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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')
                ->constrained()
                ->onDelete('restrict');
            $table->foreignId('state_id')
                ->constrained()
                ->onDelete('restrict');
            $table->foreignId('city_id')
                ->constrained()
                ->onDelete('restrict');
            $table->foreignId('department_id')
                ->constrained()
                ->onDelete('restrict');
            $table->foreignId('position_id')
                ->constrained()
                ->onDelete('restrict');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->char('zip_code');
            $table->date('birth_date');
            $table->date('hired_date');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
