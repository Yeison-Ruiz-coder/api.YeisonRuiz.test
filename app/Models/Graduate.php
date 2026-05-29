<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiQueryScopes;

class Graduate extends Model
{
    use HasFactory, ApiQueryScopes;

    protected $fillable = ['nombre', 'fecha_nacimiento', 'telefono', 'direccion', 'correo', 'nombre_FB', 'city_id'];

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'areas_graduates');
    }

    public function titles()
    {
        return $this->belongsToMany(Title::class, 'graduates_titles');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_graduates');
    }

    public $allowIncluded = ['areas', 'titles', 'companies'];
    public $allowFilter = ['id', 'nombre', 'fecha_nacimiento', 'telefono', 'direccion', 'correo', 'nombre_FB', 'city_id'];
    public $allowSort = ['id', 'nombre', 'fecha_nacimiento', 'telefono', 'direccion', 'correo', 'nombre_FB', 'city_id'];
    public $allowcount = ['areas', 'titles', 'companies'];
}
