function base_url() {
	var l = window.location;
	var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
	return base_url;
}

function shoutbox_mod() {
	alert("Your shoutbox post has been submitted for moderator approval. To avoid the moderation process in the future, speak to Niketa.");
};

// **********************************************************************************************************************************************************************************************************//

$(document).bind('mousemove', function(e){
    $('.server').css({
       left:  e.pageX + 30,
       top:   e.pageY + 10
    });

     $('.tooltip').css({
       left:  e.pageX - 215,
       top:   e.pageY - 30
    });
});

// **********************************************************************************************************************************************************************************************************//

var new_raiders = 1;

// **********************************************************************************************************************************************************************************************************//

$(document).ready(function(){

// **********************************************************************************************************************************************************************************************************//


	$('#home_overlay').click(function() {
		$append = '';
		if (document.location.hostname == 'portfolio') {
			$append = 'projects/slackers';
		}
		window.location.replace('/' + $append);
	});

// **********************************************************************************************************************************************************************************************************//

	$('a#bonusrolls_menu').click(function (event) {
		event.preventDefault();

		if ($(this).attr('class') != 'static_menu') {
			$('.nav_dropdown ul').removeAttr('style');
			$('.nav_dropdown a').removeAttr('style');
			$('.nav_dropdown a').removeAttr('class');
			$(this).addClass('static_menu');
			$('#nav_bonusrolls').css('display', 'block');
			$('.nav_dropdown ul').not('#nav_bonusrolls').css('display', 'none');

			$(this).css('color','#e97e1b');
			$('.nav_dropdown a').not(this).css('color','');
		} else {
			$(this).removeAttr('class');
			$(this).removeAttr('style');
			$('.nav_dropdown ul').removeAttr('style');
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('a#attendance_menu').click(function (event) {
		event.preventDefault();

		if ($(this).attr('class') != 'static_menu') {
			$('.nav_dropdown ul').removeAttr('style');
			$('.nav_dropdown a').removeAttr('style');
			$('.nav_dropdown a').removeAttr('class');
			$(this).addClass('static_menu');
			$('#nav_attendance').css('display', 'block');
			$('.nav_dropdown ul').not('#nav_attendance').css('display', 'none');

			$(this).css('color','#e97e1b');
			$('.nav_dropdown a').not(this).css('color','');
		} else {
			$(this).removeAttr('class');
			$(this).removeAttr('style');
			$('.nav_dropdown ul').removeAttr('style');
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('a#addons_menu').click(function (event) {
		event.preventDefault();

		if ($(this).attr('class') != 'static_menu') {
			$('.nav_dropdown ul').removeAttr('style');
			$('.nav_dropdown a').removeAttr('style');
			$('.nav_dropdown a').removeAttr('class');
			$(this).addClass('static_menu');
			$('#nav_addons').css('display', 'block');
			$('.nav_dropdown ul').not('#nav_addons').css('display', 'none');

			$(this).css('color','#e97e1b');
			$('.nav_dropdown a').not(this).css('color','');
		} else {
			$(this).removeAttr('class');
			$(this).removeAttr('style');
			$('.nav_dropdown ul').removeAttr('style');
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('.custom_scrollbar').mCustomScrollbar();

// **********************************************************************************************************************************************************************************************************//

	$('span.download_link a').click(function (event) {
		event.preventDefault();
		var raid = $(this).attr('id');
		var url = $(this).attr('href');
		var form = $(
			'<form action="' + url + '" method="post">' +
			'<input type="hidden" name="raid" value="' + raid + '">' +
			'<input type="submit">' +
			'</form>'
			);
		$('body').append(form);
		$(form).submit();
	});

// **********************************************************************************************************************************************************************************************************//

	$('table#bonus_rolls tbody tr:not(:first-child) td:first-child span').mouseover(function() {
		$(this).find('div').show();
		$(this).parent().parent().css('background-color', '#090E06');
	});

	$('table#bonus_rolls tbody tr:not(:first-child) td:first-child span').mouseout(function() {
		$(this).find('div').hide();
		if ($(this).parent().parent().attr('class') != 'highlighted_row') {
			$(this).parent().parent().css('background-color', '');
		}
	});

	$('table#bonus_rolls tbody tr:not(:first-child) td:first-child span').click(function() {
		if ($(this).parent().parent().attr('class') != 'highlighted_row') {
			$(this).parent().parent().css('background-color', '#090E06');
			$(this).parent().parent().addClass('highlighted_row');
		} else {
			$(this).parent().parent().css('background-color', '');
			$(this).parent().parent().removeClass('highlighted_row');
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('div.week div.section_header').click(function(event) {
		var id = this.id;
		var $target = $(event.target);
	    if(!$target.is("a") ) {
			if ($('div.week #section' + id).css('display') == 'none') {
				$('div.week #section' + id).css('display', '');
			} else {
				$('div.week #section' + id).css('display', 'none');
			}
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('div.raids div.section_header').click(function(event) {
		var id = this.id;
		var $target = $(event.target);
	    if(!$target.is("a") ) {
			if ($('div.raids #section' + id).css('display') == 'none') {
				$('div.raids #section' + id).css('display', '');
			} else {
				$('div.raids #section' + id).css('display', 'none');
			}
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('div.week div.section_header').mouseover(function() {
		$(this).css('cursor', 'pointer');
	});

// **********************************************************************************************************************************************************************************************************//

	$('span.attendees').mouseover(function() {
		$(this).find('div').show();
		$(this).css('cursor', 'pointer');
	});

// **********************************************************************************************************************************************************************************************************//

	$('span.attendees').mouseout(function() {
		$(this).find('div').hide();
		$(this).css('cursor', '');
	});

// **********************************************************************************************************************************************************************************************************//

	$('input[name="multgroups"]').mouseover(function() {
		$('label[for="multgroups"').show();
		$(this).css('cursor', 'pointer');
	});

// **********************************************************************************************************************************************************************************************************//

	$('input[name="multgroups"]').mouseout(function() {
		$('label[for="multgroups"').hide();
		$(this).css('cursor', '');
	});

// **********************************************************************************************************************************************************************************************************//

	$('#shoutbox_form').submit(function(event){
		event.preventDefault();
		var url = $(this).attr('action');

		$.ajax({
			type: 'post',
			url: url,
			data: $(this).serialize()
		}).done(function(data) {
			if (data == 'wait') {
				alert('You must wait 1 minute to post again to the shoutbox. You can avoid the wait time by verifying your character.')
			} else if (data == 'locked') {
				alert('Your account has been locked.');
				$('#shoutbox_div').remove();
				$('#shoutbox_msg').html('Your account has been locked.');
			}
		});

		$(this)[0].reset();
        $('#refresh_me').load(location.href + " #refresh_me>", "");
        $('#shoutbox_arrows').load(location.href + " #shoutbox_arrows>", "");

	});

// **********************************************************************************************************************************************************************************************************//

	$('#shoutbox_arrows').on('click', 'ul li a', function (event) {
	    event.preventDefault();
	    $.post($(this).attr('href'), function (data) {
	        $('#refresh_me').load(location.href + " #refresh_me>", "");
	        $('#shoutbox_arrows').load(location.href + " #shoutbox_arrows>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#article_container').on('click', '#delete_article a', function (event) {
		$('#article').load(location.href + "inc/lastupdate.php");
	    event.preventDefault();
	    $.post($(this).attr('href'), function (data) {
	        $('#article').load(location.href + " #article>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#article_container').on('click', '#edit_article a', function (event) {
		$('#article').load(location.href + "inc/lastupdate.php");
	    event.preventDefault();
	    var id = $(this).attr('href').substr($(this).attr('href').indexOf('?id=') + 4);
	    var new_title = prompt('', $('#article_title_' + id).html());
	    var new_post = prompt('', $('#article_post_' + id).html());

		if (new_title != '' && new_title != null && new_post != '' && new_post != null && (new_title != $('#article_title_' + id).html() || new_post != $('#article_post_' + id).html())) {
		    $.post($(this).attr('href'), {new_title: new_title, new_post: new_post}).done(function (data) {
		        $('#article').load(location.href + " #article>", "");
		    });
		} else if (new_title != null && new_post != null)  {
			alert('Your post could not be updated. Please check that neither the title nor the post is blank and that you actually submitted changes.');
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('#shoutbox_container').on('click', '.shoutbox_delete a', function (event) {
	    event.preventDefault();

	     $.post($(this).attr('href'), function (data) {
	        $('#refresh_me').load(location.href + " #refresh_me>", "");
	        $('#shoutbox_arrows').load(location.href + " #shoutbox_arrows>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#shoutbox_container').on('click', '.shoutbox_hide a', function (event) {
	    event.preventDefault();

	     $.post($(this).attr('href'), function (data) {
	        $('#refresh_me').load(location.href + " #refresh_me>", "");
	        $('#shoutbox_arrows').load(location.href + " #shoutbox_arrows>", "");
	        $('#moderation_links').load(location.href + " #moderation_links>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#shoutbox_container').on('click', '.shoutbox_edit a', function (event) {
	    event.preventDefault();
	    var id = $(this).attr('href').substr(0, $(this).attr('href').indexOf('&uid=' + $(this).attr('href').substr($(this).attr('href').indexOf('&uid=') + 5))).substr($(this).attr('href').substr(0, $(this).attr('href').indexOf('&uid=' + $(this).attr('href').substr($(this).attr('href').indexOf('&uid=') + 5))).indexOf('?id=') + 4);
	    var comment = prompt('', $('#shoutbox_comment_' + id).html());

		if (comment != '' && comment != null && comment != $('#shoutbox_comment_' + id).html()) {
		    $.post($(this).attr('href'), {comment: comment}).done(function (data) {
	        $('#refresh_me').load(location.href + " #refresh_me>", "");
	        $('#shoutbox_arrows').load(location.href + " #shoutbox_arrows>", "");
		    });
		} else if (comment != null)  {
			alert("Your post could not be edited. Make sure that your comment is not blank and that you've made changes.");
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('#pending_container').on('click', '.deny_pending a', function (event) {
	    event.preventDefault();

	     $.post($(this).attr('href'), function (data) {
	        $('#refresh_pending').load(location.href + " #refresh_pending>", "");
	        $('#moderation_links').load(location.href + " #moderation_links>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#pending_container').on('click', '.approve_pending a', function (event) {
	    event.preventDefault();

	     $.post($(this).attr('href'), function (data) {
	        $('#refresh_pending').load(location.href + " #refresh_pending>", "");
	        $('#refresh_me').load(location.href + " #refresh_me>", "");
	        $('#moderation_links').load(location.href + " #moderation_links>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#denied_container').on('click', '.approve_denied a', function (event) {
	    event.preventDefault();

	     $.post($(this).attr('href'), function (data) {
	        $('#refresh_denied').load(location.href + " #refresh_denied>", "");
	        $('#moderation_links').load(location.href + " #moderation_links>", "");
	        $('#refresh_me').load(location.href + " #refresh_me>", "");
	        $('#shoutbox_arrows').load(location.href + " #shoutbox_arrows>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#denied_container').on('click', '.delete_denied a', function (event) {
	    event.preventDefault();

	     $.post($(this).attr('href'), function (data) {
	        $('#refresh_denied').load(location.href + " #refresh_denied>", "");
	        $('#moderation_links').load(location.href + " #moderation_links>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#reindex_select').change(function() {
		$(this).parent().submit();
	})

// **********************************************************************************************************************************************************************************************************//
	$('#reindex').submit(function(event) {
		event.preventDefault;
		var c = confirm("Are you sure you want to reindex?");
		return c;
	});
// **********************************************************************************************************************************************************************************************************//

	$('#account_type_container').on('click', '#promote a', function (event) {
	    event.preventDefault();

	    $.post($(this).attr('href'), function (data) {
	        $('#refresh_account_type').load(location.href + " #refresh_account_type>", "");
	    });
	});

	// **********************************************************************************************************************************************************************************************************//

	$('#account_type_container').on('click', '#demote a', function (event) {
	    event.preventDefault();

	    $.post($(this).attr('href'), function (data) {
	        $('#refresh_account_type').load(location.href + " #refresh_account_type>", "");
	    });
	});

	// **********************************************************************************************************************************************************************************************************//

	$('#account_type_container').on('click', '#lock a', function (event) {
	    event.preventDefault();

	    $.post($(this).attr('href'), function (data) {
	        $('#refresh_account_type').load(location.href + " #refresh_account_type>", "");
	    });
	});

// **********************************************************************************************************************************************************************************************************//

	$('#update_list select#raiders_select').keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		var raider = $(this).val();
		if (keycode == '13' && raider != '') {
			var id = $(this).children(':selected').attr('id').substr($(this).children(':selected').attr('id').indexOf('raider_') + 7);

			if ($('#pending_' + id).length == 0) {
				var value = $(this).children(':selected').val().split(',');
				var info = {
					id: value[0],
					raider: value[1],
					server: value[2],
					btag: value[3],
					friends: value[4],
					exempt: value[5],
				}

				var serverplaceholder = '';
				var btagplaceholder = '';

				if (info.server == '' || info.server == null) {
					serverplaceholder = '--';
				}

				if (info.btag == '' || info.btag == null) {
					btagplaceholder = '--';
				}

		    	$('#update_pending tbody:last').append(
					'<tr id="pending_' + info.id + '"><td><input type="hidden" value="' + info.id + '" name="raiders[' + info.id + '][id]"><span class="pending_remove"><a href="remove?id=' + info.id + '">x</a></span></td>' +
					'<td><input type="hidden" value="' + info.raider + '" name="raiders[' + info.id + '][raider]"><span class="editable">' + info.raider + '</span></td>' +
					'<td><input type="hidden" value="' + info.server + '" name="raiders[' + info.id + '][server]"><span class="editable">' + info.server + serverplaceholder + '</span></td>' +
					'<td><input type="hidden" value="' + info.btag + '" name="raiders[' + info.id + '][btag]"><span class="editable">' + info.btag + btagplaceholder + '</span></td>' +
					'<td><input type="hidden" value="' + info.friends + '" name="raiders[' + info.id + '][friends]"><span class="friends">' + info.friends + '</span></td>' +
					'<td><input type="hidden" value="' + info.exempt + '" name="raiders[' + info.id + '][exempt]"><span class="exempt">' + info.exempt + '</span></td>' +
					'<td><input type="hidden" value="" name="raiders[' + info.id + '][spent]"><span class="spent" id="spent_' + info.id + '">n</span></td></tr>'
				);

			    $('#pending_counter').html(parseInt($('#pending_counter').html()) + 1);
			    $('#update_list select#raiders_select option:first-child').attr('selected', 'selected');
			}
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('#update_pending tbody').on('click', 'a', function (event) {
	    event.preventDefault();
	    var id = $(this).attr('href').substr($(this).attr('href').indexOf('remove?id=') + 10);
	    $('#update_pending tbody tr#pending_' + id).remove();
		$('#pending_counter').html(parseInt($('#pending_counter').html()) - 1);
	});

// **********************************************************************************************************************************************************************************************************//

	$('#update_pending tfoot').on('click', 'a', function (event) {
	    event.preventDefault();
	   	var raider = prompt('Raider', '');
	   	var server = prompt('Server', '');
	   	var btag = prompt('Btag', '');
	   	var friends = confirm('Friends');
	   	var exempt = confirm('Exempt');

	   	if (!friends) {
	   		friends = 'n';
	   	} else {
	   		friends = 'y';
	   	}

	   	if (!exempt) {
	   		exempt = 'n';
	   	} else {
	   		exempt = 'y';
	   	}

		var serverplaceholder = '';
		var btagplaceholder = '';

		if (server == '' || server == null) {
			serverplaceholder = '--';
		}

		if (btag == '' || btag == null) {
			btagplaceholder = '--';
		}

    	$('#update_pending tbody:last').append(
			'<tr id="pending_' + new_raiders + '"><td><input type="hidden" value="' + new_raiders + '" name="new_raiders[' + new_raiders + '][id]"><span class="pending_remove"><a href="remove?id=' + new_raiders + '">x</a></span></td>' +
			'<td><input type="hidden" value="' + raider + '" name="new_raiders[' + new_raiders + '][raider]"><span class="editable">' + raider + '</span></td>' +
			'<td><input type="hidden" value="' + server + '" name="new_raiders[' + new_raiders + '][server]"><span class="editable">' + server + serverplaceholder + '</span></td>' +
			'<td><input type="hidden" value="' + btag + '" name="new_raiders[' + new_raiders + '][btag]"><span class="editable">' + btag + btagplaceholder + '</span></td>' +
			'<td><input type="hidden" value="' + friends + '" name="new_raiders[' + new_raiders + '][friends]"><span class="friends">' + friends + '</span></td>' +
			'<td><input type="hidden" value="' + exempt + '" name="new_raiders[' + new_raiders + '][exempt]"><span class="exempt">' + exempt + '</span></td>' +
			'<td><input type="hidden" value="" name="new_raiders[' + new_raiders + '][spent]"><span class="spent" id="spent_' + new_raiders + '">n</span></td></tr>'
		);

		new_raiders++;
		 $('#pending_counter').html(parseInt($('#pending_counter').html()) + 1);
	});

// **********************************************************************************************************************************************************************************************************//

	$('#update_pending tbody').click(function(event) {
		var $target = $(event.target);
	    if (!$target.is('a') && $target.attr('class') == 'editable') {
	    	var edit = prompt('', $target.html());
	    	if (edit != null) {

	    		var pattern = new RegExp($target.html(), 'g');
	    		$target.parent().html($target.parent().html().replace(pattern, edit).replace('value=""', 'value="' + edit + '"'));
	    	}
		} else if ($target.attr('class') == 'friends') {
			var answer = confirm('Friends');
			if (!answer) {
		   		answer = 'n';
		   	} else {
		   		answer = 'y';
	   		}
	   		if (answer != $target.html()) {
	   			$target.parent().html($target.parent().html().replace('value="' + $target.html(), 'value="' + answer).replace($target.html() + '</span>', answer + '</span>'));
	   		}
		} else if ($target.attr('class') == 'exempt') {
			var answer = confirm('Exempt');
			if (!answer) {
		   		answer = 'n';
		   	} else {
		   		answer = 'y';
	   		}

	   		if (answer != $target.html()) {
	   			$target.parent().html($target.parent().html().replace('value="' + $target.html(), 'value="' + answer).replace($target.html() + '</span>', answer + '</span>'));
	   		}
		} else if ($target.attr('class') == 'spent') {
		    var id = $target.attr('id').substr($target.attr('id').indexOf("spent_") + 6);

			if ($target.html() == 'y') {
				$target.parent().html('<input type="hidden" value="" name="raiders[' + id + '][spent]"><span class="spent" id="spent_' + id + '">n</span>');
			} else {
		    	var item = prompt('Spent on:', '');
		    	if (item != null && item != '') {
		    		$target.parent().html('<input type="hidden" value="' + item + '" name="raiders[' + id + '][spent]"><span class="spent" id="spent_' + id + '">y</span>');
		    	}
			}
		}
	});

// **********************************************************************************************************************************************************************************************************//

	$('#update_list').submit(function(event) {
		var date = $('input[name=date]').val();
		var raid = $('select#raid option:selected').val();
		var orid = $('input[name=orid]').val();
		if (raid == '') {
			event.preventDefault();
			alert("You haven't selected a raid.");
		} else if (date == '') {
			event.preventDefault();
			alert("You haven't selected a date.");
		} else if (orid == '') {
			event.preventDefault();
			alert("You haven't entered the OpenRaid ID.");
		} else if (parseInt($('#pending_counter').html()) == 0) {
			event.preventDefault();
			alert("You haven't added any raiders.");
		}
	});

	$('#update_list input[type="reset"]').click(function(event) {
		$('#update_pending tbody tr').each(function() {
			$(this).remove();
		});
	    $('#pending_counter').html(0);
	});

// **********************************************************************************************************************************************************************************************************//

});

