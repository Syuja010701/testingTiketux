@extends('layouts.main')
@section('title', 'Kategori COA')
@section('content')
    <h1>Master Data Kategori COA</h1>
    <div class=" d-grid gap-2 d-flex justify-content-between col-xl-8 mb-3">
        <div class="">
            <a href="javascript:void(0)" id="createCoa" class="btn btn-primary"><iconify-icon
                    icon="ic:baseline-plus"></iconify-icon> Tambah Kategori</a>
        </div>
        <div class="">
            <label for="filterKategori">Filter Berdasarkan Kategori </label>
            <select class="form-select" id="filterKategori" aria-label="Default select example">
                <option value="all" selected>Semua Kategori</option>
                @foreach ($kategoris as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- <a href="" class="btn btn-success"> <iconify-icon  icon="file-icons:microsoft-excel"></iconify-icon> Export </a> --}}
    </div>
    <div class="col-xl-8">
        {{-- {!! $html->table(['class' => 'table table-bordered'], true) !!} --}}
        <table class="table data-table col-xl-8">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Kategori</th>
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
        $(function() {

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
                ajax: {
                    url: "{{ route('coa.index') }}",
                    data: function(d) {
                        d.filter_kategori = $('#filterKategori').val();
                    },
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kategori_coa_id',
                        name: 'kategoriCoa.nama'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]


            });
            // End Data Table

            // filter Code
            $('#filterKategori').change(function() {
                table.draw();
            });

            // Button Show
            $('#createCoa').click(function() {
                $('#saveBtn').val("create-kategoriCoa");
                $('#kategoriCoa_id').val('');
                $('#kategoriCoa').trigger("reset");
                $('#modelHeading').html("Create New Kategori COA");
                $('#ajaxModel').modal('show');
            });
            // end Button

            // Edit Coa
            $('body').on('click', '.editCoa', function() {
                var kategoriCoa_id = $(this).data('id');
                let route = `{{ route('coa.edit', ':id') }}`;
                route = route.replace(':id', kategoriCoa_id);
                // console.log(route);

                $.get(route, function(data) {
                    // console.log(data);
                    $('#modelHeading').html("Edit Chart Of Account");
                    $('#saveBtn').val("edit-coa");
                    $('#ajaxModel').modal('show');
                    $('#id').val(data.id);
                    $('#kode').val(data.kode);
                    $('#nama').val(data.nama);
                    $('#kategori_coa_id').val(data.kategori_coa_id);
                })
            });
            // End Edit Coa

            // Create Coa
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Sending..');
                $.ajax({
                    data: $('#coa').serialize(),
                    url: "{{ route('coa.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {

                        Swal.fire({
                            title: "Berhasil",
                            text: `${response.message}`,
                            icon: "success"
                        });

                        $('#kategoriCoa').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();

                    },
                    error: function(response) {
                        let respArr = JSON.parse(response.responseText);

                        const displayErrorMessage = (field, errorMessage) => {
                            const alertElement = $(`#alert-${field}`);
                            alertElement.removeClass('d-none');
                            alertElement.addClass('d-block');
                            alertElement.html(errorMessage);

                            setTimeout(function() {
                                alertElement.removeClass('d-block');
                                alertElement.addClass('d-none');
                                alertElement.html('');
                                $('#saveBtn').html('Submit');
                            }, 3000);
                        };

                        if ((respArr.nama && respArr.nama.length > 0) ||
                            (respArr.kode && respArr.kode.length > 0) ||
                            (respArr.kategori_coa_id && respArr.kategori_coa_id.length > 0)) {

                            if (respArr.nama && respArr.nama.length > 0) {
                                displayErrorMessage('nama', respArr.nama[0]);
                            }

                            if (respArr.kode && respArr.kode.length > 0) {
                                displayErrorMessage('kode', respArr.kode[0]);
                            }

                            if (respArr.kategori_coa_id && respArr.kategori_coa_id.length > 0) {
                                displayErrorMessage('kategori', respArr.kategori_coa_id[0]);
                            }

                        } else {
                            alert("Terjadi kesalahan, silakan coba lagi.");
                        }

                    }
                });
            });
            // end crate Coa

            // Delete Coa
            $('body').on('click', '.deleteCoa', function() {

                var kategoriCoa_id = $(this).data("id");
                let route = `{{ route('coa.delete', ':id') }}`;
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

                        // console.log('test');

                        $.ajax({
                            url: route,
                            type: "DELETE",
                            cache: false,
                            success: function(response) {
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
            // end delete coa

            // show Detail Coa
            $('body').on('click', '.showCoa', function() {
                let kategoriCoa_id = $(this).data('id');
                let route = `{{ route('coa.show', ':id') }}`;
                route = route.replace(':id', kategoriCoa_id);

                $.get(route, function(data) {
                    $('#modelHeading').html("Detail Chart Of Account");
                    $('#saveBtn').val("d-none");
                    $('#saveBtn').addClass('d-none')
                    $('#ajaxModel').modal('show');

                    $('#id').val(data.id);
                    $('#kode').val(data.kode);
                    $('#nama').val(data.nama);
                    $('#kategori_coa_id').val(data.kategori_coa_id);

                    $('#nama').attr('disabled', 'disabled');
                    $('#kode').attr('disabled', 'disabled');
                    $('#kategori_coa_id').attr('disabled', 'disabled');
                });
            });
            // end Detail Coa

        });
    </script>
@endpush
