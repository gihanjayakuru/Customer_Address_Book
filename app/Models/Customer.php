<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
