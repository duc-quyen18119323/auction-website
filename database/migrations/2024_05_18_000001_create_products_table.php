<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description');
            $table->decimal('starting_price', 10, 2);
            $table->decimal('bid_step', 10, 2);
            $table->dateTime('end_time');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->string('warranty')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};