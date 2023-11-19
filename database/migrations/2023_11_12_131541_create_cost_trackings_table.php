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
        Schema::create('cost_trackings', function (Blueprint $table) {
            $table->id()->unsigned();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->float('money_earned')->nullable(false);
            $table->timestamp('current_month_day')
                ->default(DB::raw('current_timestamp'));

            $table->timestamp('next_month_day')
                ->default(DB::raw('current_timestamp'));

            $table->json('costs')
                ->default('')
                ->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_trackings');
    }
};
