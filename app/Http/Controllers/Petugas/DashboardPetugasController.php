<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardPetugasController extends Controller
{
    public function index()
    {

        return Inertia::render('petugas/Dashboard', []);
    }
}
