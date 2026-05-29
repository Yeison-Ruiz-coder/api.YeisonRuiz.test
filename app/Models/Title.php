<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiQueryScopes;

class Title extends Model
{
    use HasFactory, ApiQueryScopes;

    protected $fillable = ['nombre_titulo'];

    public function graduates()
    {
        return $this->belongsToMany(Graduate::class, 'graduates_titles');
    }

    public $allowIncluded = ['graduates'];
    public $allowFilter = ['id', 'nombre_titulo'];
    public $allowSort = ['id', 'nombre_titulo'];
    public $allowcount = ['graduates'];
}
