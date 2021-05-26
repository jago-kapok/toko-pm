<form action="<?= base_url('quotation/create'); ?>"  class="container-fluid mt-2" method="POST">
  <div class="mb-1">
	<div class="form-row mb-1">
	  <label class="col-md-1 col-form-label">Penawaran</label>
	  <div class="col-md-2">
		<input name="quotation_number" class="form-control form-control-sm" value="<?php echo $number ?>" readonly>
	  </div>
	  <label class="col-md-1 offset-md-5 col-form-label">Nama</label>
	  <label id="customer_name" class="col-md-2 col-form-label">:</label>
	  <input type="hidden" id="customer_desc" name="customer_desc">
	</div>
	<div class="form-row mb-1">
	  <label class="col-md-1 col-form-label">Tanggal <span class="text-danger">*</span></label>
	  <div class="col-md-2">
		<input type="date" name="quotation_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d') ?>" required>
	  </div>
	  <label class="col-md-1 offset-md-5 col-form-label">Alamat</label>
	  <label id="customer_address" class="col-md-2 col-form-label">:</label>
	</div>
	<div class="form-row mb-1">
	  <label class="col-md-1 col-form-label">Pelanggan <span class="text-danger">*</span></label>
	  <div class="col-md-2">
		<input type="hidden" id="customer_id" name="customer_id">
		<div class="input-group input-group-sm">
		  <input id="customer_code" name="customer_code" class="form-control form-control-sm" required>
		  <div class="input-group-append">
			<button id="customer_clear" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
		  </div>
		</div>
	  </div>
	  <label class="col-md-1 offset-md-5 col-form-label">No. Telepon</label>
	  <label id="customer_phone" class="col-md-2 col-form-label">:</label>
	</div>
  </div>
  <hr>
  <div class="form-row mb-1">
	<div class="col-md-3">
	  <div class="card">
		<div class="card-header bg-secondary">
		  <span class="card-title">Tambah Detail</span>
		  <div class="float-right">
            <button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#input_barcode">
			  <i class="fa fa-barcode"></i>
			</button>
		  </div>
		</div>
		<div class="card-body">
		  <div class="mb-2">
			<label>Kode Produk</label>
			<div class="input-group input-group-sm">
			  <input id="item_code" class="form-control form-control-sm">
			  <div class="input-group-append">
				<button type="button" id="item_clear" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
			  </div>
			</div>
			<input type="hidden" id="item_id" class="form-control form-control-sm">
		  </div>
		  <div class="mb-2">
			<label>Deskripsi</label>
			<input id="item_desc" class="form-control form-control-sm" readonly>
		  </div>
		  <div class="form-row">
			<div class="col-md-7">
			  <label>Harga Jual</label>
			  <div class="input-group input-group-sm">
				<div class="input-group-prepend">
				  <span class="input-group-text">Rp</span>
				</div>
				<input type="hidden" id="item_buy" class="form-control form-control-sm number">
				<input id="item_price" class="form-control form-control-sm number">
			  </div>
			</div>
			<div class="col-md-5">
			  <label>Qty</label>
			  <div class="input-group input-group-sm">
			    <input id="item_qty" class="form-control form-control-sm number">
				<div class="input-group-append">
				  <span id="item_unit" class="input-group-text"></span>
				</div>
			  </div>
			  <input type="hidden" id="item_stock_exist">
			  <small id="item_stock" class="form-text text-muted"></small>
			</div>
		  </div>
		</div>
		<div class="card-footer">
		  <center>
            <button id="item_add" type="button" name="customer_code" class="btn btn-sm btn-success btn-block">
			  <i class="fa fa-cart-plus"></i>&nbsp;&nbsp;Tambah Detail
			</button>
		  </center>
		</div>
	  </div>
	</div>
    <div class="col-md-9">
	  <div class="card">
		<div class="card-header bg-secondary"><span class="card-title">Detail Penawaran</span></div>
		<div class="card-body">
		  <table class="table table-bordered" width="100.1%">
			<thead class="bg-default">
			  <tr>
				<th width="10%">Kode</th>
				<th width="40%">Nama Produk</th>
				<th width="7%">Qty</th>
				<th width="8%">Unit</th>
				<th width="15%">Harga (Rp)</th>
				<th width="15%">Jumlah (Rp)</th>
				<th width="5%">#</th>
			  </tr>
			</thead>
			<tbody id="item_detail"></tbody>
			<tfoot>
			  <tr class="bg-other">
				<td colspan="5" align="right"><b>TOTAL PENAWARAN (Rp)</b></td>
				<td>
				  <input id="quotation_total" name="quotation_total" class="input-readonly number bg-other" style="font-weight:bold" readonly>
				</td>
				<td></td>
			  </tr>
			</tfoot>
		  </table>
		  <br>
		  <div class="form-row mb-1">
			<span class="col-md-1 col-form-label"><i>Catatan</i></span>
			<div class="col-md-11">
			  <input name="quotation_notes" class="form-control form-control-sm">
			</div>
		  </div>
		</div>
		<div class="card-footer">
		  <a href="../quotation" class="btn btn-sm btn-outline-danger">
			<i class="fa fa-ban"></i>&nbsp;&nbsp;Batalkan Transaksi
		  </a>
		  <div class="float-right">
            <button type="submit" name="submit" class="btn btn-sm btn-primary">
			  <i class="fa fa-save"></i>&nbsp;&nbsp;Simpan Transaksi
			</button>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</form>

<div class="modal fade" id="input_barcode" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-barcode"></i>&nbsp;&nbsp;Barcode Scanner</h5>
      </div>
      <div class="modal-body">
        <center>
		  Scan barcode pada produk ...
		  <input type="text" id="item_barcode" class="input-readonly text-center" oninput="detectBarcode(this.value)" style="color:transparent">
		  <span id="item_not_found" class="text-danger"></span>
        </center>
      </div>
      <div class="modal-footer">
        <button type="button" id="input_barcode_stop" class="btn btn-sm btn-danger" data-dismiss="modal">Stop</button>
      </div>
    </div>
  </div>
</div>
