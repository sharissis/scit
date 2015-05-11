(function($) {

    $(document).ready(function($) {
        $.getJSON( fontListData.ajaxurl,{
            action: 'fontstack_list'
        })
        .done(function( data ) {
            fontstack = data;
            buildFontstack();
        })
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ', ' + error;
        });

        $('#add-font-to-stack').click( function() {
            var selected = $('#fontstack-select').find(':selected');
            var provider = selected.closest('optgroup').attr('id');
            tb_show('', 'admin-ajax.php?family=' + selected.val() + '&provider=' + provider + '&action=fontstack_add_page&amp;TB_iframe=true&width=600&height=550' );
            return false;
        });

        window.addFont = function( newFont ) {
            fontstack.push( newFont );
            buildFontstack();
        };
    });
})(jQuery);
