<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'task_description',
        'product_image',
        'category_id',
        'task_date',
        'comment',
        'is_deleted'
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

}
