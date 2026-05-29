<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiQueryScopes;

class State extends Model
{
    use HasFactory, ApiQueryScopes;

    protected $fillable = ['nombre', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public $allowIncluded = ['country', 'cities'];
    public $allowFilter = ['id', 'nombre', 'country_id'];
    public $allowSort = ['id', 'nombre', 'country_id'];
    public $allowcount = ['country', 'cities'];
}
