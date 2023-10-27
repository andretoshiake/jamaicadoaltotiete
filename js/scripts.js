/**
 * File scripts.js
 *
 * Theme scripts.
 */

( function( $ ) {
    $('[data-toggle="popover"]').popover();

    $('body').on('click', '.btn-ajax', function() {
        var match_id = $(this).data('match');
        $('#modal-info .modal-body .spinner-border').show();
        $('#modal-info .modal-body .container').remove();
        $.ajax({
            url: jat_ajax_object.ajaxurl,
            type: 'post',
            data: {
                match_id: match_id,
                action: 'load_match_info_ajax_callback',
                nonce: jat_ajax_object.nonce,
            },
            success: function(response) {
                $('#modal-info .modal-body .spinner-border').hide();
                $('#modal-info .modal-body').append($.parseHTML(response));
            },
            error: function(error){ console.log(error) }
        });
    });

    $('#select-context').on('change', function() {
        var val = $(this).val();

        if ( val == '-' ) {
            $('.camp, .oficial').show();
        }

        if ( val == 'camp' ) {
            $('.camp').show();
            $('.oficial').hide();
        }

        if ( val == 'oficial' ) {
            $('.camp').hide();
            $('.oficial').show();
        }
    });
}( jQuery ) );

function openStats(evt, statsName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].classList.remove("active");
    }
    document.getElementById(statsName).style.display = "block";
    document.getElementById("tab-"+statsName).classList.add("active");
}