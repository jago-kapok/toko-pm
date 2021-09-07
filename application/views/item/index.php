<div class="mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_create"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Tambah
	  </button>
	</div>
	<div class="col-md-4 pull-right">
	  <div class="input-group">
		<input id="searching" class="form-control form-control-sm" placeholder="Cari Data ...">
		<div class="input-group-prepend">
		  <div class="btn btn-primary btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
			<i class="fa fa-filter"></i>&nbsp;&nbsp;Kategori
			<div class="dropdown-menu dropdown-menu-right">
			  <?php foreach($category AS $value) { ?>
				<a id="<?php echo $value['category_id'] ?>" href="javascript:void(0)" class="dropdown-item filter-category"><?php echo $value['category_desc']; ?></a>
			  <?php } ?>
			</div>
		  </div>
		</div>
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
		<th width="5%">NO.</th>
        <th width="5%">KODE</th>
        <th width="10%">KATEGORI</th>
        <th width="30%">DESKRIPSI</th>
        <th width="5%">SATUAN</th>
        <th width="15%" class="text-left">HARGA JUAL (Rp)</th>
        <th width="20%">SUPPLIER</th>
        <th width="10%" class="text-left">#</th>
      </tr>
    </thead>
  </table>
</div>

<div class="modal fade" id="form_create" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Tambah Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('item/create'); ?>" method="POST">
      <div class="modal-body">
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Kode <span class="text-danger">*</span></label>
		  <div class="col-md-4">
		    <input name="item_code" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Kategori <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <select name="category_id" class="form-control form-control-sm" required>
			  <option disabled selected>--- Pilih Kategori ---</option>
			  <?php foreach($category AS $value) { ?>
				<option value="<?php echo $value['category_id']; ?>"><?php echo $value['category_desc']; ?></option>
			  <?php } ?>
			</select>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Nama Produk <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <input name="item_desc" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Satuan</label>
		  <div class="col-md-2">
		    <input name="item_unit" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Harga Beli</label>
		  <div class="col-md-4">
		    <input name="item_buy" class="form-control form-control-sm number">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Harga Jual <span class="text-danger">*</span></label>
		  <div class="col-md-4">
		    <input name="item_price" class="form-control form-control-sm number" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Supplier</label>
		  <div class="col-md-8">
		    <select name="supplier_id" class="form-control form-control-sm">
			  <option disabled selected>--- Pilih Supplier ---</option>
			  <?php foreach($supplier AS $value) { ?>
				<option value="<?php echo $value['supplier_id']; ?>"><?php echo $value['supplier_name']; ?></option>
			  <?php } ?>
			</select>
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

<div class="modal fade" id="item_update" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Edit Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('item/update'); ?>" method="POST">
      <div class="modal-body">
		<input type="hidden" name="item_id">
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Kode <span class="text-danger">*</span></label>
		  <div class="col-md-4">
		    <input name="item_code" class="form-control form-control-sm" readonly>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Kategori <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <select name="category_id" class="form-control form-control-sm" required>
			  <option disabled selected>--- Pilih Kategori ---</option>
			  <?php foreach($category AS $value) { ?>
				<option value="<?php echo $value['category_id']; ?>"><?php echo $value['category_desc']; ?></option>
			  <?php } ?>
			</select>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Nama Produk <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <input name="item_desc" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Satuan</label>
		  <div class="col-md-2">
		    <input name="item_unit" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Harga Beli</label>
		  <div class="col-md-4">
		    <input name="item_buy" class="form-control form-control-sm number">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Harga Jual <span class="text-danger">*</span></label>
		  <div class="col-md-4">
		    <input name="item_price" class="form-control form-control-sm number" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Supplier</label>
		  <div class="col-md-8">
		    <select name="supplier_id" class="form-control form-control-sm">
			  <option disabled selected>--- Pilih Supplier ---</option>
			  <?php foreach($supplier AS $value) { ?>
				<option value="<?php echo $value['supplier_id']; ?>"><?php echo $value['supplier_name']; ?></option>
			  <?php } ?>
			</select>
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