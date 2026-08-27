@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:justify-between items-center mb-8 bg-gradient-to-r from-blue-600 to-indigo-700 p-8 rounded-3xl shadow-lg border border-blue-500/30 relative overflow-hidden">
        <!-- Decorative background elements -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-5 mix-blend-overlay"></div>
        <div class="absolute bottom-0 right-32 -mb-12 w-40 h-40 rounded-full bg-white opacity-10 mix-blend-overlay"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold text-white tracking-tight mb-2">IMS Document Control Dashboard</h2>
            <p class="text-blue-100 font-medium">Real-time overview of document requests and approvals.</p>
        </div>
        <div class="mt-6 md:mt-0 relative z-10 flex gap-4">
            <a href="{{ route('ims.document_requests.index') }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl backdrop-blur-md border border-white/20 transition-all">
                View All Requests
            </a>
            <a href="{{ route('ims.document_requests.create') }}" class="px-6 py-3 bg-white text-blue-700 hover:bg-blue-50 font-bold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Request
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Requests -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $totalRequests }}</h3>
            <p class="text-sm text-gray-500 font-medium mt-1">Total Document Requests</p>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-amber-50 p-3 rounded-xl text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $pendingCount }}</h3>
            <p class="text-sm text-gray-500 font-medium mt-1">Waiting & Revise Status</p>
        </div>

        <!-- Approved -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-emerald-50 p-3 rounded-xl text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Approved</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $approvedCount }}</h3>
            <p class="text-sm text-gray-500 font-medium mt-1">DC Center processing</p>
        </div>

        <!-- Completed -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex justify-between items-start mb-4">
                <div class="bg-indigo-50 p-3 rounded-xl text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Complete</span>
            </div>
            <h3 class="text-3xl font-extrabold text-gray-800">{{ $completedCount }}</h3>
            <p class="text-sm text-gray-500 font-medium mt-1">Fully finalized documents</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Stats / Recent List -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Recent Document Requests
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="pb-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Request</th>
                                <th class="pb-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Type</th>
                                <th class="pb-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="pb-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($recentRequests as $req)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-4">
                                    <p class="font-bold text-gray-800 text-sm">{{ $req->req_number }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $req->user->username ?? 'Unknown' }} - {{ \Carbon\Carbon::parse($req->request_date)->diffForHumans() }}</p>
                                </td>
                                <td class="py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600">
                                        {{ $req->type_of_req }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    @php
                                        $statusClass = 'bg-gray-100 text-gray-700';
                                        if($req->status == 'Approved') $statusClass = 'bg-emerald-100 text-emerald-700';
                                        if($req->status == 'Reject') $statusClass = 'bg-rose-100 text-rose-700';
                                        if($req->status == 'Revise') $statusClass = 'bg-amber-100 text-amber-700';
                                        if($req->status == 'Complete') $statusClass = 'bg-indigo-100 text-indigo-700';
                                    @endphp
                                    <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider rounded-md {{ $statusClass }}">
                                        {{ str_replace('...', '', $req->status) }}
                                    </span>
                                </td>
                                <td class="py-4 text-right">
                                    <a href="{{ route('ims.document_requests.show', $req->id) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Review &rarr;</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400 text-sm">No recent requests found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-8">
            <!-- Mini Master Doc Stat -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 shadow-sm text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-6 opacity-20">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="relative z-10">
                    <h4 class="text-gray-300 font-medium text-sm mb-1">Master Documents</h4>
                    <p class="text-4xl font-extrabold tracking-tight mb-4">{{ $totalMasterDocs }}</p>
                    <p class="text-xs text-gray-400">Total active documents currently managed in the IMS Center.</p>
                </div>
            </div>

            <!-- Distribution Box -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-base font-bold text-gray-800 mb-6 border-b border-gray-100 pb-4">Request Distribution</h3>
                <div class="space-y-4">
                    @forelse($typeOfReqStats as $type => $count)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full @if($type=='New Doc') bg-blue-500 @elseif($type=='Revise') bg-amber-500 @else bg-rose-500 @endif"></div>
                            <span class="text-sm font-medium text-gray-600">{{ $type }}</span>
                        </div>
                        <span class="text-sm font-bold text-gray-800">{{ $count }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-gray-400">No data available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
