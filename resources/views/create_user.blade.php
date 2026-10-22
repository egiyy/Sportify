@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="mb-3">
                <a href="{{ route('user.index') }}" class="text-decoration-none text-muted d-inline-flex align-items-center gap-1 small fw-semibold">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pengguna
                </a>
            </div>

            <div class="card card-custom overflow-hidden">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="card-title mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus-fill text-warning"></i>
                        <span>Buat Pengguna Baru</span>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Mahasiswa <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nama" 
                                   name="nama" 
                                   placeholder="Masukkan nama lengkap" 
                                   value="{{ old('nama') }}" 
                                   required>
                        </div>

                        <!-- NPM -->
                        <div class="mb-3">
                            <label for="npm" class="form-label fw-semibold">NPM <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="npm" 
                                   name="npm" 
                                   placeholder="Contoh: 2417051016" 
                                   value="{{ old('npm') }}" 
                                   required>
                        </div>

                        <!-- Kelas -->
                        <div class="mb-4">
                            <label for="kelas_id" class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select" name="kelas_id" id="kelas_id" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                @foreach ($kelas as $kelasItem)
                                    <option value="{{ $kelasItem->id }}" {{ old('kelas_id') == $kelasItem->id ? 'selected' : '' }}>
                                        {{ $kelasItem->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between gap-2 pt-2 border-top">
                            <a href="{{ route('user.index') }}" class="btn btn-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                <i class="bi bi-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
