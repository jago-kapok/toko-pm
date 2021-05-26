<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pandu Mulya - Nganjuk</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="icon" href="<?= base_url('assets/'); ?>dist/img/AdminLTELogo.png" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="<?= base_url('assets/'); ?>plugins/jquery/jquery.min.js"></script>
  <!-- JQuery UI -->
  <link rel="stylesheet" href="<?= base_url('assets/'); ?>dist/css/jquery-ui.css">
  <!-- Google Font: Source Sans Pro -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
  
  <!-- Maps -->
  <!--<script src="https://api.mapbox.com/mapbox-gl-js/v1.8.0/mapbox-gl.js"></script>
  <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v1.8.0/mapbox-gl.css">-->
  
  <style>
    body { font-family: Arial; font-size:85% }
	.dataTables_filter { display: none }
	:not(.layout-fixed) .main-sidebar { height: 110%}
	.btn-form { width: 100px }
	.alert-success { color:#155724; background-color:#d4edda; border-color:#c3e6cb }
	.alert-danger { color:#571515; background-color:#edd4d4; border-color:#e6c3c3 }
	.nav-sidebar .nav-item > .nav-link { color: white }
	.nav-treeview .nav-item > .nav-link { margin-left: 35px !important }
	.btn.btn-xs { width: 2em }
	select#pagelength { border-radius: 0 .2em .2em 0 }
	.table td, .table th { padding: 5px 10px }
	.table th { text-align: center }
	.card-header { padding: .5rem 1.25rem }
	.card-title { font-size: 15px; font-weight: bold }
	.text-center { text-align: center }
	.text-left { text-align: left !important }
	.number { text-align: right }
	input.input-readonly { border: none; outline: none; width: 100% }
	input.input-outline { width: 100% }
	.bg-other { background-color: #f4f6f9 } #e9ecef
  </style>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse layout-navbar-fixed layout-fixed">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link p-1"><h4><?= $title ?></h4></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a href="#" class="nav-link" data-toggle="dropdown">
		  Selamat Datang, <?= $this->session->userdata('user_fullname'); ?>&nbsp;
		  <i class="far fa-user-circle"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <span class="dropdown-item dropdown-header">User's Menu</span>
          <div class="dropdown-divider"></div>
          <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#update_user"
		    data-id_user="<?= $this->session->userdata('user_id'); ?>"
			data-nama_user="<?= $this->session->userdata('user_fullname'); ?>"
			data-username="<?= $this->session->userdata('user_name'); ?>"
			data-password="<?= $this->session->userdata('user_password'); ?>"
			data-address_user="<?= $this->session->userdata('user_address'); ?>"
			data-telp_user="<?= $this->session->userdata('user_phone'); ?>"
		  >
            <i class="fas fa-user-cog mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Sign Out
          </a>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #5f676e">
    <a href="javascript:void(0)" class="brand-link" style="border-bottom: 1px solid; background-color: #5f676e">
      <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo.png"
        alt="Pandu Mulya"
        class="brand-image img-circle elevation-3"
        style="opacity: .8">
      <span class="brand-text font-weight-light"><img src="<?= base_url('assets/'); ?>dist/img/logo.png" style="width: 70%;
		padding-left: 5%;
		margin-top: -3%;">
	  </span>
    </a>
	
	<div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid white">
        <div class="image">
          <img src="<?= base_url('assets/'); ?>dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info" style="margin-top:-6px">
          <span class="d-block text-light">&nbsp;&nbsp;<strong><?= $this->session->userdata('user_fullname'); ?></strong></span>
          <span class="d-block text-light">&nbsp;&nbsp;<?= $this->session->userdata('level'); ?></span>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		  <li class="nav-item">
            <a href="<?= base_url('/'); ?>" class="nav-link" style="color:#bfd6f7">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                &nbsp;&nbsp;Dashboard
              </p>
            </a>
          </li>
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color:#f7bfbf">
              <i class="nav-icon fas fa-table"></i>
              <p>
                &nbsp;&nbsp;Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('category'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('customer'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Pelanggan</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?= base_url('item'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Produk</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  <li class="nav-item has-treeview">
            <a href="<?= base_url('quotation'); ?>" class="nav-link" style="color:#f7e8bf">
              <i class="nav-icon fas fa-file"></i>
              <p>
                &nbsp;&nbsp;Penawaran
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('quotation'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Data Penawaran</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color:#bff7c1">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                &nbsp;&nbsp;Penjualan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
			  <li class="nav-item">
                <a href="<?= base_url('invoice'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Data Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('invoice/formCreate'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Penjualan Baru</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color:#bfd6f7">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                &nbsp;&nbsp;Pembelian
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('purchase'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Data Pembelian</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?= base_url('supplier'); ?>" class="nav-link ml-5">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Supplier</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  <li class="nav-item">
            <a href="<?= base_url('/stock'); ?>" class="nav-link" style="color:#f7bfbf">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                &nbsp;&nbsp;Data Stok
              </p>
            </a>
          </li>
		  
		  <li class="nav-item">
            <a href="<?= base_url('/stockHistory'); ?>" class="nav-link" style="color:#f7e8bf">
              <i class="nav-icon fas fa-history"></i>
              <p>
                &nbsp;&nbsp;Riwayat Stok
              </p>
            </a>
          </li>
		  
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link" style="color:#bff7c1">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                &nbsp;&nbsp;Laporan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-5" data-toggle="modal" data-target="#filterQuotationReport">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Pembelian</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-5" data-toggle="modal" data-target="#filterInvoiceReport">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="javascript:void(0)" class="nav-link ml-5" data-toggle="modal" data-target="#filterAllReport">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Rugi / Laba</p>
                </a>
              </li>
            </ul>
          </li>
		  
		  <li class="dropdown-divider"></li>
		  
		  <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                &nbsp;&nbsp;Pengaturan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?= base_url('user'); ?>" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Manajemen User</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="<?= base_url('harmet/setting'); ?>" class="nav-link">
                  <i class="fas fa-caret-right nav-icon"></i>
                  <p>&nbsp;&nbsp;Profil Usaha</p>
                </a>
              </li>
            </ul>
          </li>
		</ul>
	  </nav>
	</div>
  </aside>
  
  <div class="modal fade" id="filterQuotationReport" role="dialog">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header bg-info">
		  <h5 class="modal-title"><span>Laporan Penawaran</span></h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span>&times;</span>
		  </button>
		</div>
		<form action="<?= base_url('quotationReport'); ?>" method="POST">
		  <div class="modal-body">
			<div class="form-group">
			  <label>Dari Tanggal <span class="text-danger">*</span></label>
			  <input type="date" name="start_date" class="form-control form-control-sm" required>
			</div>
			<div class="form-group">
			  <label>Sampai Tanggal <span class="text-danger">*</span></label>
			  <input type="date" name="finish_date" class="form-control form-control-sm" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Batal</button>
			<button type="submit" class="btn btn-primary btn-sm btn-form">Submit</button>
		  </div>
		</form>
	  </div>
	</div>
  </div>
  
  <div class="modal fade" id="filterInvoiceReport" role="dialog">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header bg-info">
		  <h5 class="modal-title"><span>Laporan Penjualan</span></h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span>&times;</span>
		  </button>
		</div>
		<form action="<?= base_url('invoiceReport'); ?>" method="POST">
		  <div class="modal-body">
			<div class="form-group">
			  <label>Dari Tanggal <span class="text-danger">*</span></label>
			  <input type="date" name="start_date" class="form-control form-control-sm" required>
			</div>
			<div class="form-group">
			  <label>Sampai Tanggal <span class="text-danger">*</span></label>
			  <input type="date" name="finish_date" class="form-control form-control-sm" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Batal</button>
			<button type="submit" class="btn btn-primary btn-sm btn-form">Submit</button>
		  </div>
		</form>
	  </div>
	</div>
  </div>
  
  <div class="modal fade" id="filterAllReport" role="dialog">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header bg-info">
		  <h5 class="modal-title"><span>Laporan Rugi Laba</span></h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span>&times;</span>
		  </button>
		</div>
		<form action="<?= base_url('allReport'); ?>" method="POST">
		  <div class="modal-body">
			<div class="form-group">
			  <label>Dari Tanggal <span class="text-danger">*</span></label>
			  <input type="date" name="start_date" class="form-control form-control-sm" required>
			</div>
			<div class="form-group">
			  <label>Sampai Tanggal <span class="text-danger">*</span></label>
			  <input type="date" name="finish_date" class="form-control form-control-sm" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Batal</button>
			<button type="submit" class="btn btn-primary btn-sm btn-form">Submit</button>
		  </div>
		</form>
	  </div>
	</div>
  </div>
  
    <div class="modal fade" id="update_user" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-info">
			<h5 class="modal-title"><span>Edit Profil</span></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span>&times;</span>
			</button>
		  </div>
		  <form action="<?= base_url('user/update'); ?>" method="POST">
		  <div class="modal-body">
			<div class="form-group">
			  <label>Nama Lengkap</label>
			  <input type="hidden" name="user_id" class="form-control form-control-sm">
			  <input name="user_fullname" class="form-control form-control-sm">
			</div>
			<div class="form-row">
			  <div class="form-group col-md-6">
				<label>Username <span class="text-danger">*</span></label>
				<input name="user_name" class="form-control form-control-sm" readonly>
			  </div>
			  <div class="form-group col-md-6">
				<label>New Password <span class="text-danger">*</span></label>
				<input type="password" name="user_password" class="form-control form-control-sm" required>
			  </div>
			</div>
			<div class="form-row">
			  <div class="form-group col-md-6">
				<label>Alamat</label>
				<input name="user_address" class="form-control form-control-sm">
			  </div>
			  <div class="form-group col-md-6">
				<label>No. Telepon</label>
				<input type="tel" name="user_phone" class="form-control form-control-sm">
			  </div>
			</div>
		  </div>
		  <div class="modal-footer">
			<img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.jpeg" class="mr-auto" width="115">
			<button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-primary btn-sm btn-form">Update</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
  
	<div class="content-wrapper">
	  <section class="content p-2">
