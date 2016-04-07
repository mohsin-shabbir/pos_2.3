<?php $this->load->view("partial/header"); ?>
<div id="web-hooks">
<div id="page_title"><?php echo $this->lang->line('module_web_hooks'); ?></div>
<?php
echo form_open('web_hooks/save_web_hooks/',array('id'=>'config_web_hooks_form'));
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
	<div style="width:20%; float:left;">
		<div style="width:50%; float:left">
			<input type="radio" style=" display:inline" name="callout" value="1" <?php if(set_value('callout') == 1){ echo 'checked'; } ?> />
		</div><div style="float:right; width:50%;"> Yes</div>
	</div>
	<div style="width:80%; float:right; text-align:left">
		<div style="width:10%; float:left; text-align:left">
			<input type="radio" name="callout" value="0" <?php if(set_value('callout') == 0){ echo 'checked'; } ?> />
		</div><div style="float:right; width:90%; text-align:left;"> No</div>		
	</div>	
</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_url').':', 'url',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'url',
		'id'=>'url',
		'value'=>set_value('url')));
		?>
	</div>
</div>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_error_email').':', 'error_email',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'error_email',
		'id'=>'error_email',
		'value'=>set_value('error_email')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_is_secure').':', 'error_email',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<div style="width:20%; float:left;">
		<div style="width:50%; float:left">
			<input type="radio" style=" display:inline" name="is_secure" value="1" <?php if(set_value('is_secure') == 1){ echo 'checked'; } ?> />
		</div><div style="float:right; width:50%;"> Yes</div>
	</div>
	<div style="width:80%; float:right; text-align:left">
		<div style="width:10%; float:left; text-align:left">
			<input type="radio" name="is_secure" value="0" <?php if(set_value('is_secure') == 0){ echo 'checked'; } ?> />
		</div><div style="float:right; width:90%; text-align:left;"> No</div>		
	</div>	
</div>
	
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_authorization_token').':', 'authorization_token',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'authorization_token',
		'id'=>'authorization_token',
		'value'=>set_value('authorization_token')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_authorization_username').':', 'authorization_username',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'authorization_username',
		'id'=>'authorization_username',
		'value'=>set_value('authorization_username')));?>
	</div>
</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('web_hooks_authorization_password').':', 'authorization_password',array('class'=>'wide')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'authorization_password',
		'id'=>'authorization_password',
		'value'=>set_value('authorization_password')));?>
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

</div>
<?php $this->load->view("partial/footer"); ?>
