@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:justify-between items-center mb-10 bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-2xl shadow-sm border border-blue-100">
        <div>
            <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-800 to-indigo-600 tracking-tight mb-2">Document Control Log</h2>
            <p class="text-sm text-gray-500 font-medium">Manage and monitor all your document requests seamlessly.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('ims.document_requests.create') }}" class="group relative inline-flex items-center justify-center px-6 py-3 text-base font-bold text-white transition-all duration-200 bg-gradient-to-r from-blue-600 to-indigo-600 border border-transparent rounded-xl shadow-md hover:from-blue-700 hover:to-indigo-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 overflow-hidden">
                <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                <span class="relative flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Request
                </span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-xl shadow-sm mb-8 flex items-center gap-3 animate-fade-in-down">
        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden transition-all hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-50/80 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Req No</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Document</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Requestor</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($requests as $index => $req)
                    <tr class="hover:bg-blue-50/50 transition-colors duration-200 group">
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="font-semibold text-gray-800">{{ $req->req_number }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($req->request_date)->format('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ $req->type_of_req }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-medium text-gray-800">{{ $req->type_of_doc }}</p>
                            @if($req->doc_title)
                                <p class="text-xs text-gray-500 mt-1 truncate max-w-xs">{{ $req->doc_title }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm">
                                    {{ substr($req->user->username ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800">{{ $req->user->username ?? 'Unknown' }}</div>
                                    <div class="text-xs font-medium text-gray-500">{{ $req->user->departemen ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            @php
                                $statusClass = 'bg-gray-100 text-gray-700 border-gray-200';
                                if($req->status == 'Approved') $statusClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                if($req->status == 'Reject') $statusClass = 'bg-rose-100 text-rose-700 border-rose-200';
                                if($req->status == 'Revise') $statusClass = 'bg-amber-100 text-amber-700 border-amber-200';
                            @endphp
                            <span class="px-3 py-1.5 inline-flex items-center justify-center text-xs font-bold rounded-full border {{ $statusClass }} shadow-sm">
                                @if($req->status == 'Waiting Check...')
                                    <svg class="animate-spin -ml-1 mr-2 h-3 w-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                @endif
                                {{ str_replace('...', '', $req->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap text-right">
                            <a href="{{ route('ims.document_requests.show', $req->id) }}" class="inline-flex items-center justify-center text-sm font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-lg transition-colors border border-blue-100">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="text-base font-medium text-gray-500">Belum ada request dokumen</span>
                                <p class="text-sm text-gray-400 mt-1">Klik tombol Add Request untuk membuat pengajuan baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
