@extends('layouts.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <button onclick="modalAction('{{url('/barang/import')}}')" class="btn btn-info">Import Barang</button>
          <a href="{{ url('barang/export_excel') }}" class='btn btn-primary' ><i class="fa fa-file-excel">Export Barang</a></i> 
          <a href="{{ url('/barang/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Barang</a>
          <button onclick="modalAction('{{ url('barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div> 
      </div> 
      <div class="card-body"> 
        @if (@session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (@session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        {{-- View: Add this before the table --}}
<div class="row mb-3">
  <div class="col-md-4">
      <select id="kategori_filter" class="form-control">
          <option value="">Semua Kategori</option>
          @foreach($kategoris as $kategori)
              <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
          @endforeach
      </select>
  </div>
</div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_barang"> 
          <thead> 
            <tr>
                <th>No</th>
                <th>ID Barang</th>
                <th>Kategori Kode</th>
                <th>Barang Kode</th>
                <th>Barang Nama</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr> 
          </thead> 
      </table> 
    </div> 
  </div> 
  <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection 
 
@push('css') 
@endpush 
@push('js') 
<script> 
  function modalAction(url =''){
    $('#myModal').load(url,function(){
      $('#myModal').modal('show');
    });
  }
  
  $(document).ready(function() { 
      var dataUser = $('#table_barang').DataTable({ 
          serverSide: true,      
          ajax: { 
              "url": "{{ url('barang/list') }}", 
              "dataType": "json", 
              "type": "POST",
              "data": function(d) {
                  d.kategori_id = $('#kategori_filter').val();
              }
          }, 
          columns: [ 
            { 
              data: "DT_RowIndex",             
              className: "text-center", 
              orderable: false, 
              searchable: false     
            },{ 
              data: "barang_id",                
              className: "", 
              orderable: true,     
              searchable: true     
            },{ 
              data: "kategori.kategori_nama",                
              className: "", 
              orderable: true,     
              searchable: true     
            },{ 
              data: "barang_kode",                
              className: "", 
              orderable: true,     
              searchable: true     
            },{ 
              data: "barang_nama",                
              className: "", 
              orderable: true,     
              searchable: true     
            },{ 
              data: "harga_beli",                
              className: "", 
              orderable: false,     
              searchable: false     
            },{ 
              data: "harga_jual",                
              className: "", 
              orderable: false,     
              searchable: false     
            },{
              data: "kategori.kategori_nama",
              className : "",
              orderable: true,
              searchable: false,
            },{ 
              data: "aksi",                
              className: "", 
              orderable: false,     
              searchable: false     
            } 
          ] 
      }); 
  
      // Add event listener for category filter change
      $('#kategori_filter').on('change', function() {
          dataUser.ajax.reload(); // Reload the DataTable when filter changes
      });
  }); 
  </script>
@endpush 