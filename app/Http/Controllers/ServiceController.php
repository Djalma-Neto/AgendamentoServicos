<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json(Service::all());
    }
    public function store(Request $request)
    {
        $role = $request->header('X-User-Role');

        if ($role !== 'admin') {
            return response()->json(['error' => 'Acesso negado'], 403);
        }

        return Service::create($request->all());
    }
}
