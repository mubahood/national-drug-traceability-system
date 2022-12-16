<?php

use App\Models\DistrictDrugStock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('health_centre_drug_stocks', function (Blueprint $table) {
            $table->foreignIdFor(DistrictDrugStock::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_centre_drug_stocks', function (Blueprint $table) {
            //
        });
    }
}
