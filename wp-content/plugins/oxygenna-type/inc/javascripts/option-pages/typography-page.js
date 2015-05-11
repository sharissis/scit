var fontstack = [];
function buildFontstack() {
    var $tbody = jQuery('#fontstack-list').find('tbody');
    $tbody.find('tr').remove();
    _.each( fontstack, function( font ) {
        // create new row
        var $tr = jQuery('<tr></tr>');
        // add font data to row
        $tr.append( '<td>' + font.family + '</td>' );
        $tr.append( '<td>' + font.provider + '</td>' );
        $tr.append( '<td>' + font.variants + '</td>' );
        $tr.append( '<td>' + font.elements + '</td>' );
        $tr.append( '<td>' + font.subsets + '</td>' );
        // var $edit = jQuery('<button/>', {
        //     text: 'Edit',
        //     click: function () {
        //         return false;
        //     }
        // });
        var $remove = jQuery('<button/>', {
            text: 'Remove',
            click: function () {
                fontstack = _.without( fontstack, font );
                buildFontstack();
                return false;
            }
        });
        $tr.append( jQuery( '<td></td>' ).append( $remove ) );
        $tbody.append( $tr );
    });
}
(function($) {
    function addMessage( type, message, duration ) {
        // create message
        var messageHTML = $( '<div id="setting-error-settings_updated" class="' + type + ' settings-error below-h2"><p><strong>' + message + '</strong></p></div>' );
        messageHTML.hide();
        // add message to the page and fade in
        $( '#ajax-errors-here').append( messageHTML );
        messageHTML.fadeIn();

        if( duration !== undefined ) {
            setTimeout(function() {
                messageHTML.fadeOut();
            }, duration);  // will work with every browser
        }
    }

    $(document).ready(function($) {
        $('#submit').click( function() {
            var $saveButton = $(this);

            $saveButton.attr('disabled', true );

            $.post( typographyPage.ajaxurl, {
                action: 'fontstack_save',
                nonce: typographyPage.updateNonce,
                fontstack: fontstack
            })
            .success( function( data ) {
                fontstack = data.fontstack;
                $saveButton.attr('disabled', false );
                buildFontstack();
                addMessage( 'updated', 'Fontstack saved.' , 5000 );
            })
            .error( function( response ) {
                $saveButton.attr('disabled', false );
                addMessage( 'error', 'Errors saving fontsack.', 5000 );
            });

            return false;
        });
    });
})(jQuery);
