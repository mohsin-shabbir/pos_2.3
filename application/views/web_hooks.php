<?php $this->load->view("partial/header"); ?>
<div id="web-hooks">
<div id="page_title"><?php echo $this->lang->line('module_web_hooks'); ?></div>
<?php
echo form_open('config/save_web_hooks/',array('id'=>'config_web_hooks_form'));
?>
<div id="config_wrapper">
<fieldset id="config_info">
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<legend><?php echo $this->lang->line("web_hooks_info"); ?></legend>
<div style="color:#FF0000; text-align:center"><?php echo validation_errors(); ?></div>
<div style="color:#006600; font-weight:bold; text-align:center"><?php if(isset($msg)  && $msg != ''){ echo $msg;}  ?></div>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_callout').':', 'callout',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'callout',
		'id'=>'callout',
		'value'=>$this->config->item('callout')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_url').':', 'url',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'url',
		'id'=>'url',
		'value'=>$this->config->item('url')));?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_error_email').':', 'error_email',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'error_email',
		'id'=>'error_email',
		'value'=>$this->config->item('error_email')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_is_secure').':', 'error_email',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'is_secure',
		'id'=>'is_secure',
		'value'=>$this->config->item('is_secure')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_authorization_token').':', 'authorization_token',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'authorization_token',
		'id'=>'authorization_token',
		'value'=>$this->config->item('authorization_token')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_authorization_username').':', 'authorization_username',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'authorization_username',
		'id'=>'authorization_username',
		'value'=>$this->config->item('authorization_username')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_authorization_password').':', 'authorization_password',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'authorization_password',
		'id'=>'authorization_password',
		'value'=>$this->config->item('authorization_password')));?>
	</div>
</div>
<?php 
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('common_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset>
</div>
<?php
echo form_close();
?>
<div id="feedback_bar"></div>
<script type='text/javascript'>

//validation and submit handling
$(document).ready(function()
{
	$('#config_form').validate({
		submitHandler:function(form)
		{
			$(form).ajaxSubmit({
			success:function(response)
			{
				if(response.success)
				{
					set_feedback(response.message,'success_message',false);		
				}
				else
				{
					set_feedback(response.message,'error_message',true);		
				}
			},
			dataType:'json'
		});

		},
		errorLabelContainer: "#error_message_box",
 		wrapper: "li",
		rules: 
		{
			company: "required",
			address: "required",
    		phone: "required",
    		default_tax_rate:
    		{
    			required:true,
    			number:true
    		},
    		email:"email",
    		return_policy: "required",
    		stock_location:"required"
    	 		
   		},
		messages: 
		{
     		company: "<?php echo $this->lang->line('config_company_required'); ?>",
     		address: "<?php echo $this->lang->line('config_address_required'); ?>",
     		phone: "<?php echo $this->lang->line('config_phone_required'); ?>",
     		default_tax_rate:
    		{
    			required:"<?php echo $this->lang->line('config_default_tax_rate_required'); ?>",
    			number:"<?php echo $this->lang->line('config_default_tax_rate_number'); ?>"
    		},
     		email: "<?php echo $this->lang->line('common_email_invalid_format'); ?>",
     		return_policy:"<?php echo $this->lang->line('config_return_policy_required'); ?>",
     		stock_location:"<?php echo $this->lang->line('config_stock_location_required'); ?>"         
	
		}
	});
});
</script>
</div>
<?php $this->load->view("partial/footer"); ?>
