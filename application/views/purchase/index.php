<div class="mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <a href="purchase/formCreate" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Tambah
	  </a>
	  <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#filterPurchaseReport"><i class="fa fa-file"></i>
	    &nbsp;&nbsp;Laporan
	  </a>
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
        <th>TANGGAL</th>
        <th>TRANSAKSI</th>
        <th>SUPPLIER</th>
        <th class="text-left">TOTAL (Rp)</th>
        <th width="100">#</th>
      </tr>
    </thead>
  </table>
</div>
