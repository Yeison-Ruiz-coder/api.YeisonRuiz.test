<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiQueryScopes;

class Country extends Model
{
    use HasFactory, ApiQueryScopes;

    protected $fillable = ['nombre'];

    public function states(){
        return $this->hasMany(State::class);
    }

    public $allowIncluded = ['states'];
    public $allowFilter = ['id', 'nombre'];
    public $allowSort = ['id', 'nombre'];
    public $allowcount = ['states'];
}
