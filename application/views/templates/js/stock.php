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
	url	: "<?= base_url('stock/getData'); ?>",
	type: "GET"
  },
  iDisplayLength: 10,
  columns: [
	{data: null,				className: "text-left"},
	{data: "item_desc",			className: "text-left"},
	{data: "stock_exist",		className: "text-right"},
	{data: "stock_min",			className: "text-right"},
	{data: "stock_updated_date",className: "text-left"},
	{
	  data: "stock_id",
	  render: function(data, type, row){
		return '<a href="javascript:void(0)" class="btn btn-info btn-xs fa fa-edit" data-toggle="modal" data-target="#stock_update" data-stock_id="' + data + '" data-item_desc="' + row.item_desc + '" data-stock_min="' + row.stock_min + '" data-stock_exist="' + row.stock_exist + '"></a>';
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
$('#stock_update').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var stock_id		= button.data('stock_id');
  var item_desc		= button.data('item_desc');
  var stock_min		= button.data('stock_min');
  var stock_exist	= button.data('stock_exist');
  
  var modal = $(this);
  modal.find('.modal-body input[name=stock_id]').val(stock_id);
  modal.find('.modal-body input[name=item_desc]').val(item_desc);
  modal.find('.modal-body input[name=stock_min]').val(stock_min);
  modal.find('.modal-body input[name=stock_exist]').val(stock_exist);
});
</script>
