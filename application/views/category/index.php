<div class="mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#category_create"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Tambah
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
		<th width="5">NO.</th>
        <th>DESKRIPSI</th>
        <th>#</th>
      </tr>
    </thead>
  </table>
</div>

<div class="modal fade" id="category_create" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Tambah Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('category/create'); ?>" method="POST">
      <div class="modal-body">
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Nama Kategori <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <input name="category_desc" class="form-control form-control-sm" required>
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
	    <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.jpeg" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Simpan</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="category_update" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('category/update'); ?>" method="POST">
      <div class="modal-body">
	    <input type="hidden" name="category_id">
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Nama Kategori <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <input name="category_desc" class="form-control form-control-sm" required>
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
	    <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.jpeg" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Simpan</button>
      </div>
	  </form>
    </div>
  </div>
</div>