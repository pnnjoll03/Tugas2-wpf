@extends('master')
@section('title', 'Absensi')
@section('content')
    <div class="container mx-auto mt-5 p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Absensi Harian</h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $employee->nama_lengkap }}
                </p>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Status Absensi Hari Ini -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="font-medium text-gray-700 mb-2">Status Absensi Hari Ini</h3>
                
                @if($todayAttendance)
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jam Masuk:</span>
                            <span class="font-medium {{ $todayAttendance->waktu_masuk ? 'text-green-600' : 'text-red-600' }}">
                                {{ $todayAttendance->waktu_masuk ?: 'Belum absen' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jam Keluar:</span>
                            <span class="font-medium {{ $todayAttendance->waktu_keluar ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $todayAttendance->waktu_keluar ?: 'Belum absen' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                {{ ucfirst($todayAttendance->status_absensi) }}
                            </span>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center">Belum ada absensi hari ini.</p>
                @endif
            </div>

            <!-- Tombol Absensi -->
            <div class="text-center">
                @if($todayAttendance && $todayAttendance->waktu_masuk && $todayAttendance->waktu_keluar)
                    <!-- Sudah absen lengkap -->
                    <button class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg text-lg font-medium cursor-not-allowed" disabled>
                        Absensi Selesai
                    </button>
                    <p class="text-gray-500 text-sm mt-2">
                        Anda sudah menyelesaikan absensi hari ini.
                    </p>
                @else
                    <!-- Tombol absensi aktif -->
                    <form action="{{ route('attendances.store') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full {{ (!$todayAttendance || !$todayAttendance->waktu_masuk) ? 'bg-green-500 hover:bg-green-600' : 'bg-yellow-500 hover:bg-yellow-600' }} 
                                       text-white py-3 px-4 rounded-lg text-lg font-medium transition duration-200">
                            @if(!$todayAttendance || !$todayAttendance->waktu_masuk)
                                ABSEN MASUK
                            @elseif($todayAttendance->waktu_masuk && !$todayAttendance->waktu_keluar)
                                ABSEN KELUAR
                            @endif
                        </button>
                    </form>
                @endif
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-6 text-center">
                <a href="{{ route('attendances.index') }}" 
                   class="inline-block bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg transition duration-200">
                    Lihat Data Absensi
                </a>
                <a href="{{ route('employees.index') }}" 
                   class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition duration-200 ml-2">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection