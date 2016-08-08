$(function()
{
	var user_id;
	var t = $('#users-table').DataTable(
	{
		processing: true,
		serverSide: true,
		ajax: appUrl + 'details',
		lengthMenu: [ 2, 5, 10, 25, 50, 75, 100 ],
		columns: [
				{ data: 'id', name: 'id' },
				{ data: 'prefix', name: 'prefix' },
				{ data: 'first_name', name: 'first_name' },					
				{ data: 'email', name: 'email' },
				{ data: 'gender', name: 'gender' },
				{ data: 'dob', name: 'dob' },
				{ data: 'action', name: 'first_name' }

		],
		columnDefs: [ { orderable: false, targets: [0,6] }],
		order: [],
	});

	$(document).on('click', '.view_details', function()
	{
		var id = $(this).attr('user_id');
		$.ajax(
		{
			url: appUrl + 'view?id=' + id,
			type: 'GET',
			dataType: 'json',

			success:function(response)
			{
				$("#profile_pic").html('<div style="text-align: center"><img src="././images/profile_pic/' + response.photo + '" alt="No image found" style="border-radius:20%;width:120px;height:120px;"></div>');
				$("#name").html(response.full_name);
				$("#employment").html(response.employment);
				$("#employer").html(response.employer);
				$("#res_add").html(response.res_add);
				$("#off_add").html(response.off_add);
				$("#comm_medium").html(response.comm_medium);
				$("#myModal").modal({backdrop: 'static', keyboard: false, show: true});
			}	
		});
	});
	$(document).on('change', '#select_tweet_num', function()
	{
		var num = $(this).val();
		get_tweets(user_id, num);
	});

	// Click event for Tweets
	$(document).on('click', '.full_name', function()
	{
		$("select").val("1");
		user_id = $(this).attr('data_userid');
		console.log(user_id);
		get_tweets(user_id);
	});

	/**
	 * To display the tweets
	 *
	 * @access public
	 *
	 * @param  integer $id
	 * @param  integer $num_tweets
	 * @return void
	 */
	function get_tweets(id, num_tweets = 1)
	{
		$('#tweet_selector').hide();
		tweets_display = '<div style="text-align: center"><img src="././images/loading.gif" style="width:80px;height:80px;"></div>';
		$('.modal-body').html(tweets_display);
		$('.modal-title').html('Loading...');

		$.ajax(
		{
			url: appUrl + 'twitter',
			data:
			{
				id : id,
				num_tweets : num_tweets
			},
			type: 'GET',
			dataType : 'JSON',
			success: function(tweet_data)
			{
				if(tweet_data.err_val == 1)
				{
					$('.modal-title').html('Oops !!!');
					$('#tweet_selector').hide();
					$('.modal-body').html(tweet_data.err_msg);
				}
				else if (tweet_data.err_val == 2)
				{
					$('.modal-title').html('Oops !!!');
					$('#tweet_selector').hide();
					$('.modal-body').html(tweet_data.err_msg);
				}
				else
				{
					$('#tweet_selector').show();
					var user = 'Tweets of ' + tweet_data.user_name;
					$('.modal-title').html(user);
					var tweet_body = '';
					tweet_body += '<div style="text-align: center"><img src="' + tweet_data.image + '" style="border-radius:20%;width:100px;height:100px;"></div>';

					for(i in tweet_data.tweet_results)
					{
						tweet_body += '<hr><p>' + tweet_data.tweet_results[i] + '</p>';
					}

					tweets_display = tweet_body;
					$('.modal-body').html(tweets_display);
				}
				$("#twitter_modal").modal({backdrop: 'static', keyboard: false, show: true});
			}

		});
	}

});