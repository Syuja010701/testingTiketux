<div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="transaksi" name="transaksi" class="form-horizontal">
                   <input type="hidden" name="id" id="id">
                    <div class="form-group mb-3">
                        <label for="tanggal" class="col-sm-6 control-label">Tanggal</label>
                        <div class="col-sm-12">
                            <input type="date" class="form-control" id="tanggal" value="{{ old('tanggal') }}" name="tanggal" required="">
                            <div class="text-danger d-none" id="alert-tanggal" role="alert"></div>
                        </div>
                    </div>      
                    <div class="form-group mb-3">
                        <label for="kode_coa" class="col-sm-6 control-label">COA Code</label>
                        <div class="col-sm-12">
                             <select class="form-select" aria-label="Default select example" name="kode_coa" id="kode_coa" required>
                            <option selected disabled>Pilih Kode</option>
                            @foreach ($chartOfAccounts as $item)
                                <option value="{{ $item->id }}">{{ $item->kode }}</option>
                            @endforeach
                            </select>
                            <div class="text-danger d-none" id="alert-kode_coa" role="alert"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama_coa" class="col-sm-6 control-label">COA Nama</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_coa" disabled value="{{ old('nama_coa') }}" name="nama_coa" required="">
                            <div class="text-danger d-none" id="alert-nama_coa" role="alert"></div>
                        </div>
                    </div>      
                    <div class="form-group mb-3">
                        <label for="desc" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" placeholder="Enter Description" id="desc" name="desc" style="height: 100px"></textarea>
                            <div class="text-danger d-none" id="alert-desc" role="alert"></div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="debit" class="col-sm-6 control-label">Debit</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="debit" value="{{ old('debit') }}" name="debit" required="">
                            <div class="text-danger d-none" id="alert-kode_coa" role="alert"></div>
                        </div>
                    </div>      
                     <div class="form-group mb-3">
                        <label for="credit" class="col-sm-6 control-label">Credit</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="credit" value="{{ old('credit') }}" name="credit" required="">
                            <div class="text-danger d-none" id="alert-kode_coa" role="alert"></div>
                        </div>
                    </div>           
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
</div> 