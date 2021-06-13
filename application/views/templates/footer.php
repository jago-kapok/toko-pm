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
	/* Purchase Report					
	/* ============================ */
	$('#purchase_report').click(function(){
	  var start_date	= $('.purchase').find('#start_date').val();
	  var to_date		= $('.purchase').find('#to_date').val();
	  var customer_id	= $('.purchase').find('#customer_id').val();
	  
	  window.open("report/printPurchase/" + start_date + '/' + to_date + '/' + customer_id);
	  $('#filterPurchaseReport').modal('hide');
	});
	
	/* ============================ */
	/* Invoice Report					
	/* ============================ */
	$('#invoice_report').click(function(){
	  var start_date	= $('.invoice').find('#start_date').val();
	  var to_date		= $('.invoice').find('#to_date').val();
	  var customer_id	= $('.invoice').find('#customer_id').val();
	  
	  window.open("report/printInvoice/" + start_date + '/' + to_date + '/' + customer_id);
	  $('#filterInvoiceReport').modal('hide');
	});
	
	/* ============================ */
	/* Invoice Service Report					
	/* ============================ */
	$('#invoice_service_report').click(function(){
	  var start_date	= $('.invoice_service').find('#start_date').val();
	  var to_date		= $('.invoice_service').find('#to_date').val();
	  
	  window.open("report/printInvoiceService/" + start_date + '/' + to_date);
	  $('#filterInvoiceServiceReport').modal('hide');
	});
	
	/* ============================ */
	/* Profit Report					
	/* ============================ */
	$('#profit_report').click(function(){
	  var start_date	= $('.profit').find('#start_date').val();
	  var to_date		= $('.profit').find('#to_date').val();
	  
	  window.open("report/printProfit/" + start_date + '/' + to_date);
	  $('#filterProfitReport').modal('hide');
	});
	
	/* ============================ */
	/* Other Report					
	/* ============================ */
	$('#other_report').click(function(){
	  var start_date	= $('.other').find('#start_date').val();
	  var to_date		= $('.other').find('#to_date').val();
	  
	  window.open("report/printOther/" + start_date + '/' + to_date);
	  $('#filterOtherReport').modal('hide');
	});
  </script>
</body>
</html>
