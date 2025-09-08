<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['code', 'name'];

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
