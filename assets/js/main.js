$(document).ready(function(){
	$('a.delete').on('click', function(){
		var url = $(this).attr('data-url');
		$('#deleteModal .modal-footer a.delete-url').attr('href', url);
	});

	$('input[type=submit], a.btn.loading').on('click', function(){
		$(this).button('loading');
	});

	if ($.fn.chosen) {
		$(".chzn-select").chosen();
		$(".chzn-select-deselect").chosen({allow_single_deselect:true});
	}

	//Efeito fadeout para as mensagens de sucesso e falha
	$('.message-alert').delay(5000).fadeOut('slow');
});
