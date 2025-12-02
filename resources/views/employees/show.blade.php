@extends('master')
@section('title', 'Detail Pegawai')
@section('content')
    <div class="container mx-auto mt-5 p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Detail Pegawai</h1>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABEL LENGKAP - Semua Data dalam Satu Tabel -->
            <div class="mb-8">
                <div class="overflow-hidden rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- INFORMASI PERSONAL -->
                            <tr class="bg-gray-50">
                                <th colspan="2" class="px-6 py-4 text-left text-lg font-bold text-gray-900">
                                    Informasi Personal
                                </th>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50 w-1/3">
                                    Nama Lengkap
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $employee->nama_lengkap }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Email
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $employee->email }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Nomor Telepon
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $employee->nomor_telepon ?? '-' }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Tanggal Lahir
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($employee->tanggal_lahir)->format('d F Y') }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Alamat
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $employee->alamat ?? '-' }}
                                </td>
                            </tr>
                            
                            <!-- INFORMASI PEKERJAAN -->
                            <tr class="bg-gray-50">
                                <th colspan="2" class="px-6 py-4 text-left text-lg font-bold text-gray-900">
                                    Informasi Pekerjaan
                                </th>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Tanggal Masuk
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($employee->tanggal_masuk)->format('d F Y') }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Status
                                </th>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $employee->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Departemen
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $employee->department->nama_departemen ?? '-' }}
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                    Jabatan
                                </th>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $employee->position->nama_jabatan ?? '-' }}
                                </td>
                            </tr>
                            
                            <!-- INFORMASI GAJI (Data dari tabel salaries - mengambil yang terbaru) -->
                            @php
                                $latestSalary = $employee->salaries->sortByDesc('bulan')->first();
                            @endphp
                            
                            <tr class="bg-gray-50">
                                <th colspan="2" class="px-6 py-4 text-left text-lg font-bold text-gray-900">
                                    Informasi Gaji Terkini
                                    @if($latestSalary)
                                        <span class="text-sm font-normal text-gray-600 ml-2">
                                            (Bulan: {{ \Carbon\Carbon::createFromFormat('Y-m', $latestSalary->bulan)->format('F Y') }})
                                        </span>
                                    @endif
                                </th>
                            </tr>
                            
                            @if($latestSalary)
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                        Gaji Pokok
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                        Rp {{ number_format($latestSalary->gaji_pokok, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                        Tunjangan
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <span class="{{ $latestSalary->tunjangan > 0 ? 'text-green-600 font-medium' : 'text-gray-500' }}">
                                            Rp {{ number_format($latestSalary->tunjangan, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                        Potongan
                                    </th>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <span class="{{ $latestSalary->potongan > 0 ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                                            Rp {{ number_format($latestSalary->potongan, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 bg-blue-50">
                                    <th class="px-6 py-4 text-left text-sm font-bold text-gray-900">
                                        Total Gaji
                                    </th>
                                    <td class="px-6 py-4 text-sm font-bold text-blue-700">
                                        Rp {{ number_format($latestSalary->total_gaji, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @else
                                <tr class="hover:bg-gray-50">
                                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-700 bg-gray-50">
                                        Informasi Gaji
                                    </th>
                                    <td class="px-6 py-4 text-sm text-yellow-600 italic">
                                        Belum ada data gaji untuk pegawai ini.
                                        @if(session('user_role') === 'admin')
                                            <a href="{{ route('salaries.create', ['employee_id' => $employee->id]) }}" 
                                               class="ml-2 text-blue-600 hover:text-blue-800 underline">
                                                Tambah data gaji
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('employees.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg transition duration-200">
                        Kembali
                    </a>
                    @if(session('user_role') === 'admin')
                        <!-- Tombol Edit akan mengarah ke edit data pegawai -->
                        <a href="{{ route('employees.edit', $employee->id) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition duration-200">
                            Edit Data Pegawai
                        </a>
                        <!-- Tombol Edit Gaji (jika ada data gaji) -->
                        @if($latestSalary)
                            <a href="{{ route('salaries.edit', $latestSalary->id) }}" 
                               class="bg-purple-500 hover:bg-purple-600 text-white py-2 px-6 rounded-lg transition duration-200">
                                Edit Data Gaji
                            </a>
                        @endif
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-lg transition duration-200"
                                    onclick="return confirm('Yakin ingin menghapus pegawai ini?')">
                                Hapus Pegawai
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection