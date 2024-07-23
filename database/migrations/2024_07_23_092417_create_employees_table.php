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
            $table->unsignedBigInteger('user_id');
            $table->text('address')->nullable();
            $table->string('dept');
            $table->string('alt_contact')->nullable();
            $table->decimal('salary', 8, 2)->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('pincode')->nullable();
            $table->string('pan')->nullable();
            $table->string('adhar')->nullable();
            $table->text('pan_file')->nullable();
            $table->text('adhar_file')->nullable();
            $table->string('acc_holder_name')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('acc_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->text('passbook')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
