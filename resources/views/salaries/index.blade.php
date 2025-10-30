@extends('master')
@section('title', 'Daftar Gaji Pegawai')
@section('content')
    
<div class="container mx-auto mt-5 p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Gaji Pegawai</h1>
            <a href="{{ route('salaries.create') }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition duration-200">
                Tambah Data
            </a>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="border border-gray-300 py-8 text-center text-gray-500">
                                    <i class="fas fa-money-bill-wave fa-2x mb-3 block mx-auto"></i>
                                    Belum ada data gaji
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total Summary -->
            @if($salaries->count() > 0)
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <div class="grid grid-cols-4 gap-4 text-sm">
                    <div class="text-center">
                        <div class="font-semibold text-gray-600">Total Gaji Pokok</div>
                        <div class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($salaries->sum('gaji_pokok'), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="font-semibold text-gray-600">Total Tunjangan</div>
                        <div class="text-lg font-bold text-green-600">
                            Rp {{ number_format($salaries->sum('tunjangan'), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="font-semibold text-gray-600">Total Potongan</div>
                        <div class="text-lg font-bold text-red-600">
                            Rp {{ number_format($salaries->sum('potongan'), 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="font-semibold text-gray-600">Total Keseluruhan</div>
                        <div class="text-lg font-bold text-purple-600">
                            Rp {{ number_format($salaries->sum('total_gaji'), 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
