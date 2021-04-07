		<!-- <footer class="main-footer">
		  <div class="float-right d-none d-sm-block">
			<b>Version</b> 3.0.3-pre
	      </div>
	      <strong>Copyright &copy; - <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
	    </footer> -->
	  </section>
	</div>
  </div>

  <!-- jQuery -->
  <script src="<?= base_url('assets/'); ?>plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?= base_url('assets/'); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/'); ?>dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/'); ?>dist/js/demo.js"></script>
  <!-- Chart Js -->
  <script src="<?= base_url('assets/'); ?>plugins/chart.js/Chart.min.js"></script>
  
  <script>
  	// Setting DataTable
    var table = $('#example').DataTable({
	  "lengthChange": false
	});
	
	$('#searching').on('keyup', function(){
	  table.search(this.value).draw();
    });
	
	// Menangkap data user dari modal
	$('#update_user').on('show.bs.modal', function(event){
	  var button = $(event.relatedTarget);
	  var id_user = button.data('id_user');
	  var nama_user = button.data('nama_user');
	  var username = button.data('username');
	  var password = button.data('password');
	  var email_user = button.data('email_user');
	  var telp_user = button.data('telp_user');
	  var id_level = button.data('id_level');
	  
	  var modal = $(this);
	  modal.find('.modal-title').text('Update User : ' + nama_user);
	  modal.find('.modal-body input[name=id_user]').val(id_user);
	  modal.find('.modal-body input[name=nama_user]').val(nama_user);
	  modal.find('.modal-body input[name=username]').val(username);
	  modal.find('.modal-body input[name=password]').val(password);
	  modal.find('.modal-body select[name=id_level]').val(id_level);
	  modal.find('.modal-body input[name=email_user]').val(email_user);
	  modal.find('.modal-body input[name=telp_user]').val(telp_user);
	});
	
	// Menangkap data pelanggan dari modal
	$('#update_customer').on('show.bs.modal', function(event){
	  var button = $(event.relatedTarget);
	  var id_pelanggan = button.data('id_pelanggan');
	  var noreg_pelanggan = button.data('noreg_pelanggan');
	  var nama_pelanggan = button.data('nama_pelanggan');
	  var alamat_pelanggan = button.data('alamat_pelanggan');
	  var daya = button.data('daya');
	  var tarif = button.data('tarif');
	  var lat = button.data('lat');
	  var lang = button.data('lang');
	  
	  var modal = $(this);
	  modal.find('.modal-title').text('Update Customer : ' + noreg_pelanggan + ' / ' + nama_pelanggan);
	  modal.find('.modal-body input[name=id_pelanggan]').val(id_pelanggan);
	  modal.find('.modal-body input[name=noreg_pelanggan]').val(noreg_pelanggan);
	  modal.find('.modal-body input[name=nama_pelanggan]').val(nama_pelanggan);
	  modal.find('.modal-body input[name=alamat_pelanggan]').val(alamat_pelanggan);
	  modal.find('.modal-body select[name=daya]').val(daya);
	  modal.find('.modal-body select[name=tarif]').val(tarif);
	  modal.find('.modal-body input[name=lat]').val(lat);
	  modal.find('.modal-body input[name=lang]').val(lang);
	});
	
	// Menangkap data target dari modal
	$('#update_target').on('show.bs.modal', function(event){
	  var button = $(event.relatedTarget);
	  var id_target = button.data('id_target');
	  var id_pelanggan = button.data('id_pelanggan');
	  var id_status = button.data('id_status');
	  
	  var modal = $(this);
	  modal.find('.modal-title').text('Update Target : ' + id_pelanggan);
	  modal.find('.modal-body input[name=id_target]').val(id_target);
	  modal.find('.modal-body select[name=id_pelanggan]').val(id_pelanggan);
	  modal.find('.modal-body select[name=id_status]').val(id_status);
	});
	
	// Menangkap data target dari modal
	$('#send_target').on('show.bs.modal', function(event){
	  var button = $(event.relatedTarget);
	  var id_target = button.data('id_target');
	  var id_user = button.data('id_user');
	  
	  var modal = $(this);
	  modal.find('.modal-body input[name=id_target]').val(id_target);
	  modal.find('.modal-body select[name=id_user]').val(id_user);
	});
	
	// Menangkap data harmet dari modal
	$('#update_harmet').on('show.bs.modal', function(event){
	  var button = $(event.relatedTarget);
	  var id_harmet = button.data('id_harmet');
	  var id_pelanggan = button.data('id_pelanggan');
	  var merk_harmet = button.data('merk_harmet');
	  var no_meter_harmet = button.data('no_meter_harmet');
	  var tahun_harmet = button.data('tahun_harmet');
	  var stan_harmet = button.data('stan_harmet');
	  var no_ba_harmet = button.data('no_ba_harmet');
	  var tanggal_ba_harmet = button.data('tanggal_ba_harmet');
	  
	  var modal = $(this);
	  modal.find('.modal-body input[name=id_harmet]').val(id_harmet);
	  modal.find('.modal-body input[name=id_pelanggan]').val(id_pelanggan);
	  modal.find('.modal-body #merk_harmet').val(merk_harmet);
	  modal.find('.modal-body #no_meter_harmet').val(no_meter_harmet);
	  modal.find('.modal-body #tahun_harmet').val(tahun_harmet);
	  modal.find('.modal-body #stan_harmet').val(stan_harmet);
	  modal.find('.modal-body #no_ba_harmet').val(no_ba_harmet);
	  modal.find('.modal-body #tanggal_ba_harmet').val(tanggal_ba_harmet);
	});
	
	// Menangkap data harmet target dari modal
	$('#update_harmet_target').on('show.bs.modal', function(event){
	  var button = $(event.relatedTarget);
	  var id_harmet_target = button.data('id_harmet_target');
	  var hari_harmet_target = button.data('hari_harmet_target');
	  var bulan_harmet_target = button.data('bulan_harmet_target');
	  var tahun_harmet_target = button.data('tahun_harmet_target');
	  
	  var modal = $(this);
	  modal.find('.modal-body input[name=id_harmet_target]').val(id_harmet_target);
	  modal.find('.modal-body input[name=hari_harmet_target]').val(hari_harmet_target);
	  modal.find('.modal-body input[name=bulan_harmet_target]').val(bulan_harmet_target);
	  modal.find('.modal-body input[name=tahun_harmet_target]').val(tahun_harmet_target);
	});
	
	// Mengambil data JSON dari tabel customer berdasar id
	$('select[name=id_pelanggan]').change(function(){
	  if(this.value == 'New'){
		$('input[name=nama_pelanggan]').val('');
		$('input[name=alamat_pelanggan]').val('');
		$('input[name=nama_pelanggan]').attr('disabled', false);
	    $('input[name=alamat_pelanggan]').attr('disabled', false);
	  } else {
		$('input[name=nama_pelanggan]').val('');
		$('input[name=alamat_pelanggan]').val('');
		$('input[name=nama_pelanggan]').attr('disabled', false);
		$('input[name=alamat_pelanggan]').attr('disabled', false);
		  
		$.getJSON("customer/data/" + this.value, function(data){
		  $.each(data, function(key, value){
			$('input[name=nama_pelanggan]').val(value.nama_pelanggan);
			$('input[name=alamat_pelanggan]').val(value.alamat_pelanggan);
			$('input[name=nama_pelanggan]').attr('disabled', true);
			$('input[name=alamat_pelanggan]').attr('disabled', true);
		  });
		});
	  }
	});
	
	// Disable dropdown id_pelanggan
	$('input[name=nama_pelanggan]').keyup(function(){
	  if(this.value == ''){
		$('select[name=id_pelanggan]').attr('disabled', false);
	  } else {
		$('select[name=id_pelanggan]').attr('disabled', true);
	  }
	});
  </script>
</body>
</html>