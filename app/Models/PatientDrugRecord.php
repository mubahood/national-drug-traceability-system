<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDrugRecord extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($m) {

            $p = new Patient();
            if ($m->is_new_patient == 'Yes') {
                $p->name = $m->patient_name;
                $p->sex = $m->patient_sex;
                $p->address = $m->patient_address;
                $p->phone_number = $m->patient_phone_number;
                $p->nin = $m->nin;
                $p->fingerprint = $m->fingerprint;
                $p->district_id = $m->patient_district_id;

                $pat = Patient::where([
                    'fingerprint' => $p->fingerprint
                ])->orWhere([
                    'nin' => $p->nin
                ])->first();
                if ($pat == null) {
                    $p->save();
                } else {
                    $p = $pat;
                }
            } else {
                $pat = Patient::where([
                    'fingerprint' => $m->fingerprint
                ])->orWhere([
                    'nin' => $m->nin
                ])->first();
                if ($pat == null) {
                    die("Patient not found.");
                } else {
                    $p = $pat;
                }
            }

            if($p == null){
                die('Patient not found.');
            }
            $m->patient_id = $p->id;

            unset($m->is_new_patient);
            unset($m->patient_name);
            unset($m->patient_sex);
            unset($m->patient_address);
            unset($m->patient_phone_number);
            unset($m->fingerprint);
            unset($m->nin);
            unset($m->patient_district_id);

            $HealthCentreDrugStock = HealthCentreDrugStock::find($m->health_centre_drug_stock_id);
            if ($HealthCentreDrugStock == null) {
                die("Health Centre Stock not found.");
            }


            $m->quantity =  ($HealthCentreDrugStock->drug_stock->drug_packaging_unit_quantity * $m->quantity);
            if ($m->quantity > $HealthCentreDrugStock->current_quantity) {
                die("Failed because of insufficient amount of drugs available.");
            }

            $HealthCentreDrugStock->current_quantity = $HealthCentreDrugStock->current_quantity - $m->quantity;
            
            $m->drug_category_id = $HealthCentreDrugStock->drug_stock->drug_category_id;
            $m->drug_stock_id = $HealthCentreDrugStock->drug_stock->id;
            $m->district_id = $HealthCentreDrugStock->district_id;
            $m->health_centre_id = $HealthCentreDrugStock->health_centre_id;
            $m->district_drug_stock_id = $HealthCentreDrugStock->district_drug_stock_id;
            $m->health_centre_drug_stock_id = $HealthCentreDrugStock->id;
            $HealthCentreDrugStock->save();

            return $m;
        });
    }
}
