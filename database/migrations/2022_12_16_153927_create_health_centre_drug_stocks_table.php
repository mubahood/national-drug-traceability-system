<?php

use App\Models\DrugCategory;
use App\Models\DrugStock;
use App\Models\HealthCentre;
use App\Models\Location;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthCentreDrugStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_centre_drug_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(DrugCategory::class);
            $table->foreignIdFor(DrugStock::class);
            $table->foreignIdFor(Location::class, 'district_id');
            $table->foreignIdFor(Administrator::class, 'created_by');
            $table->foreignIdFor(HealthCentre::class);
            $table->bigInteger('original_quantity');
            $table->bigInteger('current_quantity'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_centre_drug_stocks');
    }
}
