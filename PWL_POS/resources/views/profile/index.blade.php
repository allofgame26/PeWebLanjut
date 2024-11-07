@extends('layouts.template')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <h2 class="text-center mb-4">Edit Profil</h2>

        <!-- Menampilkan foto profil -->
        <div class="text-center mb-3">
            <div class="position-relative d-inline-block">
                <img src="{{ asset('storage/' . Auth()->user()->avatar) }}" alt="Profile Photo"
                    class="rounded-circle img-thumbnail shadow" style="width: 200px; height: 200px; object-fit: cover;">
                {{-- <label for="avatar" class="btn btn-outline-light position-absolute bottom-0 start-50 translate-middle-x shadow"
                    style="background-color: rgba(0, 123, 255, 0.7); border-radius: 90px;">
                    <i class="fas fa-camera"></i> Ubah Foto
                </label> --}}
            </div>
        </div>

        <!-- Form untuk memperbarui foto profil -->
        <div class="card mb-4 shadow-lg rounded-lg">
            <div class="card-header text-center text-white" style="background: linear-gradient(45deg, #007bff, #6610f2);">
                <h5 class="font-weight-bold">Ubah Foto Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('profile/update_profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="avatar" class="font-weight-bold">Pilih Foto</label>
                        <input type="file" name="avatar" id="avatar" class="form-control">
                        @error('avatar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-gradient-primary btn-block shadow-sm">Simpan Perubahan Foto</button>
                </form>
            </div>
        </div>

        <!-- Kotak informasi pengguna -->
        <div class="card shadow-lg rounded-lg mb-4">
            <div class="card-header text-center text-white" style="background: linear-gradient(45deg, #007bff, #6610f2);">
                <h5 class="font-weight-bold">Informasi Pengguna</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-2">
                    <label><i class="fas fa-user"></i> Username</label>
                    <p class="form-control-plaintext">{{ $user->username }}</p>
                </div>
                <div class="form-group mb-2">
                    <label><i class="fas fa-id-card"></i> Nama</label>
                    <p class="form-control-plaintext">{{ $user->nama }}</p>
                </div>
                <div class="form-group mb-2">
                    <label><i class="fas fa-users-cog"></i> Level</label>
                    <p class="form-control-plaintext">{{ $user->level->level_nama }}</p>
                </div>
            </div>
        </div>

        <!-- Form untuk memperbarui profil -->
        <div class="card shadow-lg rounded-lg mb-4">
            <div class="card-header text-center text-white" style="background: linear-gradient(45deg, #007bff, #6610f2);">
                <h5 class="font-weight-bold">Perbarui Informasi Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ url('profile/update_info') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="level">Level</label>
                        <select name="level_id" class="form-control" disabled>
                            <option value="{{ $user->level_id }}">{{ $level_nama }}</option>
                        </select>
                        <small class="form-text text-muted">Level saat ini: {{ $level_nama }}</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="username">Username <i>*isi apabila ingin merubah username*</i></label>
                        <input type="text" name="username" id="username" class="form-control shadow-sm"
                            value="{{ $user->username }}">
                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama">Nama <i>*isi apabila ingin merubah nama*</i></label>
                        <input type="text" name="nama" id="nama" class="form-control shadow-sm"
                            value="{{ $user->nama }}">
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password <i>*isi apabila ingin merubah password*</i></label>
                        <input type="password" name="password" id="password" class="form-control shadow-sm">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control shadow-sm">
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gradient-primary btn-block shadow-sm">Simpan Perubahan
                        Biodata</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .btn-gradient-primary {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            /* Gradasi biru dan hijau laut */
            border: none;
            color: white;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(45deg, #00c6ff, #0072ff);
            /* Warna lebih intens saat di-hover */
            color: white;
        }


        .img-thumbnail {
            border: 3px solid #007bff;
            transition: transform 0.3s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }
    </style>
@endsection