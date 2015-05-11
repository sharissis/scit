(function($) {
    $(document).ready(function($) {
        $fontFields = $('.font-option');
        console.log($fontFields);
        $fontFields.select2();
        $fontFields.fontSelector();
    });
})(jQuery);
