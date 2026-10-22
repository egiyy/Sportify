@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-dark">Daftar Pengguna</h2>
            <p class="text-muted mb-0">Manajemen data mahasiswa praktikum Pemrograman Web Lanjut.</p>
        </div>
        <div>
            <a href="{{ route('user.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-person-plus-fill"></i>
                <span>Tambah Pengguna</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card card-custom overflow-hidden">
        <div class="card-body p-0">
            <x-user-table :users="$users" />
        </div>
    </div>
</div>
@endsection
