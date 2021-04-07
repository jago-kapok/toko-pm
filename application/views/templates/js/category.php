<script>
var table = $("table#table_data").DataTable({
  processing	: true,
  language	: {
	lengthMenu	: "_MENU_",
	info		: "",
	infoEmpty	: "",
	search		: "",
	zeroRecords	: "<center>Tidak Ada Data</center>",
	processing	: "<center><span class=\"fa fa-refresh\"></span></center>",
	paginate	: {
	  previous: "<i class=\"fa fa-chevron-left\"></i>",
	  next: "<i class=\"fa fa-chevron-right\"></i>"
	},
	loadingRecords	: "<center><span class=\"fa fa-refresh\"></span></center>",
	searchPlaceholder	: "Kata Kunci",
  },
  bInfo			: false,
  bLengthChange	: false,
  serverSide	: true,
  ajax	: {
	url	: "<?= base_url('category/getData'); ?>",
	type: "POST"
  },
  iDisplayLength	: 10,
  columns	: [
	{data: "no",			className: "text-left", orderable: false},
	{data: "category_code",	className: "text-left"},
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
</script>