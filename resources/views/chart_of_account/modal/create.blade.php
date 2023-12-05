<div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form id="kategoriCoa" name="kategoriCoa" class="form-horizontal">
                   <input type="hidden" name="kategoriCoa_id" id="kategoriCoa_id">
                    <div class="form-group mb-3">
                        <label for="nama" class="col-sm-2 control-label">Nama</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama" value="{{ old('nama') }}" name="nama" placeholder="Masukkan Nama" required="">
                          
                            <div class="text-danger d-none" id="alert-nama" role="alert">
                                
                            </div>
                          
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