jQuery(document).ready(function($) {
    var fieldSelector = 'input[type=text], input[type=search], input[type=email], input[type=tel], input[type=url], textarea';

    // Delete placeholder of the search form on focus.
    $(document).on('focusin', fieldSelector, function(){
        $(this).data('placeholder',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
        $(this).closest('fieldset').addClass('active');
    });

    // Turn on the placeholder when the field lose focus and there is no added content.
    $(document).on('focusout', fieldSelector, function(){
        if (!$(this).val()) {
            $(this).closest('fieldset').removeClass('active');
            $(this).attr('placeholder',$(this).data('placeholder'));
        }
    });
});