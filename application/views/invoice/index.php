<div class="mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <a href="invoice/formCreate" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Tambah
	  </a>
	  <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#filterInvoiceReport"><i class="fa fa-file"></i>
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
        <th>INVOICE</th>
        <th>PELANGGAN</th>
        <th class="text-left">TOTAL (Rp)</th>
        <th class="text-left">DISKON (Rp)</th>
        <th>SALES / MEKANIK</th>
        <th width="100" class="text-left">#</th>
      </tr>
    </thead>
  </table>
</div>

<div class="modal fade" id="messageInvoice" data-backdrop="static" role="dialog">
  <div class="modal-dialog modal-sm">
	<div class="modal-content">
	  <div class="modal-header bg-success">
		<h5 class="modal-title"><span>Notifikasi</span></h5>
	  </div>
	  <div>
		<div class="modal-body">
		  <center>
			<h2><i class="fa fa-check-circle"></i></h2>
			<h6><i>Transaksi berhasil disimpan !</i></h6>
		  </center>
		</div>
		<div class="modal-footer" style="justify-content:center">
		  <button type="button" id="closeMessageInvoice" class="btn btn-danger btn-sm btn-form"><i class="fa fa-times-circle">&nbsp;&nbsp;</i>Tutup</button>
		  <button type="button" id="printInvoice" class="btn btn-primary btn-sm btn-form"><i class="fa fa-print">&nbsp;&nbsp;</i>Cetak</button>
		</div>
	  </div>
	</div>
  </div>
</div>
