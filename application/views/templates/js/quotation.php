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
	url	: "<?= base_url('quotation/getData'); ?>",
	type: "GET"
  },
  iDisplayLength: 10,
  columns: [
	{data: null,				className: "text-left"},
	{data: "quotation_date",	className: "text-left"},
	{data: "quotation_number",	className: "text-left"},
	{data: "customer_desc",		className: "text-left"},
	{data: "quotation_total",	className: "text-right"},
	{data: "status_desc",		className: "text-left"},
	{
	  data: "quotation_id",
	  render: function(data, type, row){
		if(row.status_desc == "INVOICED"){
		  invoice_status = "hidden";
		} else {
		  invoice_status = "";
		}
		
		return '<a href="quotation/update/' + data + '" class="btn btn-info btn-xs fa fa-edit"></a>&nbsp;<a href="quotation/invoice/' + data + '" class="btn btn-success btn-xs" onclick="return confirm(\'Anda yakin ingin membuat invoice dari penawaran ini ?\')" ' + invoice_status + '><i class="fa fa-check"></i></a>&nbsp;<a href="quotation/prints/' + data + '" class="btn btn-warning btn-xs" target="_blank"><i class="fa fa-print"></i></a>&nbsp;<a href="quotation/delete/' + data + '" class="btn btn-danger btn-xs" onclick="return confirm(\'Anda yakin ingin menghapus data ini ?\')"><i class="fa fa-trash"></i></a>';
	  }
	}
  ],
  order: [[6, "DESC"]],
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
/* customer							
/* ============================ */

$("#customer_code").autocomplete({
  source: "<?= base_url('customer/findData'); ?>",
  minLength: 2,
  select: function(event, ui){
    $("#customer_id").val(ui.item.customer_id);
    $("#customer_code").val(ui.item.customer_code);
    $("#customer_name").text(": " + ui.item.customer_name);
    $("#customer_desc").val(ui.item.customer_name);
    $("#customer_address").text(": " + ui.item.customer_address);
    $("#customer_phone").text(": " + ui.item.customer_phone);
	
	$("#customer_code").attr("readonly", true);
	$("#item_code").focus();
      return false;
  }
}).each(function(){
  $(this).autocomplete("instance")._renderItem = function(ul, customer){
    return $("<li>")
    .append("<div style='font-size:12px; line-height:20px'><span><b>" + customer.customer_code + "</b></span><span style='display:block'><i>" + customer.customer_name + "</i></span></div>")
    .appendTo(ul);
  }
});

/* ============================ */
/* Item							
/* ============================ */

