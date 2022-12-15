<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrugCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drug_categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('nda_registration_number')->nullable();
            $table->text('license_holder')->nullable();
            $table->text('name_of_drug')->nullable();
            $table->text('generic_name_of_drug')->nullable();
            $table->text('strength_of_drug')->nullable();
            $table->text('manufacturer')->nullable();
            $table->text('country_of_manufacturer')->nullable();
            $table->text('dosage_form')->nullable();
            $table->text('registration_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_categories');
    }
}
