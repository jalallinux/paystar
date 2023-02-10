<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id()->startingValue(10000001);
            $table->foreignIdFor(User::class, 'user_id')->constrained();
            $table->string('status');
            $table->unsignedBigInteger('amount');
            $table->string('tracking_code')->nullable();
            $table->string('card_number')->nullable();
            $table->string('ref_num')->nullable();
            $table->string('token')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('error_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
