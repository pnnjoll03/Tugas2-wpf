@extends('master')
@section('title', 'Daftar Gaji Pegawai')
@section('content')
    
<div class="container mx-auto mt-5 p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Gaji Pegawai</h1>
        </div>

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 border-collapse">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">No</th>
                        <th class="border border-gray-300 py-2 px-3 w-2/12">Nama Pegawai</th>
                        <th class="border border-gray-300 py-2 px-3 w-2/12">Departemen</th>
                        <th class="border border-gray-300 py-2 px-3 w-2/12">Jabatan</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Bulan</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Gaji Pokok</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Tunjangan</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Potongan</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Total</th>
                        @if(session('user_role') === 'admin')
                            <th class="border border-gray-300 py-2 px-3 w-1/12">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($salaries as $salary)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 py-2 px-3 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 py-2 px-3 font-medium text-gray-800">
                                {{ $salary->employee->nama_lengkap ?? '-' }}
                            </td>
                            <td class="border border-gray-300 py-2 px-3">
                                {{ $salary->employee->department->nama_departemen ?? '-' }}
                            </td>
                            <td class="border border-gray-300 py-2 px-3">
                                {{ $salary->employee->position->nama_jabatan ?? '-' }}
                            </td>
                            <td class="border border-gray-300 py-2 px-3 text-center">
                                {{ $salary->bulan }}
                            </td>
                            <td class="border border-gray-300 py-2 px-3 text-right">
                                Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 py-2 px-3 text-right">
                                Rp {{ number_format($salary->tunjangan, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 py-2 px-3 text-right">
                                Rp {{ number_format($salary->potongan, 0, ',', '.') }}
                            </td>
                            <td class="border border-gray-300 py-2 px-3 text-right font-semibold text-green-600">
                                Rp {{ number_format($salary->total_gaji, 0, ',', '.') }}
                            </td>
                            @if(session('user_role') === 'admin')
                                <td class="border border-gray-300 py-2 px-3 text-center">
                                    <div class="flex flex-col space-y-1">
                                        <a href="{{ route('salaries.edit', $salary->id) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white text-center py-1 px-2 rounded text-sm transition duration-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('salaries.destroy', $salary->id) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white w-full text-center py-1 px-2 rounded text-sm transition duration-200"
                                                    onclick="return confirm('Yakin ingin menghapus data gaji ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ session('user_role') === 'admin' ? 10 : 9 }}" class="border border-gray-300 py-8 text-center text-gray-500">
                                <i class="fas fa-money-bill-wave fa-2x mb-3 block mx-auto"></i>
                                Belum ada data gaji
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection