<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiQueryScopes;

class City extends Model
{
    use HasFactory, ApiQueryScopes;

    protected $fillable = ['nombre', 'state_id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function graduates()
    {
        return $this->hasMany(Graduate::class);
    }

    public $allowIncluded = ['state', 'graduates'];
    public $allowFilter = ['id', 'nombre', 'state_id'];
    public $allowSort = ['id', 'nombre', 'state_id'];
    public $allowcount = ['state', 'graduates'];
}
