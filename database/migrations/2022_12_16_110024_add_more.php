<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drug_stocks', function (Blueprint $table) {
            $table->text('drug_state')->nullable();
            $table->double('drug_packaging_unit_quantity')->nullable();
            $table->text('drug_packaging_type')->nullable();
            $table->text('drug_packaging_type_pieces')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('drug_stocks', function (Blueprint $table) {
            //
        });
    }
}
