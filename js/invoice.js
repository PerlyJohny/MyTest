 $(document).ready(function(){
	$(document).on('click', '#checkAll', function() {          	
		$(".itemRow").prop("checked", this.checked);
	});	
	$(document).on('click', '.itemRow', function() {  	
		if ($('.itemRow:checked').length == $('.itemRow').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});  
	var count = $(".itemRow").length;
	$(document).on('click', '#addRows', function() { 
		count++;
		var htmlRows = '';
		htmlRows += '<tr>';
		htmlRows += '<td><input class="itemRow" type="checkbox"></td>';          
		htmlRows += '<td><input type="text" name="productCode[]" id="productCode_'+count+'" class="form-control" autocomplete="off"></td>';          
		htmlRows += '<td><input type="text" name="productName[]" id="productName_'+count+'" class="form-control" autocomplete="off"></td>';	
		htmlRows += '<td><input type="number" name="quantity[]" id="quantity_'+count+'" class="form-control quantity" autocomplete="off"></td>';   		
		htmlRows += '<td><input type="number" name="price[]" id="price_'+count+'" class="form-control price" autocomplete="off"></td>';		 
		htmlRows += '<td><input type="number" name="subtotal[]" id="subtotal_'+count+'" class="form-control subtotal" autocomplete="off"></td>';		 
		htmlRows += '<td><select name="tax[]" id="tax_'+count+'" class="form-control tax" autocomplete="off">';
		htmlRows += '<option value="0">0% </option>';
		htmlRows += '<option value="1">1% </option>';
		htmlRows += '<option value="5">5% </option>';
		htmlRows += '<option value="10">10% </option></td>';		 
		htmlRows += '<td><input type="number" name="total[]" id="total_'+count+'" class="form-control total" autocomplete="off"></td>';          
		htmlRows += '</tr>';
		$('#invoiceItem').append(htmlRows);
	}); 
	$(document).on('click', '#removeRows', function(){
		$(".itemRow:checked").each(function() {
			$(this).closest('tr').remove();
		});
		$('#checkAll').prop('checked', false);
		calculateTotal();
	});		
	$(document).on('blur', "[id^=quantity_]", function(){
		calculateTotal();
	});	
	$(document).on('blur', "[id^=price_]", function(){
		calculateTotal();
	});	
	$(document).on('blur', "#disAmount", function(){		
		calculateTotal();
	});	

$(document).on('blur', "[id^=subtotal_]", function(){
		calculateTotal();
	});	
	$(document).on('change', "[id^=tax_]", function(){
		calculateTotal();
	});	
	
});	
function calculateTotal(){
	var totalAmount = 0; 
	var subtotalAmount=0;
	$("[id^='price_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("price_",'');
		var price = $('#price_'+id).val();
		var quantity  = $('#quantity_'+id).val();
		if(!quantity) {
			quantity = 1;
		}
		var subtotals = price*quantity;
		$('#subtotal_'+id).val(parseFloat(subtotals));
		subtotalAmount += subtotals;	
		var tax = $('#tax_'+id).val();
		var taxvalue = subtotals*(tax/100);
		var taxrates=subtotals+taxvalue;
		$('#total_'+id).val(parseFloat(taxrates));
		totalAmount += taxrates;	
		
	});
	$('#subTotal').val(parseFloat(subtotalAmount));	
	$('#tsubTotal').val(totalAmount);
	var amountPaid = $('#disAmount').val();
	if(amountPaid) {
		var disAmount = subtotalAmount*(amountPaid/100);
		var totalAftertax = totalAmount-disAmount;			
		$('#totalAftertax').val(totalAftertax);
	} else {		
		$('#totalAftertax').val(totalAmount);
	}
	
}
