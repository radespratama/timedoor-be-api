<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'address'
    ];

    protected $table = 'brands';

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}