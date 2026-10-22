<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle mb-0">
        <thead class="table-dark">
            <tr>
                <th scope="col" style="width: 70px;" class="text-center">No</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">NPM</th>
                <th scope="col" class="text-center">Kelas</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($users) && count($users) > 0)
                @foreach($users as $user)
                    <tr>
                        <td class="text-center fw-semibold text-muted">{{ $loop->iteration }}</td>
                        <td class="fw-semibold text-dark">{{ $user->nama }}</td>
                        <td>
                            <span class="badge bg-light text-dark border font-monospace px-2 py-1 fs-6">
                                {{ $user->nim ?? $user->npm }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                                $kelasNama = $user->nama_kelas ?? ($user->kelas->nama_kelas ?? '-');
                            @endphp
                            <span class="badge bg-primary px-3 py-2 rounded-pill">
                                {{ $kelasNama }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Belum ada data pengguna.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
