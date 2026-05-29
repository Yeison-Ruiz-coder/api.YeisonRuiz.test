<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\Graduate;
use App\Models\State;
use App\Models\Title;

class ConsultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Graduate::query()
            ->included()
            ->filter()
            ->sort()
            ->getOrPaginate();
    }

    public function show(Graduate $graduate)
    {
        if (request('included')) {
            $graduate->load(...explode(',', request('included')));
        }
        return response()->json($graduate);
    }

    public function destroy(Graduate $graduate)
    {
        $graduate->delete();
        return response()->json(null, 204);
    }
}
