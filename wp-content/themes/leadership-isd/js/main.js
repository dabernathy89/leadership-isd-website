jQuery(document).ready(function($) {

    $('[data-bg]').each(function(index, el) {
        var bg = $(this).attr('data-bg');
        if (bg) {
            $(this).css({
                "background-image": "url('" + bg + "')",
                "background-position": "center center",
                "background-size": "cover"
            });
        }
    });

    if ($('#be-event-calendar').length) {
        $('#be-event-calendar').fullCalendar('option', 'height', 'auto');
    }

});