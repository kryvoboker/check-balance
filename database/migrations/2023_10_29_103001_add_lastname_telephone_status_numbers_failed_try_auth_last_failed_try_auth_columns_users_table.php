<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname', 255)->after('name');
            $table->string('telephone', 12)->after('lastname')->nullable(false)
                ->unique('telephone_indx');
            $table->boolean('status')->default(false)->after('telephone');
            $table->tinyInteger('numbers_failed_try_auth', false, true)->default(0);
            $table->timestamp('last_failed_try_auth')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'lastname',
                'telephone',
                'status',
                'numbers_failed_try_auth',
                'last_failed_try_auth'
            ]);
        });
    }
};
