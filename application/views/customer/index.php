<div class="container-fluid mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_customer"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Insert Customer
	  </button>
	  <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#import_customer"><i class="fa fa-file-import"></i>
	    &nbsp;&nbsp;Import Data
	  </button>
	</div>
	<div class="col-md-4 pull-right">
	  <div class="input-group">
		<input id="searching" class="form-control form-control-sm" placeholder="Search Data ...">
		<span class="input-group-append">
		  <a href="<?= base_url('customer/export') ?>" class="btn btn-success btn-sm"><i class="fa fa-file-download"></i>
			&nbsp;&nbsp;Export Data
		  </a>
		</span>
	  </div>
	</div>
  </div>
  <table id="example" class="table table-striped">
	<thead class="bg-info">
      <tr>
		<th>#</th>
        <th class="w-25">Reg. Number</th>
        <th class="w-25">Customer Name</th>
        <th class="w-50">Customer Address</th>
        <th class="w-25">Capacity</th>
        <th class="w-25">Rates</th>
        <th class="w-25">Latitude</th>
        <th class="w-25">Longitude</th>
        <th class="w-25">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $a = 1;
        foreach($customer as $c) { ?>
        <tr>
          <th scope="row"><?= $a++; ?></th>
          <td><?= $c['noreg_pelanggan']; ?></td>
          <td><?= $c['nama_pelanggan']; ?></td>
          <td><?= $c['alamat_pelanggan']; ?></td>
          <td><?= $c['daya']; ?></td>
          <td><?= $c['tarif']; ?></td>
          <td><?= $c['lat']; ?></td>
          <td><?= $c['lang']; ?></td>
          <td>
            <a href="javascript:void(0)" class="badge badge-info p-1" title="Edit Data" data-toggle="modal" data-target="#update_customer"
			  data-id_pelanggan="<?= $c['id_pelanggan']; ?>"
			  data-noreg_pelanggan="<?= $c['noreg_pelanggan']; ?>"
			  data-nama_pelanggan="<?= $c['nama_pelanggan']; ?>"
			  data-alamat_pelanggan="<?= $c['alamat_pelanggan']; ?>"
			  data-daya="<?= $c['daya']; ?>"
			  data-tarif="<?= $c['tarif']; ?>"
			  data-lat="<?= $c['lat']; ?>"
			  data-lang="<?= $c['lang']; ?>"
			>
			  <i class="fas fa-edit"></i>
		    </a>
            <a href="<?= base_url('customer/delete/').$c['id_pelanggan']; ?>" class="badge badge-danger p-1" title="Delete Data" onclick="return confirm('Are you sure to delete this ?')">
			  <i class="fas fa-trash"></i>
		    </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
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