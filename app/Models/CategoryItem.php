<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function masterItems(): BelongsToMany
    {
        return $this->belongsToMany(MasterItem::class, "items_categories");
    }
}
