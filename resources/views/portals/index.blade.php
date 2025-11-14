@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="container mt-4">
            @foreach ($portals as $portal)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5>{{ $portal->portal_name }}</h5>
                        <p>{{ $portal->portal_url }}</p>

                        <form id="form-{{ $portal->id }}" onsubmit="loginToPortal(event, {{ $portal->id }})">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                🔗 Masuk ke {{ $portal->portal_name }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<script>
    function loginToPortal(event, id) {
        event.preventDefault();
        const form = document.getElementById('form-' + id);
        const formData = new FormData(form);

        fetch(`/proxy-login/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.redirect_url) {
                    window.open(data.redirect_url, '_blank');
                } else {
                    alert(data.message || 'Login gagal');
                }
            })
            .catch(err => {
                alert('Terjadi kesalahan saat login');
                console.error(err);
            });
    }
</script>
@endsection