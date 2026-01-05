<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardAnggotaController extends Controller
{
    public function index()
    {

        return Inertia::render('anggota/Dashboard', []);
    }
}
