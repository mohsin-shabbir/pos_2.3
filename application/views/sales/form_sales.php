<div id="payment_details">
			<table id="register">
			<thead>
				<tr>
					<th style="width: 50%;">Type</th>
					<th style="width: 50%;">Amount</th>
				</tr>
			</thead>
			
			<tbody id="payment_contents">
			  	<?php
			if(count($payments) > 0)
			{
				
				foreach($payments as $payment)
				{
			?>
			    <tr>	
					<td><?php echo $payment->payment_type; ?></td>
					<td style="text-align: center;"><?php echo $payment->payment_amount; ?></td>
				</tr>
			<?php
				} 
			}
			else
			{
				?>
				<tr>	
					<td colspan="2" style="text-align: center; font-weight:bold; color:#FF0000">Sorry! No record Found</td>
				</tr>
				<?php
			} ?>
				<tr>
					<td colspan="2">
						<hr />
					</td>
				</tr>
				 <tr>	
					<td><b>Balance</b></th>
					<td style="text-align: center;"><?php if(isset($balance)){ echo to_currency($balance); } ?></td>
				</tr>
				
				<tr>
					<th colspan="2" style="width: 100%;">Receive Payment</th>
				</tr>
				
			</tbody>
		</table>
		
<div>
			<?php 
			echo form_open("sales/addReceivedAmount/".$sale_id,array('id'=>'add_received_payment_form')); ?>
			<table width="100%">
				<tbody>				 
					<tr>
						<td><span id="amountLabel">Amount Received</span></td>  
					    <td><?php echo form_input( array( 'name'=>'amount_received', 'id'=>'amount_received',  'size'=>'20','tabindex'=>4 ) ); ?>
						<input type="hidden" name="current_url" id="current_url" value="" />
					</tr>
					<tr>	
						<td></td>
						<td id="amountError" style="font-weight:bold; color:#FF0000"></td>
				   </tr>
			   </tbody>
			 </table>
			 <div class='small_button' id='add_payment_button' style='float: left; margin-top: 5px;' onclick="addReceivedAmount()">
					<span><?php echo $this->lang->line('sales_add_payment'); ?></span>
				</div>

				</form>
		</div>

	</div>
	
	<script type="text/javascript">
	function addReceivedAmount()
	{
		//alert();
		var text = '';
		var amount =  $("#amount_received").val();
		if (isNaN(amount) || amount == '' || amount <0)
		 {
        	text = "Please enter valid input";
			document.getElementById("amountError").innerHTML = text;
    	 }
		 else
		 {
		 	var currentLocation = window.location;
			$("#current_url").val(currentLocation);
		 	document.getElementById("amountError").innerHTML = '';
        	$("#add_received_payment_form").submit();	
			/*$("#add_received_payment_form").submit(function()
			{
    			alert("Submitted");
			});	
			*/				  
    	 }
	}
	</script>
