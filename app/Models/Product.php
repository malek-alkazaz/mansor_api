<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'price' , 'description','quantity','image','image_qr', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'image' => 'array',
    ];
}
