<?php

namespace App\Http\Controllers\IMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use Illuminate\Support\Facades\Auth;

class DocumentRequestController extends Controller
{
    /**
     * Display a listing of the requests (Monitoring View).
     */
    public function index()
    {
        $user = Auth::user();
        
        // Logika query berdasarkan Role/Jabatan
        if (strtoupper($user->departemen) === 'IMS') {
            // IMS bisa melihat semua data
            $requests = DocumentRequest::with('user')->orderBy('created_at', 'desc')->get();
        } elseif ($user->jabatan === 'dept_head') {
            // Manager (dept_head) hanya bisa melihat request dari departemennya
            $requests = DocumentRequest::with('user')
                ->whereHas('user', function($q) use ($user) {
                    $q->where('departemen', $user->departemen);
                })
                ->orderBy('created_at', 'desc')->get();
        } else {
            // User biasa melihat request milik mereka atau departemennya sendiri
            $requests = DocumentRequest::with('user')
                ->whereHas('user', function($q) use ($user) {
                    $q->where('departemen', $user->departemen);
                })
                ->orderBy('created_at', 'desc')->get();
        }

        return view('ims.document_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new request (Add Data).
     */
    public function create()
    {
        return view('ims.document_requests.create');
    }

    /**
     * Store a newly created request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_of_req' => 'required',
            'type_of_doc' => 'required',
            'file_upload' => 'required|mimes:pdf|max:10240', // Wajib PDF, max 10MB
        ]);

        $user = Auth::user();

        // Generate Req Number otomatis (contoh: REQ-DC-202310-001)
        $monthYear = date('Ym');
        $lastReq = DocumentRequest::where('req_number', 'LIKE', "REQ-DC-{$monthYear}-%")->orderBy('id', 'desc')->first();
        $sequence = $lastReq ? ((int) substr($lastReq->req_number, -3)) + 1 : 1;
        $reqNumber = "REQ-DC-{$monthYear}-" . str_pad($sequence, 3, '0', STR_PAD_LEFT);

        // Upload File
        $filePath = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan di storage/app/public/ims_documents
            $filePath = $file->storeAs('ims_documents', $filename, 'public');
        }

        DocumentRequest::create([
            'req_number' => $reqNumber,
            'request_date' => now()->toDateString(),
            'user_id' => $user->id,
            'type_of_req' => $request->type_of_req,
            'revision_number' => $request->revision_number,
            'type_of_doc' => $request->type_of_doc,
            'doc_number' => $request->doc_number,
            'doc_title' => $request->doc_title,
            'detail_before' => $request->detail_before,
            'detail_after' => $request->detail_after,
            'file_path' => $filePath,
            'status' => 'Waiting Check...',
        ]);

        return redirect()->route('ims.document_requests.index')->with('success', 'Document Request berhasil disubmit!');
    }

    /**
     * Show the detailed view of a document request.
     */
    public function show($id)
    {
        $request = DocumentRequest::with('user')->findOrFail($id);
        $histories = \App\Models\ApprovalHistory::with('approver')->where('document_request_id', $id)->orderBy('created_at', 'asc')->get();
        return view('ims.document_requests.show', compact('request', 'histories'));
    }

    /**
     * Handle the approval/rejection/revision logic.
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Reject,Revise',
            'remarks' => 'nullable|string',
        ]);

        $docRequest = DocumentRequest::findOrFail($id);
        $user = Auth::user();

        // Determine step based on user departemen
        $step = 'Manager';
        if (strtoupper($user->departemen) === 'IMS') {
            $step = 'DC Center';
        }

        // Logic for Revise Limit
        if ($request->status === 'Revise') {
            if ($docRequest->revision_count >= 2) {
                return back()->with('error', 'Dokumen sudah mencapai batas maksimal revisi (2x) dan tidak bisa direvisi lagi.');
            }
            $docRequest->revision_count += 1;
        }

        // Save approval history
        \App\Models\ApprovalHistory::create([
            'document_request_id' => $docRequest->id,
            'approver_id' => $user->id,
            'step' => $step,
            'status' => $request->status,
            'remarks' => $request->remarks,
        ]);

        // Update Document Request status
        // If DC Center approves, we might mark it as Complete. For now, keep it simple.
        if ($step === 'DC Center' && $request->status === 'Approved') {
            $docRequest->status = 'Complete';
        } else {
            $docRequest->status = $request->status;
        }
        
        $docRequest->save();

        return redirect()->route('ims.document_requests.show', $id)->with('success', 'Status berhasil diupdate menjadi ' . $request->status);
    }
}
