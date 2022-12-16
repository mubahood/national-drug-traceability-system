<?php

use App\Models\DrugCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(DrugCategory::class);
            $table->text('manufacturer')->nullable();
            $table->text('batch_number')->nullable();
            $table->date('expiry_date')->nullable();
            $table->bigInteger('original_quantity');
            $table->bigInteger('current_quantity');
            $table->text('image')->nullable();
            $table->text('description')->nullable();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_stocks');
    }
}
