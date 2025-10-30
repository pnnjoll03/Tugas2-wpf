@extends('master')
@section('title', 'Tambah Absensi')
@section('content')
    <div class="container mx-auto mt-5 p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah Department</h1>

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <!-- Nama Department -->
                    <div>
                        <label for="nama_departemen" class="block font-medium text-gray-700 mb-2">Nama Department</label>
                        <input type="text" id="nama_departemen" name="nama_departemen" required
                               class="w-full border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('nama_departemen') }}"
                               placeholder="Masukkan nama department">
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <a href="{{ route('departments.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition duration-200">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection