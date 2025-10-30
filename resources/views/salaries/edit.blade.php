@extends('master')
@section('title', 'Edit Data Gaji')
@section('content')
<div class="container mt-5">
    <h1>Edit Data Gaji</h1>

    <form action="{{ route('salaries.update', $salary->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="karyawan_id" class="form-label">Pegawai</label>
            <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                <option value="">-- Pilih Pegawai --</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}"
                        {{ $salary->karyawan_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->nama_lengkap }} 
                        ({{ $employee->position->nama_jabatan ?? '-' }},
                         {{ $employee->department->nama_departemen ?? '-' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="text" name="bulan" id="bulan" class="form-control"
                value="{{ old('bulan', $salary->bulan) }}" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                <input type="text" class="form-control" value="Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label for="tunjangan" class="form-label">Tunjangan</label>
                <input type="number" name="tunjangan" id="tunjangan" class="form-control"
                    value="{{ old('tunjangan', $salary->tunjangan) }}" min="0" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="potongan" class="form-label">Potongan</label>
                <input type="number" name="potongan" id="potongan" class="form-control"
                    value="{{ old('potongan', $salary->potongan) }}" min="0" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="total_gaji" class="form-label">Total Gaji</label>
            <input type="text" class="form-control" 
                value="Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}" readonly>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="{{ route('salaries.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
