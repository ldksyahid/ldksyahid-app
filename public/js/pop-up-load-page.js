$(document).ready(function() {
    var id = '#dialog';

    // Get the screen height and width
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    // Set height and width to mask to fill up the whole screen
    $('#mask').css({'width': maskWidth, 'height': maskHeight});

    // Transition effect
    $('#mask').fadeIn(500);
    $('#mask').fadeTo("slow", 0.9);

    // Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();

    // Set the popup window to center
    $(id).css('top', winH / 2 - $(id).height() / 2);
    $(id).css('left', winW / 2 - $(id).width() / 2);

    // Transition effect
    $(id).fadeIn(2000);

    //if close button is clicked
    $('.window .close').click(function(e) {
        // Cancel the link behavior
        e.preventDefault();

        // Add fadeOut effect to close button
        $('.window .close img').fadeOut(250);

        $('.window .boom img').fadeOut(250);

        $('#mask').fadeOut(250);

        // Hide the dialog and mask after a delay (to allow the fadeOut effect)
        setTimeout(function() {
            $('#mask').hide();
            $('.window').hide();
        }, 250);
    });

    //if mask is clicked
    $('#mask').click(function() {
        $(this).hide();
        $('.window').hide();
    });
});
