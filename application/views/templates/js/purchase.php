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
	url	: "<?= base_url('purchase/getData'); ?>",
	type: "GET"
  },
  iDisplayLength: 10,
  columns: [
	{data: null,				className: "text-left"},
	{data: "purchase_date",		className: "text-left"},
	{data: "purchase_number",	className: "text-left"},
	{data: "supplier_name",		className: "text-left"},
	{data: "purchase_total",	className: "text-left"},
	{
	  data: "purchase_id",
	  render: function(data, type, row){
		return '<a href="javascript:void(0)" class="btn btn-info btn-xs fa fa-edit"></a>&nbsp;<a href="customer/delete/' + data + '" class="btn btn-danger btn-xs" onclick="return confirm(\'Hapus data ini ?\')"><i class="fa fa-trash"></i></a>';
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

/* ============================ */
/* Item							
/* ============================ */

$("#item_code").autocomplete({
  source: "<?= base_url('purchase/itemData'); ?>",
  minLength: 2,
  select: function(event, ui){
    $('#item_id').val(ui.item.item_id);
    $('#item_code').val(ui.item.item_code);
    $('#item_desc').val(ui.item.item_desc);
    $('#item_unit').text(ui.item.item_unit);
      return false;
  }
}).each(function(){
  $(this).autocomplete("instance")._renderItem = function(ul, item){
    return $("<li>")
    .append("<div style='font-size:12px; line-height:20px'><span><b>" + item.item_code + "</b></span><span style='display:block'><i>" + item.item_desc + "</i></span></div>")
    .appendTo(ul);
  }
});

/* ============================ */
/* Item	Clear Unit						
/* ============================ */

$("#item_clear").click(function(){
  $("#item_unit").empty();
});

/* ============================ */
/* Item	Simpan Detail						
/* ============================ */

var no = 0;

$("#item_add").click(function(){
  no++;
  let item_code		= $("#item_code").val();
  let item_desc		= $("#item_desc").val();
  let item_price	= $("#item_price").val();
  let item_qty		= $("#item_qty").val();
  let item_unit		= $("#item_unit").text();
  
  if(item_code != ''){
	$("#item_detail").append("<tr id='detail" + no + "'></tr>");
	$("#detail" + no)
	  .append("<td><input name='item_code[" + no + "]' class='input-readonly' value='" + item_code + "'></td>")
	  .append("<td><input name='item_desc[" + no + "]' class='input-readonly' value='" + item_desc + "'></td>")
	  .append("<td><input name='item_qty[" + no + "]' class='input-readonly number' value='" + item_qty + "'></td>")
	  .append("<td><input name='item_unit[" + no + "]' class='input-readonly' value='" + item_unit + "'></td>")
	  .append("<td><input name='item_price[" + no + "]' class='input-readonly number' value='" + item_price + "'></td>")
	  .append("<td><button id='detail" + no + "' type='button' class='btn btn-xs btn-danger' onclick='removeItem(this.id)'><i class='fa fa-trash'></i></button></td>");
	  
	  $("#item_clear").click();
  } else {
	alert("Barang tidak boleh kosong !");
  }
});

/* ============================ */
/* Item	Remove Item						
/* ============================ */

function removeItem(id){
  $("#" + id).remove();
}
</script>
