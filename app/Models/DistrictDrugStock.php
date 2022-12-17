<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictDrugStock extends Model
{
    use HasFactory;


    public static function boot()
    {
        parent::boot();
        self::deleting(function ($m) {
            die("Ooops! You cannot delete this item.");
        });
        self::creating(function ($m) {
            DistrictDrugStock::my_update($m);
            return $m;
        });
        self::updating(function ($m) {
            DistrictDrugStock::my_update($m);
            return $m;
        });
    }

    public static function my_update($m)
    {

        $mainStock = DrugStock::find($m->drug_stock_id);
        if ($mainStock == null) {
            die("Stock not found.");
        }
        $m->drug_category_id = $mainStock->drug_category_id;
        if (isset($m->original_quantity_temp)) {
            if ($mainStock->drug_state == 'Solid') {
                $m->original_quantity = ($m->original_quantity_temp * 1000000);
                $m->current_quantity = $m->original_quantity;
            } else  if ($mainStock->drug_state == 'Liquid') {
                $m->original_quantity = ($m->original_quantity_temp * 1000);
                $m->current_quantity = $m->original_quantity;
            }
            if ($m->original_quantity > $mainStock->current_quantity) {
                die("Transfer failed because of insufitient sotck.");
            }

            $mainStock->current_quantity = $mainStock->current_quantity - $m->original_quantity;
            $mainStock->save();

            unset($m->original_quantity_temp);
        }

        return $m;
    }

    public   function drug_category()
    {
        return $this->belongsTo(DrugCategory::class);
    }

    public   function drug_stock()
    {
        return $this->belongsTo(DrugStock::class);
    }


    public function getCurrentQuantityTextAttribute()
    {
        return Utils::quantity_convertor($this->current_quantity, $this->drug_stock->drug_state);
    }


    protected $appends = [
        'current_quantity_text',
    ];
}
