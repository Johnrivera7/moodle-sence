$(document).ready(function() {
    if ($('.sence_blocked').length) {
        $('.course-content').replaceWith("<h2 class='nuevo-titulo'>Contenido bloqueado debe logearse en SENCE.</h2>");
	    $('.block_navigation').replaceWith("<h2 class='nuevo-titulo'></h2>");
		
    }  
	$('.block-countdown-timer').each(function() {
        var countdown = $(this);
        var date = new Date(countdown.data('datetime'));

        countdown.countdown(date, function(event) {
            $(this).html(
                event.strftime(
                    '<p><h4>Su sesión fue iniciada correctamente.</h4>Importante: recuerde que debe cerrar su sesión en Sence, antes de finalizar el tiempo.</p>'+
                    '<p><span class="countdown-hours">%H</span><span class="countdown-separator">:</span>' +
                    '<span class="countdown-minutes">%M</span><span class="countdown-separator">:</span>' +
                    '<span class="countdown-seconds">%S</span></p><br>'
                )
            );
        }).on('finish.countdown', function(event) {
            countdown.html(countdown.data('endedtext')).attr('class', 'countdown-ended');
        	alert(countdown.data('endedtext'));
        });
    });
});
