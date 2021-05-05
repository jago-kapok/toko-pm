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
  bInfo 		: false,
  bLengthChange : false,
  serverSide	: true,
  ajax	: {
	url	: "<?= base_url('supplier/getData'); ?>",
	type: "GET"
  },
  iDisplayLength: 10,
  columns: [
	{data: null,				className: "text-left"},
	{data: "supplier_code",		className: "text-left"},
	{data: "supplier_name",		className: "text-left"},
	{data: "supplier_address",	className: "text-left"},
	{data: "supplier_phone",	className: "text-left"},
	{
	  data: "supplier_id",
	  render: function(data, type, row){
		return '<a href="javascript:void(0)" class="btn btn-info btn-xs fa fa-edit" data-toggle="modal" data-target="#supplier_update" data-supplier_id="' + data + '" data-supplier_code="' + row.supplier_code + '" data-supplier_name="' + row.supplier_name + '" data-supplier_address="' + row.supplier_address + '" data-supplier_phone="' + row.supplier_phone + '"></a>&nbsp;<a href="supplier/delete/' + data + '" class="btn btn-danger btn-xs" onclick="return confirm(\'Hapus data ini ?\')"><i class="fa fa-trash"></i></a>';
	  }
	}
	
  ],
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
$('#supplier_update').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var supplier_id		= button.data('supplier_id');
  var supplier_code		= button.data('supplier_code');
  var supplier_name		= button.data('supplier_name');
  var supplier_address	= button.data('supplier_address');
  var supplier_phone	= button.data('supplier_phone');
  
  var modal = $(this);
  modal.find('.modal-body input[name=supplier_id]').val(supplier_id);
  modal.find('.modal-body input[name=supplier_code]').val(supplier_code);
  modal.find('.modal-body input[name=supplier_name]').val(supplier_name);
  modal.find('.modal-body input[name=supplier_address]').val(supplier_address);
  modal.find('.modal-body input[name=supplier_phone]').val(supplier_phone);
});
</script>