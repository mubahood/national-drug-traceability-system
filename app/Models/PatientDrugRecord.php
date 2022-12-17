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

            
            ($HealthCentreDrugStock->drug_stock->drug_packaging_unit_quantity*);
            dd();


            dd($HealthCentreDrugStock);
            /* 
                "id" => 1
    "created_at" => "2022-12-17 09:32:30"
    "updated_at" => "2022-12-17 09:32:30"
    "drug_category_id" => 289
    "drug_stock_id" => 1
    "district_id" => 88
    "created_by" => 11
    "health_centre_id" => 1
    "original_quantity" => 2000000
    "current_quantity" => 2000000
    "district_drug_stock_id" => 1
            */


            $rec->health_centre_drug_stock_id = 1;
            $rec->quantity = 5;


            die("One love.");
        });
    }
}
