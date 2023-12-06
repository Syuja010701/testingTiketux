@extends('layouts.main')
@section('title', 'Kategori COA')
@section('content')
    <h1>Data Transaksi</h1>
    <div class=" d-grid gap-2 d-flex justify-content-between col-xl-8 mb-3">
        <a href="javascript:void(0)" id="createTransaksi" class="btn btn-primary"><iconify-icon  icon="ic:baseline-plus"></iconify-icon> Tambah Transaksi</a>
        {{-- <a href="" class="btn btn-success"> <iconify-icon  icon="file-icons:microsoft-excel"></iconify-icon> Export </a> --}}
    </div>
    <div class="col-xl-8">
        <table class="table data-table col-xl-8">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Tanggal</th>
                <th scope="col">COA Kode</th>
                <th scope="col">COA Nama</th>
                <th scope="col">Desc</th>
                <th scope="col">Debit</th>
                <th scope="col">Credit</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
        </table>
    </div>

    @include('transaksi.modal.create')
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
   
  $(function () {

     function formatRupiah(input) {
        let value = input.value.replace(/\D/g, "");
    
        let formattedValue = new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(value);
    
        input.value = "Rp. " + formattedValue;
    
    }
        document.getElementById("debit").addEventListener("keyup", function() {
            formatRupiah(this);
        });

        document.getElementById("credit").addEventListener("keyup", function() {
            formatRupiah(this);
        });

       
      
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
        ajax: "{{ route('transaksi.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'tanggal', name:'tanggal'},
            {data: 'coa_id_kode', name:'coa.kode'},
            {data: 'coa_id_nama', name:'coa.nama'},
            {data: 'desc', name:'desc'},
            {data: 'debit', name:'debit', render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
            {data: 'credit', name:'credit' ,render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]

       
    });
    // End Data Table
      
    // button close
    $('.btn-closed').click(function(){
        $('#transaksi').trigger("reset");
        $('#tanggal').attr('disabled', false);
        $('#kode_coa').attr('disabled', false);
        $('#nama_coa').attr('disabled', true);
        $('#desc').attr('disabled', false);
        $('#debit').attr('disabled', false);
        $('#credit').attr('disabled', false);

    });
    // end button close

    // Button Show
    $('#createTransaksi').click(function () {
        $('#saveBtn').val("create-kategoriCoa");
        $('#kategoriCoa_id').val('');
        $('#transaksi').trigger("reset");
        $('#modelHeading').html("Create New Kategori COA");
        $('#ajaxModel').modal('show');

        $('#tanggal').attr('disabled', false);
        $('#kode_coa').attr('disabled', false);
        $('#nama_coa').attr('disabled', true);
        $('#desc').attr('disabled', false);
        $('#debit').attr('disabled', false);
        $('#credit').attr('disabled', false);

    });
    // end Button
      
    // Edit Transaksi
    $('body').on('click', '.editTransaksi', function () {
        var id = $(this).data('id');
        let route = `{{ route('transaksi.edit', ':id') }}`;
        route = route.replace(':id', id);
        // console.log(route);

      $.get(route, function (data) {
            let formattedDebit = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(data.debit);

            let formattedCredit = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(data.credit);

            $('#modelHeading').html("Edit Chart Of Account");
            $('#saveBtn').val("edit-coa");
            $('#ajaxModel').modal('show');
            $('#id').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#kode_coa').val(data.coa.id);
            $('#nama_coa').val(data.coa.nama);
            $('#desc').val(data.desc);
            $('#debit').val(formattedDebit);
            $('#credit').val(formattedCredit);
      })
    });
    // End Edit Transaksi
         
    // Create Transaksi
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        $.ajax({
          data: $('#transaksi').serialize(),
          url: "{{ route('transaksi.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (response) {
            
            Swal.fire({
                title: "Berhasil",
                text: `${response.message}`,
                icon: "success"
            });
       
              $('#transaksi').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
           
          },
          error: function (response) {
            let respArr = JSON.parse(response.responseText);

            const displayErrorMessage = (field, errorMessage) => {
                const alertElement = $(`#alert-${field}`);
                alertElement.removeClass('d-none');
                alertElement.addClass('d-block');
                alertElement.html(errorMessage);

                setTimeout(function () {
                    alertElement.removeClass('d-block');
                    alertElement.addClass('d-none');
                    alertElement.html('');
                    $('#saveBtn').html('Submit');
                }, 5000);
            };

            if ((respArr.desc && respArr.desc.length > 0) || (respArr.tanggal && respArr.tanggal.length > 0) || respArr.code_coa_id && respArr.code_coa_id.length > 0) {

                if (respArr.desc && respArr.desc.length > 0) {
                    displayErrorMessage('desc', respArr.desc[0]);
                }

                if (respArr.tanggal && respArr.tanggal.length > 0) {
                    displayErrorMessage('tanggal', respArr.tanggal[0]);
                }

                 if (respArr.code_coa_id && respArr.code_coa_id.length > 0) {
                    displayErrorMessage('kode_coa', respArr.code_coa_id[0]);
                }

            } else {
                alert("Terjadi kesalahan, silakan coba lagi.");
            }

          }
      });
    });
    // end crate Transaksi
      
    // Delete Transaksi
    $('body').on('click', '.deleteTransaksi', function () {
        
        var id = $(this).data("id");
        let route = `{{ route('transaksi.delete', ':id') }}`;
        route = route.replace(':id', id);

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {
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
    // end delete Transaksi

     // show Detail Transaksi
    $('body').on('click', '.showTransaksi', function(){
        let id = $(this).data('id');
        let route = `{{ route('transaksi.show', ':id') }}`;
        route = route.replace(':id', id);
        
        $.get(route, function(data){

             let formattedDebit = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(data.debit);

            let formattedCredit = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 0,
            }).format(data.credit);

            $('#modelHeading').html("Detail Transaksi");
            $('#saveBtn').val("d-none");
            $('#saveBtn').addClass('d-none')
            $('#ajaxModel').modal('show');
            
            $('#id').val(data.id);
            $('#tanggal').val(data.tanggal);
            $('#kode_coa').val(data.coa.id);
            $('#nama_coa').val(data.coa.nama);
            $('#desc').val(data.desc);
            $('#debit').val(formattedDebit);
            $('#credit').val(formattedCredit);

            $('#tanggal').attr('disabled', 'disabled');
            $('#kode_coa').attr('disabled', 'disabled');
            $('#nama_coa').attr('disabled', 'disabled');
            $('#desc').attr('disabled', 'disabled');
            $('#debit').attr('disabled', 'disabled');
            $('#credit').attr('disabled', 'disabled');
        });
    });
    // end Detail Transaksi

    // select kode 
    $('#kode_coa').change(function(){
        let id = $(this).val();
        let route = `{{ route('transaksi.getDetail', ':id') }}`;
        route = route.replace(':id', id);

        // console.log(id);

        $.get(route, function(data){
            $('#nama_coa').val(data.nama);
        });
    })
    // end select kode
       
  });
  
</script>
@endpush
