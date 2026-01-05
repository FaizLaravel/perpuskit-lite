<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Http\Resources\PeminjamanBukuResource;
use App\Models\Book;
use App\Models\Loan;
use App\Models\PeminjamanBuku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoanStatusController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $LoanStatus = Loan::with('user', 'book')
            ->search($request->search, $request->column)
            ->filterStatus($request->status)
            ->sort($request->sortColumn, $request->order)
            ->paginate($request->get('perPage', 7))
            ->withQueryString();

        return Inertia::render('petugas/loanstatus/Index', [
            'LoanStatus' => $LoanStatus,
            'filters' => $request->only('search', 'column', 'sortColumn', 'order', 'status', 'perPage', 'searchBy')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $statuspeminjaman)
    {
        $statuspeminjaman->load(['user', 'book']);
        return Inertia::render('petugas/loanstatus/Show', [
            'LoanStatus' => new LoanResource($statuspeminjaman),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
