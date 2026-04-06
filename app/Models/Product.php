<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'price',
        'description',
        'status',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
}

}

