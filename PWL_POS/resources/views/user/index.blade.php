@extends('layouts.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <button onclick="modalAction('{{ url('user/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div> 
      </div> 
      <div class="card-body"> 
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- User Level Filter -->
        <div class="row mb-3">
          <div class="col-md-4">
            <div class="form-group">
              <label for="userLevelFilter">Filter by Level:</label>
              <select id="userLevelFilter" class="form-control">
                  <option value="">Semua Level</option>
                  @foreach($levels as $level)
                      <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                  @endforeach
              </select>
            </div>
          </div>
        </div>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_user"> 
          <thead> 
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Level Pengguna</th>
                <th>Aksi</th>
            </tr> 
          </thead> 
        </table> 
      </div> 
  </div>
  <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>  
@endsection 
 
@push('css') 
@endpush 

@push('js') 
<script> 
function modalAction(url = '') {
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}

var dataUser;

$(document).ready(function() { 
    // Initialize DataTable
    dataUser = $('#table_user').DataTable({ 
        processing: true,
        serverSide: true,      
        ajax: { 
            url: "{{ url('user/list') }}", 
            dataType: "json", 
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function(d) {
                d.level_id = $('#userLevelFilter').val();
            }
        }, 
        columns: [ 
            { 
                data: "DT_RowIndex",             
                className: "text-center", 
                orderable: false, 
                searchable: false     
            },
            { 
                data: "username",                
                className: "", 
                orderable: true,     
                searchable: true     
            },
            { 
                data: "nama",                
                className: "", 
                orderable: true,     
                searchable: true     
            },
            { 
                data: "level.level_nama",                
                className: "", 
                orderable: false,     
                searchable: false     
            },{ 
                data: "aksi",                
                className: "", 
                orderable: false,     
                searchable: false     
            } 
        ],
        drawCallback: function(settings) {
            // Optional: Add any callback function after table redraws
        }
    }); 

    // Add event listener for level filter with immediate reload
    $('#userLevelFilter').on('change', function() {
        dataUser.ajax.reload(null, false); // null, false will reload the current page
    });
}); 
</script> 
@endpush