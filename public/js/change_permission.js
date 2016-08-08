$(document).ready(function()
{
	$('.permission-check').on('change', function()
	{
		check_action(this);
	});
});

function check_action(obj)
{
	var id;
	var is_checked;

	if($(obj).prop("checked") == true)
	{
		is_checked = 1;
	}
	else
	{		
		is_checked = 0;
	}

	id = $(obj).attr('id');

	$.ajax(
	{
		url: appUrl + 'change_permission',
		data:
		{
			id: id,
			is_checked: is_checked
		},
		type: 'GET',
		success: function(access_details)
		{
		}
	});
}