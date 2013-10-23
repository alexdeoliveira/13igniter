$(document).ready(function(){
	$('a.delete').live('click', function(){
		var url = $(this).attr('data-url');
		$('#deleteModal .modal-footer a.delete-url').attr('href', url);
	});

	$('input[type=submit], a.btn.loading').live('click', function(){
		$(this).button('loading');
	});

	//Efeito fadeout para as mensagens de sucesso e falha
	$('.message-alert').delay(5000).fadeOut('slow');
});
