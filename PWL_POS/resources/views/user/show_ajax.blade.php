@extends('layouts.template') 

@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"></div> 
      </div> 
      <div class="card-body"> 
        <div id="user-details">
            <!-- User details will be loaded here -->
        </div>
        <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a> 
      </div> 
  </div> 
@endsection 
@push('css') 
@endpush 

@push('js') 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Fetch user details on page load
        const userId = {{ $userId }}; // Assuming you pass userId from the controller to the view
        if (userId) {
            $.ajax({
                url: "{{ url('user') }}/" + userId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        const user = response.data;
                        $('#user-details').html(`
                            <table class="table table-bordered table-striped table-hover table-sm">
                                <tr>
                                    <th>ID</th>
                                    <td>${user.user_id}</td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td>${user.level.level_nama}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>${user.username}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>${user.nama}</td>
                                </tr>
                                <tr>
                                    <th>Password</th>
                                    <td>${user.password}</td>
                                </tr>
                            </table>
                        `);
                    } else {
                        $('#user-details').html(`
                            <div class="alert alert-danger alert-dismissible">
                                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                                ${response.message}
                            </div>
                        `);
                    }
                },
                error: function() {
                    $('#user-details').html(`
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                            Terjadi kesalahan saat mengambil data pengguna.
                        </div>
                    `);
                }
            });
        }
    });
</script>
@endpush 