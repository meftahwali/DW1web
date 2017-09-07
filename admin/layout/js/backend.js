$(function (){
	'use strict';
	$('[placeholder]').focus(function (){
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder','');
	}).blur(function (){
		$(this).attr('placeholder', $(this).attr('data-text'));

	});
	//add astrexisk on required field
	$('input').each(function(){
		if ($(this).attr('required') === 'required'){
			 $(this).after('<span class="asterisk">*</span>');
		}
	});
	// show password
	var passField= $('.password');
	$('.show-pass').hover(function(){
   passField.attr('type','text');
	}, function(){
   passField.attr('type','password');
	});
});
