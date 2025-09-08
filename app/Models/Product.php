<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['sku', 'name'];

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
