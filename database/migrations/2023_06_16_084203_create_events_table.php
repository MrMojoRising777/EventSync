<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This migration creates the 'events' table and updates the foreign key constraint.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date')->nullable();
            $table->decimal('lat', 18, 14);
            $table->decimal('long', 18, 14);
            $table->string('address');
            $table->string('zipcode');
            $table->string('city');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Drop the previous foreign key constraint and add the updated one
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};