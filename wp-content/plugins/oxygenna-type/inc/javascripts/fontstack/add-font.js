 (function($) {
    $(document).ready(function($) {
        $('#add-font').click( function() {
            if( $('input:checkbox:checked.variants').length > 0 && $('input:checkbox:checked.elements').length > 0 ) {

                var font = {
                    family: $(':input[name="family"]').val(),
                    provider: $(':input[name="provider"]').val(),
                    extracss: $('#extracss').val()
                };

                font.variants = $('input:checkbox:checked.variants').map(function () {
                    return this.value;
                }).get();

                font.elements = $('input:checkbox:checked.elements').map(function () {
                    return this.value;
                }).get();

                font.subsets = $('input:checkbox:checked.subsets').map(function () {
                    return this.value;
                }).get();

                self.parent.addFont( font );
                self.parent.tb_remove();
            }
            else {
                alert( 'You must select a variant & element to use' );
            }
            return false;
        });

        $.fn.serializeObject = function()
        {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
    });
})(jQuery);
