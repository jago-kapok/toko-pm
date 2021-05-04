<div class="mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-download"></i>
	    &nbsp;&nbsp;Export Stok
	  </button>
	</div>
	<div class="col-md-4 pull-right">
	  <div class="input-group">
		<input id="searching" class="form-control form-control-sm" placeholder="Cari Data ...">
		<div class="input-group-prepend">
		  <div class="">
			<select id="pagelength" class="form-control form-control-sm" readonly>
			  <option value="10">10</option>
			  <option value="25">25</option>
			  <option value="50">50</option>
			  <option value="100">100</option>
			</select>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <table id="table_data" class="table table-bordered table-striped" width="100.1%">
	<thead class="bg-info">
      <tr>
		<th width="5">No.</th>
        <th class="w-25">Nama Barang</th>
        <th class="w-10">Stok Tersedia</th>
        <th class="w-10">Stok Minimal</th>
        <th class="w-10">Stok Maksimal</th>
        <th class="w-25">Terakhir Diperbarui</th>
        <th>#</th>
      </tr>
    </thead>
  </table>
</div>

<div class="modal fade" id="stock_update" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Perbarui Stok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('stock/update'); ?>" method="POST">
      <div class="modal-body">
		<input type="hidden" name="stock_id">
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Nama Barang</label>
		  <div class="col-md-8">
		    <input name="item_desc" class="form-control form-control-sm" readonly>
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Stok Tersedia <span class="text-danger">*</span></label>
		  <div class="col-md-3">
		    <input name="stock_exist" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Stok Minimal <span class="text-danger">*</span></label>
		  <div class="col-md-3">
		    <input name="stock_min" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Stok Maksimal <span class="text-danger">*</span></label>
		  <div class="col-md-3">
		    <input name="stock_max" class="form-control form-control-sm" required>
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
	    <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.jpeg" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Simpan</button>
      </div>
	  </form>
    </div>
  </div>
</div>
