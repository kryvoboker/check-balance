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
        Schema::create('user_login', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->ipAddress()->nullable(false)->index('ip_address_indx');
            $table->string('email', 255)->nullable(false);
            $table->tinyInteger('number_of_tries', false, true);
            $table->timestamp('date_modified')->default(date('Y-m-d H:i:s'))->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_login');
    }
};
