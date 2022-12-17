<?php

use App\Models\DistrictDrugStock;
use App\Models\DrugCategory;
use App\Models\DrugStock;
use App\Models\HealthCentre;
use App\Models\Location;
use App\Models\Patient;
use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientDrugRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_drug_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Location::class, 'district_id');
            $table->foreignIdFor(Administrator::class, 'created_by');
            $table->foreignIdFor(Patient::class);
            $table->foreignIdFor(DrugCategory::class);
            $table->foreignIdFor(DrugStock::class);
            $table->foreignIdFor(HealthCentre::class);
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
        Schema::dropIfExists('patient_drug_records');
    }
}
