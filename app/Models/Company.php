<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiQueryScopes;

class Company extends Model
{
    use HasFactory, ApiQueryScopes;

    protected $fillable = ['nombre_empresa'];

    public function graduates()
    {
        return $this->belongsToMany(Graduate::class, 'companies_graduates');
    }

    public $allowIncluded = ['graduates'];
    public $allowFilter = ['id', 'nombre_empresa'];
    public $allowSort = ['id', 'nombre_empresa'];
    public $allowcount = ['graduates'];
}