$("#item_code").autocomplete({
  source: "<?= base_url('item/findData'); ?>",
  minLength: 2,
  select: function(event, ui){
    $("#item_id").val(ui.item.item_id);
    $("#item_code").val(ui.item.item_code);
    $("#item_desc").val(ui.item.item_desc);
    $("#item_price").val(ui.item.item_price);
    $("#item_buy").val(ui.item.item_buy);
    $("#item_unit").text(ui.item.item_unit);
    $("#item_stock").text("Sisa stok : " + ui.item.stock_exist);
    $("#item_stock_exist").val(ui.item.stock_exist);
	
	$("#item_code").attr("readonly", true);
	$("#item_qty").focus();
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
/* customer	Clear						
/* ============================ */

$("#customer_clear").click(function(){
  $("#customer_code").val("");
  $("#customer_name").text(":");
  $("#customer_desc").val("");
  $("#customer_address").text(":");
  $("#customer_phone").text(":");
  
  $("#customer_code").attr("readonly", false);
  $("#customer_code").focus();
});

/* ============================ */
/* Item	Clear Unit						
/* ============================ */

$("#item_clear").click(function(){
  $("#item_code").val("");
  $("#item_desc").val("");
  $("#item_price").val("");
  $("#item_buy").val("");
  $("#item_qty").val("");
  $("#item_unit").empty();
  $("#item_stock").empty();
  $("#item_code").attr('readonly', false);
  $("#item_code").focus();
});

/* ============================ */
/* Item	Simpan Detail						
/* ============================ */

var no = 0;

$("#item_add").click(function(){
  no++;
  let item_id		= $("#item_id").val();
  let item_code		= $("#item_code").val();
  let item_desc		= $("#item_desc").val();
  let item_price	= $("#item_price").val();
  let item_buy		= $("#item_buy").val();
  let item_qty		= $("#item_qty").val();
  let item_unit		= $("#item_unit").text();
  let item_stock	= $("#item_stock_exist").val();
  let item_total	= item_qty * item_price;
  
  if(item_code != ''){
	if(item_price == ''){
	  alert("Harga barang tidak boleh kosong !");
	} else {
	  if(item_qty == '' || item_qty == 0){
		alert("Qty tidak boleh kosong !");
	  } else if(item_qty > item_stock){
		alert("Stok tersisa hanya : " + item_stock);
	  } else {
		$("#item_detail").append("<tr id='detail" + no + "'></tr>");
		$("#detail" + no)
		  .append("<td><input type='hidden' name='detail_item_id[]' value='" + item_id + "'><input name='detail_item_code[]' class='input-readonly' value='" + item_code + "' readonly></td>")
		  .append("<td><input name='detail_item_desc[]' class='input-readonly' value='" + item_desc + "' readonly></td>")
		  .append("<td><input name='detail_item_qty[]' class='input-readonly number' value='" + item_qty + "' readonly></td>")
		  .append("<td><input name='detail_item_unit[]' class='input-readonly' value='" + item_unit + "' readonly></td>")
		  .append("<td><input name='detail_item_price[]' class='input-readonly number' value='" + item_price + "' readonly><input type='hidden' name='detail_item_buy[]' class='input-readonly number' value='" + item_buy + "'></td>")
		  .append("<td><input class='input-readonly number total' value='" + item_total + "' readonly></td>")
		  .append("<td><button id='detail" + no + "' type='button' class='btn btn-xs btn-danger' onclick='removeItem(this.id)'><i class='fa fa-trash'></i></button></td>");
		  
		  $("#item_clear").click();
		  sumTotal();
	  }
	}
  } else {
	alert("Barang tidak boleh kosong !");
  }
});

/* ============================ */
/* Item	Remove Item						
/* ============================ */

function removeItem(id){
  $("#" + id).remove();
  sumTotal();
}

/* ============================ */
/* Input via barcode					
/* ============================ */

$('#input_barcode').on('shown.bs.modal', function(){
  $("#item_not_found").empty();
  $("#item_barcode").focus();
});

$("#input_barcode_stop").focusout(function(){
  $("#item_barcode").focus();
});
  
$("#item_barcode").focusout(function(){
  $("#input_barcode_stop").focus();
});

function detectBarcode(val){
  $.getJSON("../item/getBarcode?term=" + val, function(data){
	$.each(data, function(key, value){
	  if(value.item_status == 400){
		$("#item_not_found").text("Data tidak ditemukan !");
		$("#item_barcode").val("");
		$('#item_barcode').focus();
	 } else {
	    no++;
	    let item_total = 1 * value.item_price;
	  
	    $("#item_detail").append("<tr id='detail" + no + "'></tr>");
		$("#detail" + no)
		  .append("<td><input type='hidden' name='detail_item_id[]' value='" + value.item_id + "'><input name='detail_item_code[]' class='input-readonly' value='" + value.item_code + "' readonly></td>")
		  .append("<td><input name='detail_item_desc[]' class='input-readonly' value='" + value.item_desc + "' readonly></td>")
		  .append("<td><input name='detail_item_qty[]' class='input-readonly number' value='1'></td>")
		  .append("<td><input name='detail_item_unit[]' class='input-readonly' value='" + value.item_unit + "' readonly></td>")
		  .append("<td><input name='detail_item_price[]' class='input-readonly number' value='" + value.item_price + "' readonly><input type='hidden' name='detail_item_buy[]' class='input-readonly number' value='" + value.item_buy + "'></td>")
		  .append("<td><input class='input-readonly number total' value='" + item_total + "' readonly></td>")
		  .append("<td><button id='detail" + no + "' type='button' class='btn btn-xs btn-danger' onclick='removeItem(this.id)'><i class='fa fa-trash'></i></button></td>");
		  
		$("#item_barcode").val("");
		$("#item_not_found").empty();
		sumTotal();
	  }
	});
  });
}

/* ============================ */
/* Hide modal when page change				
/* ============================ */

document.addEventListener("visibilitychange", function(){
  if(document.hidden){
    $('#input_barcode').modal("hide");
  }
});

/* ============================ */
/* Item	SUM						
/* ============================ */

function sumTotal(){
  var sum = 0;
  $(".total").each(function(){
    sum += +$(this).val();
  });
  $("#quotation_total").val(sum);
}
</script>
