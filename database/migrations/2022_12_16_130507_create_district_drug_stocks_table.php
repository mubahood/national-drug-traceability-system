<?php

use App\Models\DrugCategory;
use App\Models\DrugStock;
use App\Models\Location;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictDrugStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_drug_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(DrugCategory::class);
            $table->foreignIdFor(DrugStock::class);
            $table->foreignIdFor(Location::class, 'district_id');
            $table->foreignIdFor(Administrator::class, 'created_by');
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
        Schema::dropIfExists('district_drug_stocks');
    }
}
