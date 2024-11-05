(function () {

  "use strict";


  // Feature test to rule out some older browsers
  if ("querySelector" in document && "addEventListener" in window) {
 
    // forEach method, that passes back the stuff we need
    var forEach = function (array, callback, scope) {
      for (var i = 0; i < array.length; i++) {
        callback.call(scope, i, array[i]);
      }
    };

    // Attach FastClick to remove the 300ms tap delay
    //FastClick.attach(document.body);

    // Init smooth scrolling
    // smoothScroll.init();

    // Init Responsive Nav
    var navigation = responsiveNav(".nav-collapse", {
      // Close the navigation when it's tapped
      closeOnNavClick: true
    });

    // Create a Mask
    // var mask = document.createElement("div");
    // mask.className = "mask";

    // Append the mask inside <body>
    // document.body.appendChild(mask);

    // Disable mask transitions on Android to boost performance
    // if (navigator.userAgent.match(/Android/i) !== null) {
    //   document.documentElement.className += " android";
    // }

    // Find navigation links and save a reference to them
  //   var nav = document.querySelector(".nav-collapse ul"),
  //     links = nav.querySelectorAll("a");

   }
})();
