$(function() {
    // tiny mce
    tinymce.init({
        selector: '.tiny-textarea',
        height: "400px",
        plugins: "image lists link paste",
        toolbar: "undo redo | styleselect | bold italic underline | anchor | alignleft aligncenter alignright alignjustify | numlist bullist | indent outdent | link",
        a11y_advanced_options: true,
        paste_as_text: true,
        language: $('html').attr('lang'),
    });

    $('.bootstrap-select').selectpicker();
});