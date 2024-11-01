/**
 * Un-Line-Break
 */

jQuery( document ).ready( function( $ ) {

	$('input.select-all').on('click',function(){
		$(this).closest('.unlinebreak-group').find('input.shortcode').prop('checked',true);
	});

	$('input.deselect-all').on('click',function(){
		$(this).closest('.unlinebreak-group').find('input.shortcode').prop('checked',false);
	});

});
