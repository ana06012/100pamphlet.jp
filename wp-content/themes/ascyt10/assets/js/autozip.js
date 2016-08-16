jQuery(document).ready(function($){
	$("#zip").keyup(function(){
		var zip = $(this).parents('tr').next().find('input').attr('name'); AjaxZip3.zip2addr(this, '', 'address1', 'address1');
	});
});