<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
	public function variants()
    {
        return $this->belongsTo(Variant::class);
    }
}
