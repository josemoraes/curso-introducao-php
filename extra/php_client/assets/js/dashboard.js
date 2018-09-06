jQuery(function(){
	jQuery('.toast .close').on('click', function(){ jQuery(this).parent().removeClass('show'); });

	jQuery('#new-task').on('click', function(){
		var modal = jQuery('.modal[data-ref="'+jQuery(this).attr('data-ref')+'"]');
		modal.show();
	});

	jQuery('.modal .close').on('click', function(){
		jQuery(this).parent().hide();
	});
});