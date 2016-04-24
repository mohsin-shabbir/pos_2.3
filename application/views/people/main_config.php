<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search('<?php echo site_url("logs/suggest")?>','<?php echo $this->lang->line("common_confirm_search")?>');
   // enable_email('<?php //echo site_url("logs/mailto")?>');
    //enable_delete('<?php //echo $this->lang->line($controller_name."_confirm_delete")?>','<?php echo $this->lang->line($controller_name."_none_selected")?>');
}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				5: { sorter: false} 
			} 

		}); 
	}
}

function post_person_form_submit(response)
{
	if(!response.success)
	{
		set_feedback(response.message,'error_message',true);	
	}
	else
	{
		//This is an update, just update one row
		if(jQuery.inArray(response.person_id,get_visible_checkbox_ids()) != -1)
		{
			update_row(response.person_id,'<?php echo site_url("logs/get_row")?>');
			set_feedback(response.message,'success_message',false);	
			
		}
		else //refresh entire table
		{
			do_search(true,function()
			{
				//highlight new row
				hightlight_row(response.person_id);
				set_feedback(response.message,'success_message',false);		
			});
		}
	}
}

function searchResutl()
{
	var toDate = $("#toDate").val();
	var fromDate = $("#fromDate").val();

	//if(new Date(toDate) <= new Date(fromDate))
	if(toDate <= fromDate)
	{
		$.ajax({
		  method: "POST",
		  url: "http://localhost/salman/pos_2.3/index.php/logs/search_date",
		  data: { toDate: toDate, fromDate: fromDate },
            success: function(data) {
                $("#sortable_table > tbody").html("");
				 $("#sortable_table > tbody").html(data);
            },
            error: function(data) {
               alert("Sorry we can't fetch data.");
            },
		});
	}
	else
	{
		alert("To date should be less than from date");
		return false;
	}
}
</script>

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_'.$controller_name); ?></div>
</div>
<?php echo $this->pagination->create_links();?>

<div id="table_holder">
<?php echo $manage_table; ?>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>
