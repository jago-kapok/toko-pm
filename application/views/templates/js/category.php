<script>
var table = $("table#table_data").DataTable({
  processing	: true,
  language	: {
	lengthMenu	: "_MENU_",
	zeroRecords	: "<center>Tidak Ada Data</center>",
	processing	: "<center>Silakan Tunggu</center>",
	paginate	: {
	  previous: "<i class=\"fa fa-chevron-left\"></i>",
	  next: "<i class=\"fa fa-chevron-right\"></i>"
	},
  },
  bInfo			: true,
  bLengthChange	: false,
  serverSide	: true,
  scrollX		: true,
  ajax	: {
	url	: "<?= base_url('category/getData'); ?>",
	type: "POST"
  },
  iDisplayLength: 10,
  columns	: [
	{data: "no",			className: "text-left", orderable: false},
	{data: "category_desc",	className: "text-left"},
	{data: "action",		className: "text-left", orderable: false}
  ],
});

$('#searching').on('keyup', function(){
  table.search(this.value).draw();
});

$('select#pagelength').on('change', function(){
  table.page.len(this.value).draw();
});

// Show data on modal
$('#category_update').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var category_id	= button.data('category_id');
  var category_desc	= button.data('category_desc');
  
  var modal = $(this);
  modal.find('.modal-body input[name=category_id]').val(category_id);
  modal.find('.modal-body input[name=category_desc]').val(category_desc);
});
</script>