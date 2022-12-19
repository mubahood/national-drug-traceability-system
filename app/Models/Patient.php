<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public function district()
    {
        return $this->belongsTo(Location::class, 'district_id');
    }
 
}
