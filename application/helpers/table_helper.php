<?php
/*
Gets the html table to manage people.
*/
function get_people_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	$CI->lang->line('common_balance'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_people_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}
/*
Gets the html data rows for the people.
*/
function get_people_manage_table_data_rows($people,$controller)
{
	//print_r($people);
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_person_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></td></tr>";
	}
	
	return $table_data_rows;
}

function get_person_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	if(isset($person->balance))
	{ 
		$blnc = character_limiter($person->balance,13); 
	}
	else
	{
		$blnc = 0;
	}
	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="15%">'.character_limiter($person->last_name,13).'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->first_name,13).'</td>';
	$table_data_row.='<td width="30%">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->phone_number,13).'</td>';
	$table_data_row.='<td width="15%">'.$blnc.'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

function get_detailed_data_row($row, $controller)
{
	$table_data_row='<tr>';
	$table_data_row.='<td><a href="#" class="expand">+</a></td>';
	foreach($row as $cell)
	{
		$table_data_row.='<td>';
		$table_data_row.=$cell;
		$table_data_row.='</td>';
	}
	$table_data_row.='</tr>';
	return $table_data_row;
}

/////////log table
function get_log_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array(
	$CI->lang->line('common_log_id'),
	$CI->lang->line('common_module_id'),
	$CI->lang->line('common_module_name'),
	$CI->lang->line('common_action_time'),
	$CI->lang->line('common_employee_id'),
	$CI->lang->line('common_comment'),//
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_log_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

//////////////////////Log table 
function get_log_manage_table_data_rows($people,$controller)
{
	//print_r($people);
	$CI =& get_instance();
	$table_data_rows='';
	foreach($people->result() as $person)
	{
		$table_data_rows.= get_log_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_log_to_display')."</div></td></tr>";
	}
	
	return $table_data_rows;
}

///////////////////Log Table

function get_log_data_row($person,$controller)
{
	
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	$table_data_row='<tr>';
	///$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="10%">'.character_limiter($person->log_id,13).'</td>';
	$table_data_row.='<td width="10%">'.character_limiter($person->module_id,13).'</td>';
	$table_data_row.='<td width="25%">'.character_limiter($person->module_name,13).'</td>';
	//$table_data_row.='<td width="30%">'.date("d,m,Y" , time(character_limiter($person->action_time,13))).'</td>';
	$table_data_row.='<td width="30%">'.character_limiter($person->action_time,13).'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->first_name ,13).' '.character_limiter($person->last_name ,13).'</td>';		
	$table_data_row.='<td width="10%">'.character_limiter($person->comment,13).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

//////////////////////////////////////////////////////Get Main Configuration///////////////////////////////////////////
function get_main_web_hooks_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array(
	$CI->lang->line('common_global_id'),
	$CI->lang->line('common_callout'),
	$CI->lang->line('common_url'),
	$CI->lang->line('common_error_email'),
	$CI->lang->line('common_is_secure')
	//$CI->lang->line('common_comment'),//
	//'&nbsp'
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_main_hooks_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}
function get_main_hooks_manage_table_data_rows($people,$controller)
{
	//print_r($people);
	$CI =& get_instance();
	$table_data_rows='';
	foreach($people->result() as $person)
	{
		$table_data_rows.= get_main_web_hooks_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_log_to_display')."</div></td></tr>";
	}
	
	return $table_data_rows;
}

function get_main_web_hooks_data_row($person,$controller)
{
	
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	$table_data_row='<tr>';
	///$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="10%">'.character_limiter($person->global_id,13).'</td>';
	$table_data_row.='<td width="10%">'.character_limiter($person->callout,13).'</td>';
	$table_data_row.='<td width="40%">'.character_limiter($person->url,13).'</td>';
	//$table_data_row.='<td width="30%">'.date("d,m,Y" , time(character_limiter($person->action_time,13))).'</td>';
	$table_data_row.='<td width="30%">'.character_limiter($person->error_email,13).'</td>';
	$table_data_row.='<td width="10%">'.character_limiter($person->is_secure,13).'</td>';
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

//////////////////////////////////////////////////////Get Main Configuration///////////////////////////////////////////


//////////////////////////////////////////////////////Get module hooks Configuration///////////////////////////////////////////
function get_module_web_hooks_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array(	
	'<input type="checkbox" id="select_all" />', 
	$CI->lang->line('common_module_hook_id'),
	$CI->lang->line('common_module_name'),
	$CI->lang->line('common_callout_event'),
	$CI->lang->line('common_module_web_hooks_url'),
	$CI->lang->line('common_module_is_secure'),
	'&nbsp'
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_module_hooks_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}
function get_module_hooks_manage_table_data_rows($people,$controller)
{
	//print_r($people);
	$CI =& get_instance();
	$table_data_rows='';
	foreach($people->result() as $person)
	{
		$table_data_rows.= get_module_web_hooks_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_log_to_display')."</div></td></tr>";
	}
	
	return $table_data_rows;
}

function get_module_web_hooks_data_row($person,$controller)
{
	
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->module_hook_id' value='".$person->module_hook_id."'/></td>";
	///$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="10%">'.character_limiter($person->module_hook_id,13).'</td>';
	$table_data_row.='<td width="15%">'.character_limiter($person->module_name,13).'</td>';
	$table_data_row.='<td width="25%">'.character_limiter($person->callout_event,13).'</td>';
	//$table_data_row.='<td width="30%">'.date("d,m,Y" , time(character_limiter($person->action_time,13))).'</td>';
	$table_data_row.='<td width="33%">'.character_limiter($person->module_web_hooks_url,13).'</td>';
	$table_data_row.='<td width="7%">'.character_limiter($person->module_is_secure,13).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->module_hook_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';	
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

//////////////////////////////////////////////////////Get module hooks Configuration///////////////////////////////////////////

//////////////////////////////////////////////////////Get module hooks Keys///////////////////////////////////////////
function get_module_web_hooks_keys_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array(	
	'<input type="checkbox" id="select_all" />', 
	$CI->lang->line('common_key_id'),
	$CI->lang->line('common_hash_code')
	//,'&nbsp'
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_module_hooks_manage_keys_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}
function get_module_hooks_manage_keys_table_data_rows($people,$controller)
{
	//print_r($people);
	$CI =& get_instance();
	$table_data_rows='';
	foreach($people->result() as $person)
	{
		$table_data_rows.= get_module_web_hooks_keys_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='3'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_log_to_display')."</div></td></tr>";
	}
	
	return $table_data_rows;
}

function get_module_web_hooks_keys_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();
	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$person->key_id' value='".$person->key_id."'/></td>";
	$table_data_row.='<td width="10%">'.character_limiter($person->key_id ,13).'</td>';
	$table_data_row.='<td width="75%">'.character_limiter($person->hash_code ,13).'</td>';
	//$table_data_row.='<td width="10%">'.anchor($controller_name."/view/$person->key_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';	
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

//////////////////////////////////////////////////////Get module hooks Keys///////////////////////////////////////////

/*
Gets the html table to manage suppliers.
*/
function get_supplier_manage_table($suppliers,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />',
	$CI->lang->line('suppliers_company_name'),
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_supplier_manage_table_data_rows($suppliers,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the supplier.
*/
function get_supplier_manage_table_data_rows($suppliers,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($suppliers->result() as $supplier)
	{
		$table_data_rows.=get_supplier_data_row($supplier,$controller);
	}
	
	if($suppliers->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='7'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_supplier_data_row($supplier,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5%'><input type='checkbox' id='person_$supplier->person_id' value='".$supplier->person_id."'/></td>";
	$table_data_row.='<td width="17%">'.character_limiter($supplier->company_name,13).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->last_name,13).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->first_name,13).'</td>';
	$table_data_row.='<td width="22%">'.mailto($supplier->email,character_limiter($supplier->email,22)).'</td>';
	$table_data_row.='<td width="17%">'.character_limiter($supplier->phone_number,13).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$supplier->person_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
}

/*
Gets the html table to manage items.
*/
function get_items_manage_table($items,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('items_item_number'),
	$CI->lang->line('items_name'),
	$CI->lang->line('items_category'),
	$CI->lang->line('items_cost_price'),
	$CI->lang->line('items_unit_price'),
	$CI->lang->line('items_quantity'),
	$CI->lang->line('items_tax_percents'),
	'&nbsp;',
	$CI->lang->line('items_inventory')
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_items_manage_table_data_rows($items,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the items.
*/
function get_items_manage_table_data_rows($items,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($items->result() as $item)
	{
		$table_data_rows.=get_item_data_row($item,$controller);
	}
	
	if($items->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('items_no_items_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_item_data_row($item,$controller)
{
	$CI =& get_instance();
	$item_tax_info=$CI->Item_taxes->get_info($item->item_id);
	$tax_percents = '';
	foreach($item_tax_info as $tax_info)
	{
		$tax_percents.=$tax_info['percent']. '%, ';
	}
	$tax_percents=substr($tax_percents, 0, -2);
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

    $item_quantity='';
    
	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='item_$item->item_id' value='".$item->item_id."'/></td>";
	$table_data_row.='<td width="15%">'.$item->item_number.'</td>';
	$table_data_row.='<td width="20%">'.$item->name.'</td>';
	$table_data_row.='<td width="14%">'.$item->category.'</td>';
	$table_data_row.='<td width="14%">'.to_currency($item->cost_price).'</td>';
	$table_data_row.='<td width="14%">'.to_currency($item->unit_price).'</td>';
    $table_data_row.='<td width="14%">'.$item->quantity.'</td>';
	$table_data_row.='<td width="14%">'.$tax_percents.'</td>';	
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$item->item_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	//Ramel Inventory Tracking
	$table_data_row.='<td width="10%">'.anchor($controller_name."/inventory/$item->item_id/width:$width", $CI->lang->line('common_inv'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_count')))./*'</td>';//inventory count	
	$table_data_row.='<td width="5%">'*/'&nbsp;&nbsp;&nbsp;&nbsp;'.anchor($controller_name."/count_details/$item->item_id/width:$width", $CI->lang->line('common_det'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_details_count'))).'</td>';//inventory details	
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

/*
Gets the html table to manage giftcards.
*/
function get_giftcards_manage_table( $giftcards, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('giftcards_giftcard_number'),
	$CI->lang->line('giftcards_card_value'),
	'&nbsp', 
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_giftcards_manage_table_data_rows( $giftcards, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the giftcard.
*/
function get_giftcards_manage_table_data_rows( $giftcards, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($giftcards->result() as $giftcard)
	{
		$table_data_rows.=get_giftcard_data_row( $giftcard, $controller );
	}
	
	if($giftcards->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('giftcards_no_giftcards_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

/** GARRISON MODIFIED 4/25/2013 **/
function get_giftcard_data_row($giftcard,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='giftcard_$giftcard->giftcard_id' value='".$giftcard->giftcard_id."'/></td>";
	$table_data_row.='<td width="15%">'.$giftcard->last_name.'</td>';
	$table_data_row.='<td width="15%">'.$giftcard->first_name.'</td>';
	$table_data_row.='<td width="15%">'.$giftcard->giftcard_number.'</td>';
	$table_data_row.='<td width="20%">'.to_currency($giftcard->value).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$giftcard->giftcard_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='</tr>';
	return $table_data_row;
}
/** END GARRISON MODIFIED **/

/*
Gets the html table to manage item kits.
*/
function get_item_kits_manage_table( $item_kits, $controller )
{
	$CI =& get_instance();
	
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('item_kits_name'),
	$CI->lang->line('item_kits_description'),
	'&nbsp', 
	);
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_item_kits_manage_table_data_rows( $item_kits, $controller );
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the item kits.
*/
function get_item_kits_manage_table_data_rows( $item_kits, $controller )
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($item_kits->result() as $item_kit)
	{
		$table_data_rows.=get_item_kit_data_row( $item_kit, $controller );
	}
	
	if($item_kits->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='11'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('item_kits_no_item_kits_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_item_kit_data_row($item_kit,$controller)
{
	$CI =& get_instance();
	$controller_name=strtolower(get_class($CI));
	$width = $controller->get_form_width();

	$table_data_row='<tr>';
	$table_data_row.="<td width='3%'><input type='checkbox' id='item_kit_$item_kit->item_kit_id' value='".$item_kit->item_kit_id."'/></td>";
	$table_data_row.='<td width="15%">'.$item_kit->name.'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($item_kit->description, 25).'</td>';
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$item_kit->item_kit_id/width:$width", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	
	$table_data_row.='</tr>';
	return $table_data_row;
}

?>