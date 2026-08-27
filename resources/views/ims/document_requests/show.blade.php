@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <div class="mb-6">
        <a href="{{ route('ims.document_requests.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Document Log
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl shadow-sm mb-6 flex items-center gap-3">
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Request Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-6 pb-6 border-b border-gray-100">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $request->req_number }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Requested on {{ \Carbon\Carbon::parse($request->request_date)->format('d M Y') }}</p>
                    </div>
                    @php
                        $statusClass = 'bg-gray-100 text-gray-700 border-gray-200';
                        if($request->status == 'Approved') $statusClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                        if($request->status == 'Reject') $statusClass = 'bg-rose-100 text-rose-700 border-rose-200';
                        if($request->status == 'Revise') $statusClass = 'bg-amber-100 text-amber-700 border-amber-200';
                        if($request->status == 'Complete') $statusClass = 'bg-blue-100 text-blue-700 border-blue-200';
                    @endphp
                    <span class="mt-4 sm:mt-0 px-4 py-2 rounded-full text-sm font-bold border {{ $statusClass }}">
                        Status: {{ $request->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-y-6 gap-x-8">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Requestor</h3>
                        <p class="text-base font-medium text-gray-800">{{ $request->user->username ?? 'Unknown' }}</p>
                        <p class="text-sm text-gray-500">{{ $request->user->departemen ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Request Type</h3>
                        <p class="text-base font-medium text-gray-800">{{ $request->type_of_req }}</p>
                        @if($request->revision_number)
                            <p class="text-sm text-gray-500">Rev: {{ $request->revision_number }}</p>
                        @endif
                        @if($request->revision_count > 0)
                            <p class="text-xs text-amber-600 font-semibold mt-1">Revised {{ $request->revision_count }} times (Max 2)</p>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Document Type</h3>
                        <p class="text-base font-medium text-gray-800">{{ $request->type_of_doc }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Doc. Title / Number</h3>
                        <p class="text-base font-medium text-gray-800">{{ $request->doc_title ?? '-' }}</p>
                        <p class="text-sm text-gray-500">{{ $request->doc_number ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Revision Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-600 mb-2">Detail Before</h4>
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $request->detail_before ?? '-' }}</p>
                        </div>
                        <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100">
                            <h4 class="text-sm font-semibold text-blue-800 mb-2">Detail After</h4>
                            <p class="text-sm text-blue-900 whitespace-pre-line">{{ $request->detail_after ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                @if($request->file_path)
                <div class="mt-8 p-5 bg-gray-50 rounded-xl border border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-red-100 p-3 rounded-lg text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-800">Attached Document</p>
                            <p class="text-xs text-gray-500">PDF File Format</p>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $request->file_path) }}" target="_blank" class="px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors shadow-sm">
                        View File
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Action & Timeline -->
        <div class="space-y-6">
            @php
                $user = Auth::user();
                $isManager = ($user->jabatan === 'dept_head') && $user->departemen === $request->user->departemen;
                $isIMS = strtoupper($user->departemen) === 'IMS';
                
                // Manager butuh action jika status masih 'Waiting Check...' atau 'Revise'
                $managerNeedsAction = $isManager && in_array($request->status, ['Waiting Check...', 'Revise']);
                
                // IMS butuh action jika status sudah 'Approved' oleh Manager
                $imsNeedsAction = $isIMS && $request->status === 'Approved';

                $showApprovalForm = $managerNeedsAction || $imsNeedsAction;
            @endphp

            @if($showApprovalForm)
            <div class="bg-white rounded-2xl shadow-sm border border-blue-200 p-6 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
                <h3 class="text-lg font-bold text-gray-800 mb-4 mt-2">Approval Action</h3>
                <form action="{{ route('ims.document_requests.approve', $request->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Decision</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                            <option value="">-- Select Decision --</option>
                            <option value="Approved">Approve</option>
                            <option value="Revise">Revise</option>
                            <option value="Reject">Reject</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks / Comments</label>
                        <textarea name="remarks" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Required for Revise/Reject..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                        Submit Decision
                    </button>
                </form>
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Approval Timeline</h3>
                
                <div class="relative border-l-2 border-gray-100 ml-3 space-y-8">
                    <!-- Initial Request Node -->
                    <div class="relative">
                        <div class="absolute -left-[21px] bg-blue-500 w-4 h-4 rounded-full border-4 border-white shadow-sm"></div>
                        <div class="pl-6">
                            <p class="text-sm font-bold text-gray-800">Request Created</p>
                            <p class="text-xs font-medium text-gray-500">{{ $request->user->username ?? 'System' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($request->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <!-- Histories -->
                    @foreach($histories as $history)
                    <div class="relative">
                        @php
                            $dotColor = 'bg-gray-400';
                            if($history->status == 'Approved' || $history->status == 'Complete') $dotColor = 'bg-emerald-500';
                            if($history->status == 'Reject') $dotColor = 'bg-rose-500';
                            if($history->status == 'Revise') $dotColor = 'bg-amber-500';
                        @endphp
                        <div class="absolute -left-[21px] {{ $dotColor }} w-4 h-4 rounded-full border-4 border-white shadow-sm"></div>
                        <div class="pl-6">
                            <p class="text-sm font-bold text-gray-800">{{ $history->status }} by {{ $history->step }}</p>
                            <p class="text-xs font-medium text-gray-500">{{ $history->approver->username ?? 'Unknown' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($history->created_at)->format('d M Y, H:i') }}</p>
                            @if($history->remarks)
                                <div class="mt-2.5 p-3 bg-gray-50 rounded-lg border border-gray-100 text-sm text-gray-700 italic">
                                    "{{ $history->remarks }}"
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach

                    @if($request->status == 'Complete')
                    <div class="relative">
                        <div class="absolute -left-[21px] bg-blue-600 w-4 h-4 rounded-full border-4 border-white shadow-sm flex items-center justify-center">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                        <div class="pl-6">
                            <p class="text-sm font-bold text-blue-600">Document Finalized</p>
                            <p class="text-xs text-gray-500 mt-0.5">The document control process is complete.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
