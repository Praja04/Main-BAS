@extends('layouts.app')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
                <p class="text-sm text-gray-500">Manage system users and their roles</p>
            </div>
            <button onclick="openModal('create')"
                class="bg-primary hover:bg-primary-container text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-all">
                <x-heroicon-o-plus class="w-4 h-4" />
                Add User
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <table id="userTable" class="w-full text-left text-sm">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-4 py-3 border-b">User</th>
                        <th class="px-4 py-3 border-b">Role</th>
                        <th class="px-4 py-3 border-b">NIK</th>
                        <th class="px-4 py-3 border-b">Department</th>
                        <th class="px-4 py-3 border-b">Position</th>
                        <th class="px-4 py-3 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- User Modal -->
    <div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-2xl w-full max-w-2xl mx-4 overflow-hidden shadow-2xl transform transition-all">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 id="modalTitle" class="text-lg font-bold text-gray-800">Add User</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>
            <form id="userForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="userId" name="id">
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[70vh] overflow-y-auto">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Username</label>
                        <input type="text" name="username" id="username"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Password</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            placeholder="Enter password">
                        <p id="passwordHelp" class="text-[10px] text-gray-400 mt-1 hidden">Leave blank to keep current
                            password</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Role</label>
                        <select name="role" id="role"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">NIK</label>
                        <input type="text" name="nik" id="nik"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Position (Jabatan)</label>
                        <select name="jabatan" id="jabatan"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                            <option value="dept_head">Dept Head</option>
                            <option value="foreman">Foreman</option>
                            <option value="supervisor">Supervisor</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Department</label>
                        <input type="text" name="departemen" id="departemen"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Section (Bagian)</label>
                        <input type="text" name="bagian" id="bagian"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition-all"
                            required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Profile Image</label>
                        <input type="file" name="image" id="image"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all">Cancel</button>
                    <button type="submit"
                        class="bg-primary hover:bg-primary-container text-white px-6 py-2 rounded-lg text-sm font-semibold shadow-sm transition-all">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let table;
        const iconEdit = `@svg('heroicon-o-pencil-square', 'w-5 h-5')`;
        const iconTrash = `@svg('heroicon-o-trash', 'w-5 h-5')`;

        $(document).ready(function() {
            table = $('#userTable').DataTable({
                ajax: {
                    url: "{{ route('users.get') }}",
                    dataSrc: ""
                },
                columns: [{
                        data: null,
                        render: function(data) {
                            const img = data.image ? `/uploads/users/${data.image}` :
                                '/assets/images/user.png';
                            return `
                            <div class="flex items-center gap-3">
                                <img src="${img}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                <div>
                                    <p class="font-semibold text-gray-900">${data.username}</p>
                                    <p class="text-[10px] text-gray-400">${data.email}</p>
                                </div>
                            </div>
                        `;
                        }
                    },
                    {
                        data: 'role',
                        render: function(data) {
                            const color = data === 'admin' ?
                                'bg-purple-50 text-purple-600 border-purple-100' :
                                'bg-blue-50 text-blue-600 border-blue-100';
                            return `<span class="px-2 py-0.5 rounded-full text-[10px] font-bold border uppercase ${color}">${data}</span>`;
                        }
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'departemen'
                    },
                    {
                        data: 'jabatan',
                        render: function(data) {
                            return data ? data.replace('_', ' ').toUpperCase() : '-';
                        }
                    },
                    {
                        data: 'id',
                        render: function(id) {
                            return `
                            <div class="flex gap-2">
                                <button onclick="openModal('edit', ${id})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                    ${iconEdit}
                                </button>
                                <button onclick="deleteUser(${id})" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                    ${iconTrash}
                                </button>
                            </div>
                        `;
                        }
                    }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search users...",
                    lengthMenu: "_MENU_",
                },
                dom: '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>'
            });

            // Form Submit
            $('#userForm').on('submit', function(e) {
                e.preventDefault();
                const id = $('#userId').val();
                const url = id ? `/users/${id}` : '/users';
                const formData = new FormData(this);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire('Success', res.success, 'success');
                        closeModal();
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let msg = '';
                        for (let key in errors) {
                            msg += errors[key][0] + '<br>';
                        }
                        Swal.fire('Error', msg, 'error');
                    }
                });
            });
        });

        function openModal(mode, id = null) {
            $('#userForm')[0].reset();
            $('#userId').val('');
            $('#password').attr('required', true);
            $('#passwordHelp').addClass('hidden');

            if (mode === 'create') {
                $('#modalTitle').text('Add New User');
            } else {
                $('#modalTitle').text('Edit User');
                $('#password').removeAttr('required');
                $('#passwordHelp').removeClass('hidden');
                $.get(`/users/${id}/edit`, function(user) {
                    $('#userId').val(user.id);
                    $('#username').val(user.username);
                    $('#nama_lengkap').val(user.nama_lengkap);
                    $('#email').val(user.email);
                    $('#role').val(user.role);
                    $('#nik').val(user.nik);
                    $('#jabatan').val(user.jabatan);
                    $('#departemen').val(user.departemen);
                    $('#bagian').val(user.bagian);
                });
            }
            $('#userModal').removeClass('hidden').addClass('flex');
        }

        function closeModal() {
            $('#userModal').addClass('hidden').removeClass('flex');
        }

        function deleteUser(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/users/${id}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            Swal.fire('Deleted!', res.success, 'success');
                            table.ajax.reload();
                        }
                    });
                }
            });
        }
    </script>
@endsection

@section('styles')
    <style>
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.4rem 1rem;
            outline: none;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.4rem 2rem 0.4rem 1rem;
            outline: none;
        }

        table.dataTable thead th {
            padding: 12px 16px;
        }

        table.dataTable tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
        }
    </style>
@endsection
