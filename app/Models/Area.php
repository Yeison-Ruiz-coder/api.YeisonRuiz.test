<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiQueryScopes;

class Area extends Model
{
    use HasFactory, ApiQueryScopes;

    protected $fillable = ['nombre_area'];

    public function graduates()
    {
        return $this->belongsToMany(Graduate::class, 'areas_graduates');
    }

    public $allowIncluded = ['graduates'];
    public $allowFilter = ['id', 'nombre_area'];
    public $allowSort = ['id', 'nombre_area'];
    public $allowcount = ['graduates'];
}
