<script>
var table = $("table#table_data").DataTable({
  processing 	: true,
  language	: {
	lengthMenu	: "_MENU_",
	zeroRecords	: "<center>Tidak Ada Data</center>",
	processing	: "<center>Silakan Tunggu</center>",
	paginate	: {
	  previous: "<i class=\"fa fa-chevron-left\"></i>",
	  next: "<i class=\"fa fa-chevron-right\"></i>"
	},
  },
  bInfo 		: true,
  bLengthChange : false,
  serverSide	: true,
  scrollX		: true,
  ajax	: {
	url	: "<?= base_url('customer/getData'); ?>",
	type: "GET"
  },
  iDisplayLength: 10,
  columns: [
	{data: null,				className: "text-left"},
	{data: "customer_code",		className: "text-left"},
	{data: "customer_name",		className: "text-left"},
	{data: "customer_address",	className: "text-left"},
	{data: "customer_phone",	className: "text-left"},
	{
	  data: "customer_id",
	  render: function(data, type, row){
		return '<a href="javascript:void(0)" class="btn btn-info btn-xs fa fa-edit" data-toggle="modal" data-target="#customer_update" data-customer_id="' + data + '" data-customer_code="' + row.customer_code + '" data-customer_name="' + row.customer_name + '" data-customer_address="' + row.customer_address + '" data-customer_phone="' + row.customer_phone + '"></a>&nbsp;<a href="customer/delete/' + data + '" class="btn btn-danger btn-xs" onclick="return confirm(\'Hapus data ini ?\')"><i class="fa fa-trash"></i></a>';
	  }
	}
  ],
  order: [[5, "DESC"]],
  rowCallback: function(row, data, iDisplayIndex){
	var info 	= this.fnPagingInfo();
	var page 	= info.iPage;
	var length 	= info.iLength;
	var index 	= page * length + (iDisplayIndex + 1);
	$("td:eq(0)", row).html(index);
  }
});

$('#searching').on('keyup', function(){
  table.search(this.value).draw();
});

$('select#pagelength').on('change', function(){
  table.page.len(this.value).draw();
});

// Show data on modal
$('#customer_update').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var customer_id		= button.data('customer_id');
  var customer_code		= button.data('customer_code');
  var customer_name		= button.data('customer_name');
  var customer_address	= button.data('customer_address');
  var customer_phone	= button.data('customer_phone');
  
  var modal = $(this);
  modal.find('.modal-body input[name=customer_id]').val(customer_id);
  modal.find('.modal-body input[name=customer_code]').val(customer_code);
  modal.find('.modal-body input[name=customer_name]').val(customer_name);
  modal.find('.modal-body input[name=customer_address]').val(customer_address);
  modal.find('.modal-body input[name=customer_phone]').val(customer_phone);
});
</script>
