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
	url	: "<?= base_url('user/getData'); ?>",
	type: "GET"
  },
  iDisplayLength: 10,
  columns: [
	{data: null,			className: "text-left"},
	{data: "user_fullname",	className: "text-left"},
	{data: "user_name",		className: "text-left"},
	{data: "user_address",	className: "text-left"},
	{data: "user_phone",	className: "text-left"},
	{data: "level_desc",	className: "text-left"},
	{
	  data: "user_id",
	  render: function(data, type, row){
		return '<a href="javascript:void(0)" class="btn btn-info btn-xs fa fa-edit" data-toggle="modal" data-target="#user_update" data-user_id="' + data + '" data-user_fullname="' + row.user_fullname + '" data-user_name="' + row.user_name + '" data-user_address="' + row.user_address + '" data-user_phone="' + row.user_phone + '" data-user_level="' + row.user_level + '"></a>&nbsp;<a href="user/delete/' + data + '" class="btn btn-danger btn-xs" onclick="return confirm(\'Hapus data ini ?\')"><i class="fa fa-trash"></i></a>';
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
$('#user_update').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var user_id		= button.data('user_id');
  var user_fullname	= button.data('user_fullname');
  var user_name		= button.data('user_name');
  var user_address	= button.data('user_address');
  var user_phone	= button.data('user_phone');
  var user_level	= button.data('user_level');
  
  var modal = $(this);
  modal.find('.modal-body input[name=user_id]').val(user_id);
  modal.find('.modal-body input[name=user_fullname]').val(user_fullname);
  modal.find('.modal-body input[name=user_name]').val(user_name);
  modal.find('.modal-body input[name=user_address]').val(user_address);
  modal.find('.modal-body input[name=user_phone]').val(user_phone);
  modal.find('.modal-body select[name=user_level]').val(user_level);
});
</script>
