		<!-- <footer class="main-footer">
		  <div class="float-right d-none d-sm-block">
			<b>Version</b> 3.0.3-pre
	      </div>
	      <strong>Copyright &copy; - <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
	    </footer> -->
	  </section>
	</div>
  </div>

  <!-- Bootstrap 4 -->
  <script src="<?= base_url('assets/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="<?= base_url('assets/'); ?>plugins/datatables/jquery.dataTables.js"></script>
  <script src="<?= base_url('assets/'); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <script src="<?= base_url('assets/'); ?>dist/js/fnPagingInfo.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('assets/'); ?>dist/js/adminlte.min.js"></script>
  <!-- JQuery UI -->
  <script src="<?= base_url('assets/'); ?>dist/js/jquery-ui.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('assets/'); ?>dist/js/demo.js"></script>
  <!-- Chart Js -->
  <script src="<?= base_url('assets/'); ?>plugins/chart.js/Chart.min.js"></script>
  
  <script>
	/* ============================ */
	/* Autocomplete = Off							
	/* ============================ */
	$('.form-control').attr('autocomplete','off');
	
	/* ============================ */
	/* Number Only							
	/* ============================ */
    $('.number').keypress(function(event){
	  var charCode = event.keyCode
	  if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
		return false;
	  return true;
	});
	
  	/* ============================ */
	/* Simple DataTable							
	/* ============================ */
    var table = $('#example').DataTable({
	  "lengthChange": false
	});
	
	$('#searching').on('keyup', function(){
	  table.search(this.value).draw();
    });
	
	/* ============================ */
	/* get JSON							
	/* ============================ */
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
  </script>
</body>
</html>
