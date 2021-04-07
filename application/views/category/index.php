<div class="mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_customer"><i class="fa fa-plus-square"></i>
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
  <table id="table_data" class="table table-bordered table-striped">
	<thead class="bg-info">
      <tr>
		<th width="5">No.</th>
        <th>Kode</th>
        <th>Deskripsi</th>
        <th>#</th>
      </tr>
    </thead>
  </table>
</div>

<div class="modal fade" id="create_customer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Insert New Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('customer/create'); ?>" method="POST">
      <div class="modal-body">
		<div class="form-row">
		  <div class="form-group col-md-4">
			<label>Reg. Number <span class="text-danger">*</span></label>
			<input name="noreg_pelanggan" class="form-control form-control-sm" required>
		  </div>
		  <div class="form-group col-md-8">
			<label>Customer Name <span class="text-danger">*</span></label>
			<input name="nama_pelanggan" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-group">
		  <label>Customer Address <span class="text-danger">*</span></label>
		  <input name="alamat_pelanggan" class="form-control form-control-sm" required>
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Capacity</label>
			<select name="daya" class="form-control form-control-sm">
              <option selected disabled>Choose Capacity</option>
              <?php
                foreach($daya as $d) { ?>
				  <option value="<?= $d['daya']; ?>"><?= $d['daya']; ?></option>
              <?php } ?>
            </select>
		  </div>
		  <div class="form-group col-md-6">
			<label>Rates</label>
			<select name="tarif" class="form-control form-control-sm">
			  <option selected disabled>Choose Rates</option>
			  <?php
			    foreach($tarif as $t) { ?>
				  <option value="<?= $t['golongan']; ?>"><?= $t['golongan']; ?></option>
			  <?php } ?>
			</select>
		  </div>
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Latitude</label>
			<input name="lat" class="form-control form-control-sm">
		  </div>
		  <div class="form-group col-md-6">
			<label>Longitude</label>
			<input name="lang" class="form-control form-control-sm">
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
	    <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.png" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Save</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="update_customer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Edit Data Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('customer/update'); ?>" method="POST">
      <div class="modal-body">
		<div class="form-row">
		  <div class="form-group col-md-4">
			<label>Reg. Number <span class="text-danger">*</span></label>
			<input type="hidden" name="id_pelanggan" class="form-control form-control-sm" required>
			<input name="noreg_pelanggan" class="form-control form-control-sm" required>
		  </div>
		  <div class="form-group col-md-8">
			<label>Customer Name <span class="text-danger">*</span></label>
			<input name="nama_pelanggan" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-group">
		  <label>Customer Address <span class="text-danger">*</span></label>
		  <input name="alamat_pelanggan" class="form-control form-control-sm" required>
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Capacity</label>
			<select name="daya" class="form-control form-control-sm">
              <option selected disabled>Choose Capacity</option>
              <?php
                foreach($daya as $d) { ?>
				  <option value="<?= $d['daya']; ?>"><?= $d['daya']; ?></option>
              <?php } ?>
            </select>
		  </div>
		  <div class="form-group col-md-6">
			<label>Rates</label>
			<select name="tarif" class="form-control form-control-sm">
			  <option selected disabled>Choose Rates</option>
			  <?php
			    foreach($tarif as $t) { ?>
				  <option value="<?= $t['golongan']; ?>"><?= $t['golongan']; ?></option>
			  <?php } ?>
			</select>
		  </div>
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Latitude</label>
			<input name="lat" class="form-control form-control-sm">
		  </div>
		  <div class="form-group col-md-6">
			<label>Longitude</label>
			<input name="lang" class="form-control form-control-sm">
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
	    <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.png" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Update</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="import_customer" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Import Data Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('customer/import'); ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
		  <label>Choose Excel File</label>
		  <input type="file" name="excel_file" class="form-control form-control-sm" required>
		</div>
	  </div>
      <div class="modal-footer">
		<img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.png" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Process</button>
      </div>
	  </form>
    </div>
  </div>
</div>