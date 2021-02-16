/*=========================================================================================
    File Name: page-account-settings.js
    Description: page user account settings
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function () {
    // language select
    var languageselect = $("#languageselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // music select
    var musicselect = $("#musicselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // movies select
    var moviesselect = $("#moviesselect2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });
    // birthdate date
    $('.birthdate-picker').pickadate({
        format: 'mmmm, d, yyyy'
    });
  
});
(function (window, document, $) {
    'use strict';
    // Input, Select, Textarea validations except submit button
    $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
})(window, document, jQuery);
