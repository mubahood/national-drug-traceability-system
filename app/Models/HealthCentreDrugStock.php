<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCentreDrugStock extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($m) {
            die("Ooops! You cannot delete this item.");
        });
        self::creating(function ($m) {
            HealthCentreDrugStock::my_update($m);
            return $m;
        });
        self::updating(function ($m) {
            HealthCentreDrugStock::my_update($m);
            return $m;
        });
    }


    public static function my_update($m)
    {

        $districtDrug = DistrictDrugStock::find($m->district_drug_stock_id);

        if ($districtDrug == null) {
            die("Stock not found.");
        }

        $m->drug_category_id = $districtDrug->drug_category_id;
        if (isset($m->original_quantity_temp)) {
            if ($districtDrug->drug_stock->drug_state == 'Solid') {
                $m->original_quantity = ($m->original_quantity_temp * 1000000);
                $m->current_quantity = $m->original_quantity;
            } else  if ($districtDrug->drug_stock->drug_state == 'Liquid') {
                $m->original_quantity = ($m->original_quantity_temp * 1000);
                $m->current_quantity = $m->original_quantity;
            } else {
                die("Drug stock not found.");
            }


            if ($m->original_quantity > $districtDrug->current_quantity) {
                die("Transfer failed because of insufitient sotck.");
            }

            unset($m->original_quantity_temp);

            $m->drug_category_id = $districtDrug->drug_category_id;
            $m->drug_stock_id = $districtDrug->drug_stock_id;
            $m->district_id = $districtDrug->district_id;
            $m->current_quantity = $m->original_quantity;

            $districtDrug->current_quantity = $districtDrug->current_quantity - $m->original_quantity;
            $districtDrug->save();
        }

        return $m;
    }

    public function drug_category()
    {
        return $this->belongsTo(DrugCategory::class);
    }
    public function drug_stock()
    {
        return $this->belongsTo(DrugStock::class);
    }
    public function district()
    {
        return $this->belongsTo(Location::class, 'district_id');
    } 

    public function health_centre()
    { 
        return $this->belongsTo(HealthCentre::class, 'health_centre_id');
    } 
}
