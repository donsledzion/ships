<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('boards', function (Blueprint $table) {
            $freshFields = json_encode([
                'A' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'B' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'C' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'D' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'E' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'F' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'G' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'H' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'I' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],
                'J' => [
                    '1' => 'x',
                    '2' => 'x',
                    '3' => 'x',
                    '4' => 'x',
                    '5' => 'x',
                    '6' => 'x',
                    '7' => 'x',
                    '8' => 'x',
                    '9' => 'x',
                    '10' => 'x',
                ],

            ]);
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->foreignId('table_id')->constrained()->onDelete('cascade')->onDelete('cascade');
            $table->json('fields');
            $table->boolean('initialized')->default(false);
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
        Schema::dropIfExists('boards');
    }
}
