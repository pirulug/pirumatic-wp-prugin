/* Pirumatic - Admin JavaScript */

jQuery(document).ready(function($) {
	
	$('.wp-admin .wrap form h2:not(.pirumatic-noicon)').prepend('<span class="fa fa-pad fa-cog"></span> ');
	
	$('.pirumatic-reset-options').on('click', function(e) {
		e.preventDefault();
		$('.pirumatic-modal-dialog').dialog('destroy');
		var link = this;
		var button_names = {}
		button_names[pirumatic_settings.reset_true]  = function() { window.location = link.href; }
		button_names[pirumatic_settings.reset_false] = function() { $(this).dialog('close'); }
		$('<div class="pirumatic-modal-dialog">'+ pirumatic_settings.reset_message +'</div>').dialog({
			title: pirumatic_settings.reset_title,
			buttons: button_names,
			modal: true,
			width: 350,
			closeText: ''
		});
	});
	
});
