<?php

use App\Models\HealthCentreDrugStock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_drug_records', function (Blueprint $table) {
            $table->foreignIdFor(HealthCentreDrugStock::class);
            $table->integer("quantity");
            // 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_drug_records', function (Blueprint $table) {
            //
        });
    }
}
