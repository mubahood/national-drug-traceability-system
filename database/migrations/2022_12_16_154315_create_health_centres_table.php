<?php

use App\Models\Location;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthCentresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_centres', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Location::class, 'district_id');
            $table->text('name'); 
            $table->text('details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('health_centres');
    }
}
