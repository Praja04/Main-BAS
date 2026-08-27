@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-8 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-4">Request For Document Creation / Revision</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ims.document_requests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Info Requestor Auto -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Req Date</label>
                    <input type="text" value="{{ date('Y-m-d') }}" readonly class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Name</label>
                    <input type="text" value="{{ Auth::user()->nama_lengkap ?? 'Unknown' }}" readonly class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Dept</label>
                    <input type="text" value="{{ Auth::user()->departemen ?? '-' }}" readonly class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Div</label>
                    <input type="text" value="{{ Auth::user()->bagian ?? '-' }}" readonly class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 cursor-not-allowed">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Type of Req <span class="text-red-500">*</span></label>
                <select name="type_of_req" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">-- Select Type --</option>
                    <option value="New Doc">New Doc.</option>
                    <option value="Revise">Revise</option>
                    <option value="Obsolete">Obsolete</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Revision Number (If Revise)</label>
                <input type="number" name="revision_number" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" placeholder="e.g. 1">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Type of Doc <span class="text-red-500">*</span></label>
                <select name="type_of_doc" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                    <option value="">-- Select Document Type --</option>
                    <option value="Form Digital">Form Digital</option>
                    <option value="Logbook">Logbook</option>
                    <option value="SOP">SOP</option>
                    <option value="Form Manual">Form Manual</option>
                    <option value="Manual">Manual</option>
                    <option value="WI">WI</option>
                    <option value="Hazard Analysis">Hazard Analysis</option>
                    <option value="Risk Analysis">Risk Analysis</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Doc. Number</label>
                <input type="text" name="doc_number" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" placeholder="e.g. SOP-IT-001">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Doc. Title</label>
                <input type="text" name="doc_title" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500" placeholder="Document Title">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Detail (Before)</label>
                    <textarea name="detail_before" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Detail (After)</label>
                    <textarea name="detail_after" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500"></textarea>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Upload File (PDF Only) <span class="text-red-500">*</span></label>
                <input type="file" name="file_upload" accept=".pdf" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                <p class="text-sm text-gray-500 mt-1">Format PDF, maksimal 10MB.</p>
            </div>

            <div class="flex justify-end mt-8">
                <a href="{{ route('ims.document_requests.index') }}" class="text-gray-600 border border-gray-300 px-6 py-2 rounded hover:bg-gray-100 mr-4">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Submit Request</button>
            </div>
        </form>
    </div>
</div>
@endsection
