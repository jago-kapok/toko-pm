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
	url	: "<?= base_url('item/getData'); ?>",
	type: "GET"
  },
  iDisplayLength: 10,
  columns: [
	{data: null,			className: "text-left"},
	{data: "item_code",		className: "text-left"},
	{data: "category_desc",	className: "text-left"},
	{data: "item_desc",		className: "text-left"},
	{data: "item_unit",		className: "text-left"},
	{data: "item_price",	className: "text-right"},
	{data: "supplier_name",	className: "text-left"},
	{
	  data: "item_id",
	  render: function(data, type, row){
		return '<a href="javascript:void(0)" class="btn btn-info btn-xs fa fa-edit" data-toggle="modal" data-target="#item_update" data-item_id="' + data + '" data-item_code="' + row.item_code + '" data-category_id="' + row.category_id + '" data-item_desc="' + row.item_desc + '" data-item_unit="' + row.item_unit + '" data-item_buy="' + row.item_buy + '" data-item_buy="' + row.item_buy + '" data-item_price="' + row.item_price + '" data-supplier_id="' + row.supplier_id + '"></a>&nbsp;<a href="item/delete/' + data + '" class="btn btn-danger btn-xs" onclick="return confirm(\'Hapus data ini ?\')"><i class="fa fa-trash"></i></a>';
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

$('.filter-category').on('click', function(){
  table.search(this.id).draw();
});

// Show data on modal
$('#item_update').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var item_id		= button.data('item_id');
  var item_code		= button.data('item_code');
  var category_id	= button.data('category_id');
  var item_desc		= button.data('item_desc');
  var item_unit		= button.data('item_unit');
  var item_buy		= button.data('item_buy');
  var item_price	= button.data('item_price');
  var supplier_id	= button.data('supplier_id');
  
  var modal = $(this);
  modal.find('.modal-body input[name=item_id]').val(item_id);
  modal.find('.modal-body input[name=item_code]').val(item_code);
  modal.find('.modal-body select[name=category_id]').val(category_id);
  modal.find('.modal-body input[name=item_desc]').val(item_desc);
  modal.find('.modal-body input[name=item_unit]').val(item_unit);
  modal.find('.modal-body input[name=item_buy]').val(item_buy);
  modal.find('.modal-body input[name=item_price]').val(item_price);
  modal.find('.modal-body select[name=supplier_id]').val(supplier_id);
});
</script>