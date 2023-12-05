@extends('layouts.main')
@section('title', 'Kategori COA')
@section('content')
    <h1>Master Data Kategori COA</h1>
    <div class=" d-grid gap-2 d-flex justify-content-between col-xl-8 mb-3">
        <a href="javascript:void(0)" id="createKategoriCoa" class="btn btn-primary"><iconify-icon  icon="ic:baseline-plus"></iconify-icon> Tambah Kategori</a>
        <a href="" class="btn btn-success"> <iconify-icon  icon="file-icons:microsoft-excel"></iconify-icon> Export </a>
    </div>
    <div class="col-xl-8">
        <table class="table data-table col-xl-8">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
          
        </table>
    </div>

    @include('kategori_COA.modal.create')
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
  $(function () {
      
    // Token 
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    // End Token
      
    // Data Table
    var table = $('.data-table').DataTable({
        serverSide: true,
        responsive: true,
        processing: true,
        ajax: "{{ route('kategoriCoa.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama', name: 'nama'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    // End Data Table
      

    // Button Show
    $('#createKategoriCoa').click(function () {
        $('#saveBtn').val("create-kategoriCoa");
        $('#kategoriCoa_id').val('');
        $('#coa').trigger("reset");
        $('#modelHeading').html("Create New Kategori COA");
        $('#ajaxModel').modal('show');
    });
    // end Button
      
    // Edit Kategori
    $('body').on('click', '.editKategoriCoa', function () {
        var kategoriCoa_id = $(this).data('id');
        let route = `{{ route('kategoriCoa.edit', ':id') }}`;
        route = route.replace(':id', kategoriCoa_id);
        console.log(route);

      $.get(route, function (data) {
          $('#modelHeading').html("Edit KategoriCoa");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#id').val(data.id);
          $('#nama').val(data.nama);
      })
    });
    // End Katgori

    // show Kategori
    $('body').on('click', '.showKategoriCoa', function(){
        let kategoriCoa_id = $(this).data('id');
        let route = `{{ route('kategoriCoa.show', ':id') }}`;
        route = route.replace(':id', kategoriCoa_id);
        
        $.get(route, function(data){
            $('#modelHeading').html("Detail Kategori Coa");
            $('#saveBtn').val("d-none");
            $('#saveBtn').addClass('d-none')
            $('#ajaxModel').modal('show');
            $('#kategoriCoa_id').val(data.id);
            $('#nama').val(data.nama);
            $('#nama').attr('disabled', 'disabled');
        });
    });
    // end Kategori
         
    // Create Kategori
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        $.ajax({
          data: $('#coa').serialize(),
          url: "{{ route('kategoriCoa.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (response) {
            
            Swal.fire({
                title: "Berhasil",
                text: `${response.message}`,
                icon: "success"
            });
       
              $('#coa').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
           
          },
          error: function (response) {
            let respArr = JSON.parse(response.responseText);

            if (respArr.nama && respArr.nama.length > 0) {
                let errorMessage = respArr.nama[0];

                $('#alert-nama').removeClass('d-none');
                $('#alert-nama').addClass('d-block');
                $('#alert-nama').html(errorMessage);

                setTimeout(function() {
                    $('#alert-nama').removeClass('d-block');
                    $('#alert-nama').addClass('d-none');
                    $('#alert-nama').html('');
                }, 3000);

                $('#saveBtn').html('Submit');
            } else {
                alert("Terjadi kesalahan, silakan coba lagi.");
            }
          }
      });
    });
    // end crate Kategori
      
    // Delete Kategori
    $('body').on('click', '.deleteKategoriCoa', function () {
        
        var kategoriCoa_id = $(this).data("id");
        let route = `{{ route('kategoriCoa.delete', ':id') }}`;
        route = route.replace(':id', kategoriCoa_id);

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {

                console.log('test');

                $.ajax({
                    url: route,
                    type: "DELETE",
                    cache: false,
                    success:function(response){ 
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });
                        table.draw()
                    }
                });

                
            }
        })
        
    });
    // end delete Kategori
       
  });
</script>
@endpush
