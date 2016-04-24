<?php $this->load->view("partial/header"); ?>
<div id="web-hooks">
<div id="page_title"><?php echo $this->lang->line('module_web_hooks'); ?></div>
<?php
echo form_open('web_hooks/create_keys/',array('id'=>'config_web_hooks_sender' , 'name'=>'config_web_hooks_sender'));
?>
<div id="config_wrapper">
<fieldset id="config_info">
<div id="required_fields_message"><?php ///echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<legend><?php echo $this->lang->line("web_hooks_modules_info"); ?></legend>
<div style="color:#006600; font-weight:bold; text-align:center"><?php if(isset($msg6)  && $msg6 != ''){ echo $msg6;}  ?></div>
<div style="color:#FF0000; font-weight:bold; text-align:center"><?php if(isset($msg7)  && $msg7 != ''){ echo $msg7;}  ?></div>
<?php 
echo anchor("web_hooks/show_keys" , $this->lang->line('view_main_web_hooks_keys'),array('class'=>'submit_button float_left','title'=>''));
echo form_submit(array(
	'name'=>'submit',
	'id'=>'submit',
	'value'=>$this->lang->line('module_web_hooks_submit'),
	'class'=>'submit_button float_right')
);
?>
</fieldset>
</div>
<?php
echo form_close();
?>

<?php
echo form_open('web_hooks/save_web_hooks/',array('id'=>'config_web_hooks_form' , 'name'=>'config_web_hooks_form'));
?>
<div id="config_wrapper">
<fieldset id="config_info">
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<legend><?php echo $this->lang->line("web_hooks_info"); ?></legend>
<div style="color:#FF0000; text-align:center"><?php //echo validation_errors(); ?></div>
<div style="color:#006600; font-weight:bold; text-align:center"><?php if(isset($msg1)  && $msg1 != ''){ echo $msg1;}  ?></div>
<div style="color:#FF0000; font-weight:bold; text-align:center"><?php if(isset($msg2)  && $msg2 != ''){ echo $msg2;}  ?></div>
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

echo anchor("web_hooks/show_main_configuration" , $this->lang->line('view_main_web_hooks'),array('class'=>'submit_button float_left','title'=>''));

?>

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

<?php
echo form_open('web_hooks/save_module_web_hooks/',array('id'=>'config_modules_web_hooks_form' , 'name'=>'config_modules_web_hooks_form'));
?>
<div id="config_wrapper">
<fieldset id="config_info">
<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<ul id="error_message_box"></ul>
<legend><?php echo $this->lang->line("web_hooks_module_info"); ?></legend>
<div style="color:#FF0000; text-align:center"><?php //echo validation_errors(); ?></div>

<div style="color:#006600; font-weight:bold; text-align:center"><?php if(isset($msg4)  && $msg4 != ''){ echo $msg4;}  ?></div>
<div style="color:#FF0000; font-weight:bold; text-align:center"><?php if(isset($msg3)  && $msg3 != ''){ echo $msg3;}  ?></div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('module_name').':', 'module_name',array('class'=>'wide required')); ?>
<div class='form_field'>
<select name="module_name" id="module_name" class="wide" style="width:100%; height:30px">
<?php 
$selectModules = mysql_query("SELECT * FROM ospos_modules");
while($row = mysql_fetch_array($selectModules))
{
	?>
	<option value="<?php echo $row['module_id']; ?>"><?php echo $row['module_id']; ?></option>
	<?php	
}
?>
</select>
</div>

</div>

<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('callout_event').':', 'callout_event',array('class'=>'wide required')); ?>
<div class='form_field'>
<select name="callout_event" id="callout_event" class="wide" style="width:100%; height:30px">
<option value="create">create</option>
<option value="update">update</option>
<option value="delete">delete</option>
</select>
</div>

</div>
<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('module_web_hooks_url').':', 'module_web_hooks_url',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<?php echo form_input(array(
		'name'=>'module_web_hooks_url',
		'id'=>'module_web_hooks_url',
		'value'=>set_value('module_web_hooks_url')));
		?>
	</div>
</div>


<div class="field_row clearfix">	
<?php echo form_label($this->lang->line('module_web_hooks_is_secure').':', 'error_email',array('class'=>'wide required')); ?>
	<div class='form_field'>
	<div style="width:20%; float:left;">
		<div style="width:50%; float:left">
			<input type="radio" style=" display:inline" name="module_is_secure" value="1" <?php if(set_value('module_is_secure') == 1){ echo 'checked'; } ?> />
		</div><div style="float:right; width:50%;"> Yes</div>
	</div>
	<div style="width:80%; float:right; text-align:left">
		<div style="width:10%; float:left; text-align:left">
			<input type="radio" name="module_is_secure" value="0" <?php if(set_value('module_is_secure') == 0){ echo 'checked'; } ?> />
		</div><div style="float:right; width:90%; text-align:left;"> No</div>		
	</div>	
</div>
	
</div>
<?php 
echo anchor("web_hooks/show_module_configuration" , $this->lang->line('view_module_web_hooks'),array('class'=>'submit_button float_left','title'=>''));
?>

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
