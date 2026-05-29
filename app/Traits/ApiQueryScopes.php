<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
/**
 * @property array $allowIncluded
 * @property array $allowFilter
 * @property array $allowFilterStrict
 * @property array $allowFilterDate
 * @property array $allowSort
 * @property array $allowSearch
 */
trait ApiQueryScopes
{
    // =========================================================================
    // 1. INYECCIÓN DE RELACIONES (EAGER LOADING)
    // =========================================================================
    /**
     * MECÁNICA: Evita el problema N+1. Trae tablas conectadas en una sola petición.
     * POSTMAN: ?included=soldiers,company
     * MODELO REQUIERE: public $allowIncluded = ['soldiers', 'company'];
     */
    public function scopeIncluded(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            $root = explode('.', $relationship)[0];
            if (!$allowIncluded->contains($root)) {
                unset($relations[$key]); // Destrucción matemática por seguridad
            }
        }

        $query->with(array_values($relations));
    }

    // =========================================================================
    // 2. CONTEO DE RELACIONES (AGGREGATION)
    // =========================================================================
    /**
     * MECÁNICA: En lugar de traer todos los registros hijos, trae solo la suma total.
     * POSTMAN: ?withCount=soldiers
     * MODELO REQUIERE: public $allowIncluded = ['soldiers']; (Reutilizamos la misma lista)
     * SALIDA: Inyecta un campo 'soldiers_count' con el número entero.
     */
    public function scopeWithCounts(Builder $query)
    {
        if (empty($this->allowIncluded) || empty(request('withCount'))) {
            return;
        }
        $relations = explode(',', request('withCount'));
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }
        $query->withCount($relations);
    }

    // =========================================================================
    // 3. FILTRADO PARCIAL (LIKE)
    // =========================================================================
    /**
     * MECÁNICA: Búsqueda flexible. Encuentra subcadenas de texto.
     * POSTMAN: ?filter[denominacion]=Alfa
     * MODELO REQUIERE: public $allowFilter = ['denominacion'];
     */
    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);

        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }

    // =========================================================================
    // 4. FILTRADO ESTRICTO (EXACT MATCH)
    // =========================================================================
    /**
     * MECÁNICA: Búsqueda matemática exacta. Si no es 100% igual, lo descarta.
     * POSTMAN: ?filterStrict[grado]=Soldado Raso
     * MODELO REQUIERE: public $allowFilterStrict = ['grado', 'id'];
     */
    public function scopeFilterStrict(Builder $query)
    {
        if (empty($this->allowFilterStrict) || empty(request('filterStrict'))) {
            return;
        }
        $filters = request('filterStrict');
        $allowFilterStrict = collect($this->allowFilterStrict);

        foreach ($filters as $filter => $value) {
            if ($allowFilterStrict->contains($filter)) {
                $query->where($filter, '=', $value);
            }
        }
    }

    // =========================================================================
    // 5. FILTRADO TEMPORAL (DATE RANGE)
    // =========================================================================
    /**
     * MECÁNICA: Filtra registros creados o actualizados entre dos fechas.
     * POSTMAN: ?filterDate[created_at]=2026-01-01,2026-12-31
     * MODELO REQUIERE: public $allowFilterDate = ['created_at', 'updated_at'];
     */
    public function scopeFilterDate(Builder $query)
    {
        if (empty($this->allowFilterDate) || empty(request('filterDate'))) {
            return;
        }
        $filters = request('filterDate');
        $allowFilterDate = collect($this->allowFilterDate);

        foreach ($filters as $filter => $value) {
            if ($allowFilterDate->contains($filter)) {
                $dates = explode(',', $value);
                if (count($dates) == 2) {
                    $query->whereBetween($filter, [$dates[0], $dates[1]]);
                }
            }
        }
    }

    // =========================================================================
    // 6. BÚSQUEDA GLOBAL OMNIDIRECCIONAL (OR WHERE)
    // =========================================================================
    /**
     * MECÁNICA: Un solo término busca en múltiples columnas al mismo tiempo.
     * POSTMAN: ?search=Ramirez
     * MODELO REQUIERE: public $allowSearch = ['nombre', 'apellido', 'grado'];
     */
    public function scopeSearch(Builder $query)
    {
        if (empty($this->allowSearch) || empty(request('search'))) {
            return;
        }
        $term = request('search');
        $allowSearch = $this->allowSearch;

        $query->where(function ($q) use ($allowSearch, $term) {
            foreach ($allowSearch as $column) {
                $q->orWhere($column, 'LIKE', '%' . $term . '%');
            }
        });
    }

    // =========================================================================
    // 7. ORDENAMIENTO (SORTING)
    // =========================================================================
    /**
     * MECÁNICA: Ordena los resultados. Soporta múltiples columnas.
     * POSTMAN: ?sort=-id,denominacion (El guion invierte a DESC)
     * MODELO REQUIERE: public $allowSort = ['id', 'denominacion'];
     */
    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }
        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);

        foreach ($sortFields as $sortField) {
            $direction = 'asc';
            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    // =========================================================================
    // 8. RESOLUTOR TERMINAL (PAGINATION)
    // =========================================================================
    /**
     * MECÁNICA: Ejecuta la consulta SQL armada y devuelve los datos.
     * POSTMAN: ?perPage=15
     */
    public function scopeGetOrPaginate(Builder $query)
    {
        if (request('perPage')) {
            $perPage = intval(request('perPage'));
            if ($perPage) {
                return $query->paginate($perPage);
            }
        }
        return $query->get();
    }
}
