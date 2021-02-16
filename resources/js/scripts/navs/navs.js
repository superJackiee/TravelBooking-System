/*=========================================================================================
    File Name: nav.js
    Description: Navigation available in Bootstrap share general markup and styles, from the base .nav class to the active and disabled states. Swap modifier classes to switch between each style.
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function (window, document, $) {
  'use strict';
  // for active tab arrow
  $('.nav-tabs .nav-item').click(function () {
    $(this).addClass('current').siblings().removeClass('current');
  });
  // add current class to parent of active class
  if ($('.nav-tabs .nav-item' ).length > 0) {
    $('.nav-tabs .nav-item').find('.active').parent().addClass("current");
  }
  // add class pill-cotainer with pill componet for styling
  if($('.nav.nav-pills').length > 0){
   $('.nav-pills').addClass('pill-container');
  }
  
})(window, document, jQuery);
