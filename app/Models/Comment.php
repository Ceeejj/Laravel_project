<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'comment', 
        'product_id',
        'user_id',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id'); // Specify the foreign key
    }

    public function user()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
