<form action="<?= base_url('purchase/create'); ?>" class="container-fluid mt-2" method="POST">
  <div class="mb-1">
	<div class="form-row mb-1">
	  <label class="col-md-1 col-form-label">No. Transaksi</label>
	  <div class="col-md-2">
		<input name="purchase_number" class="form-control form-control-sm" required>
	  </div>
	  <label class="col-md-1 offset-md-5 col-form-label">Nama</label>
	  <label id="supplier_name" class="col-md-2 col-form-label">:</label>
	</div>
	<div class="form-row mb-1">
	  <label class="col-md-1 col-form-label">Tanggal <span class="text-danger">*</span></label>
	  <div class="col-md-2">
		<input type="date" name="purchase_date" class="form-control form-control-sm" value="<?php echo date('Y-m-d') ?>" required>
	  </div>
	  <label class="col-md-1 offset-md-5 col-form-label">Alamat</label>
	  <label id="supplier_address" class="col-md-2 col-form-label">:</label>
	</div>
	<div class="form-row mb-1">
	  <label class="col-md-1 col-form-label">Supplier <span class="text-danger">*</span></label>
	  <div class="col-md-2">
		<input type="hidden" id="supplier_id" name="supplier_id">
		<div class="input-group input-group-sm">
		  <input id="supplier_code" class="form-control form-control-sm" required>
		  <div class="input-group-append">
			<button type="button" id="supplier_clear" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
		  </div>
		</div>
	  </div>
	  <label class="col-md-1 offset-md-5 col-form-label">No. Telepon</label>
	  <label id="supplier_phone" class="col-md-2 col-form-label">:</label>
	</div>
  </div>
  <hr>
  <div class="form-row mb-1">
	<div class="col-md-3">
	  <div class="card">
		<div class="card-header bg-secondary"><span class="card-title">Tambah Detail</span></div>
		<div class="card-body">
		  <div class="mb-2">
			<label>Kode Produk</label>
			<div class="input-group input-group-sm">
			  <input id="item_code" class="form-control form-control-sm">
			  <div class="input-group-append">
				<button type="button" id="item_clear" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
			  </div>
			</div>
			<input type="hidden" id="item_id">
		  </div>
		  <div class="mb-2">
			<label>Deskripsi</label>
			<input id="item_desc" class="form-control form-control-sm" readonly>
		  </div>
		  <div class="form-row">
			<div class="col-md-7">
			  <label>Harga Beli</label>
			  <div class="input-group input-group-sm">
				<div class="input-group-prepend">
				  <span class="input-group-text">Rp</span>
				</div>
				<input id="item_price" class="form-control form-control-sm number">
			  </div>
			</div>
			<div class="col-md-5">
			  <label>Qty</label>
			  <div class="input-group input-group-sm">
			    <input id="item_qty" class="form-control form-control-sm number">
				<div class="input-group-append">
				  <span id="item_unit"class="input-group-text"></span>
				</div>
			  </div>
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
		<div class="card-header bg-secondary"><span class="card-title">Detail Pembelian</span></div>
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
				<td colspan="5" align="right"><b>TOTAL PEMBELIAN (Rp)</b></td>
				<td>
				  <input id="purchase_total" name="purchase_total" class="input-readonly number bg-other" style="font-weight:bold" readonly>
				</td>
				<td></td>
			  </tr>
			</tfoot>
		  </table>
		</div>
		<div class="card-footer">
		  <a href="../purchase" class="btn btn-sm btn-outline-danger">
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