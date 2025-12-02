@extends('master')
@section('title', 'Daftar Absensi Pegawai')
@section('content')
    
<div class="container mx-auto mt-5 p-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Absensi Pegawai</h1>
            
            @if(session('user_role') === 'employee')
                <a href="{{ route('attendances.create') }}" 
                   class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200">
                    Absen Hari Ini
                </a>
            @endif
        </div>

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
                        <th class="border border-gray-300 py-2 px-3 w-3/12">Nama Lengkap</th>
                        <th class="border border-gray-300 py-2 px-3 w-2/12">Department</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Tanggal</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Waktu Masuk</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Waktu Keluar</th>
                        <th class="border border-gray-300 py-2 px-3 w-1/12">Status</th>
                        @if(session('user_role') === 'admin')
                            <th class="border border-gray-300 py-2 px-3 w-2/12">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($attendances as $attendance)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 py-2 px-3 text-center">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 py-2 px-3">
                            <div class="font-semibold text-gray-800">{{ $attendance->employee->nama_lengkap }}</div>
                            <div class="text-sm text-gray-500 mt-1">{{ $attendance->employee->position->nama_jabatan ?? '-' }}</div>
                        </td>
                        <td class="border border-gray-300 py-2 px-3">{{ $attendance->employee->department->nama_departemen ?? '-' }}</td>
                        <td class="border border-gray-300 py-2 px-3">{{ $attendance->tanggal }}</td>
                        <td class="border border-gray-300 py-2 px-3 text-center">
                            @if($attendance->waktu_masuk)
                                <span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs font-medium">
                                    {{ $attendance->waktu_masuk }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 py-1 px-2 rounded-full text-xs font-medium">-</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 py-2 px-3 text-center">
                            @if($attendance->waktu_keluar)
                                <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded-full text-xs font-medium">
                                    {{ $attendance->waktu_keluar }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 py-1 px-2 rounded-full text-xs font-medium">-</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 py-2 px-3 text-center">
                            @php
                                $statusColors = [
                                    'hadir' => 'bg-green-100 text-green-800',
                                    'izin' => 'bg-yellow-100 text-yellow-800', 
                                    'sakit' => 'bg-blue-100 text-blue-800',
                                    'alpha' => 'bg-red-100 text-red-800'
                                ];
                                $colorClass = $statusColors[$attendance->status_absensi] ?? 'bg-gray-100 text-gray-500';
                            @endphp
                            <span class="{{ $colorClass }} py-1 px-2 rounded-full text-xs font-medium">
                                {{ ucfirst($attendance->status_absensi) }}
                            </span>
                        </td>
                        @if(session('user_role') === 'admin')
                            <td class="border border-gray-300 py-2 px-3">
                                <div class="flex flex-col space-y-1">
                                    <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white w-full text-center py-1 px-2 rounded text-sm transition duration-200"
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ session('user_role') === 'admin' ? 8 : 7 }}" class="border border-gray-300 py-8 text-center text-gray-500">
                            <i class="fas fa-clipboard-list fa-2x mb-3 block mx-auto"></i>
                            Belum ada data absensi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection