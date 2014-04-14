// prepare the form when the DOM is ready
$(document).ready(function() {

    $('body').on('change', "#deepspaceone_ship_class", function () {
        var options = { beforeSubmit:  showRequest };
        $("form[name='deepspaceone_ship']").ajaxForm(options);
        $(this).parents("form").submit();
    });

});

// pre-submit callback
function showRequest(formData, $form, options) {
    // formData is an array; here we use $.param to convert it to a string to display it
    // but the form plugin does this for you automatically when it submits the data
    options.target = "#ajax-ship-target";

    // here we could return false to prevent the form from being submitted;
    // returning anything other than false will allow the form submit to continue
    return true;
}