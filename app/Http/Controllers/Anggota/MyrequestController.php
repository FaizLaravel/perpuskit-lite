<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMyRequest;
use App\Http\Resources\LoanResource;
use App\Http\Resources\PeminjamanBukuResource;
use App\Models\Book;
use App\Models\Loan;
use App\Models\PeminjamanBuku;
use App\Services\MyRequestService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyrequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $Myrequest = Loan::with('book', 'user')
            ->MyRequest()
            ->search($request->search, $request->column)
            ->sort($request->sortColumn, $request->order)
            ->paginate($request->get('per_page', 7))
            ->withQueryString();

        return Inertia::render('anggota/myrequest/Index', [
            'Myrequest' => $Myrequest,
            'filters' => $request->only('search', 'column', 'sortColumn', 'order', 'status', 'searchBy', 'perPage'),
        ]);
    }

    public function __construct(
        protected MyRequestService $service
    ) {}

    public function store(StoreMyRequest $request)
    {
        try {
            $this->service->cancel(
                $request->id,
                auth()->id()
            );

            return back()->with('success', 'Pengajuan berhasil dibatalkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Loan $pengajuananggota)
    {
        $pengajuananggota->load(['user', 'book']);
        return Inertia::render('anggota/myrequest/Show', [
            'DataMyrequest' => new LoanResource($pengajuananggota),
        ]);
    }
    public function destroy(Loan $pengajuananggota)
    {
        // // Pastikan hanya anggota yang membuat pengajuan yang dapat membatalkan
        // if ($pengajuananggota->users_id !== auth()->id()) {
        //     return response()->json(['success' => 'Unauthorized'], 403);
        // }

        // // Hanya pengajuan dengan status 'pending' yang dapat dibatalkan
        // if (in_array($pengajuananggota->status, ['dipinjam', 'selesai'])) {
        //     return response()->json(['success' => 'Only pending requests can be cancelled'], 400);
        // }

        $pengajuananggota->delete();

        return redirect()->back()->with(['success' => 'Pengajuan pembatalan berhasil.']);
    }
}
