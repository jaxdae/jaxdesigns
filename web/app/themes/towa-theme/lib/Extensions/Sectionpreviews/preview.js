const TowaAdmin = window.TowaAdmin || {};
/* eslint-disable */

TowaAdmin.Screenshots = (function($) {
  const _ = {},
    self = {};

  _.constructor = function() {
    self.sections = vars.sections;
    self.componentsPath = vars.componentsPath;
    _.setupModal();
    _.setUpEscapeListener();
    _.addAcfHooks();
    _.setupEyes();
  };

  _.setupListeners = function() {
    $('.acf-button[data-name="add-layout"]').on("click", function() {
      // Timeout needed because list is not yet in DOM.
      setTimeout(_.setupHoverListeners, 100);
    });
    _.click_eyes();
  };

  _.setupEyes = function() {
    // add eventlistener on Ajax (prevent on toggle Bug)
    $(document).ajaxStop(function() {
      _.click_eyes();
    });
  };
  _.addAcfHooks = function() {
    // ready is triggerd when acf is ready
    acf.add_action("ready", function() {
      _.setupListeners();
    });
    // ready is triggerd when acf layout is added
    acf.add_action("append", function() {
      _.setupListeners();
    });
    // ready is triggerd when acf layout is removed
    acf.add_action("remove", function() {
      _.setupListeners();
    });
    // ready is triggerd when acf layout is moved (sorted)
    acf.add_action("sortstop", function() {
      _.setupListeners();
    });
  };

  _.setupModal = function() {
    // create Towa Screenshot div at end of #wpcontent
    const elem = document.createElement("div");
    elem.classList.add("towa-screenshots");
    elem.appendChild(document.createElement("img"));
    document.getElementById("wpcontent").appendChild(elem);
  };

  _.click_eyes = function() {
    // reset image path
    $(".towa-screenshots img").attr("src", "");

    // click event handler for eyes
    $(".towa-eye").on("click", function(e) {
      e.preventDefault();
      // fade in screenshots container
      $(".towa-screenshots").addClass("active");

      var path = _.imagePath(this);

      // set imagepath corresponding with layout name
      $(".towa-screenshots img").attr("src", path);
      return false;
    });
  };

  _.setupHoverListeners = function() {
    // reset image path
    $(".towa-screenshots img").attr("src", "");

    // hover event handler for different layouts
    $(".acf-fc-popup li a").on("hover", function() {
      // fade in screenshots container
      $(".towa-screenshots").addClass("active");

      // get imagepath corresponding with layout name
      var path = _.imagePath(this);

      // get imagepath corresponding with layout name
      $(".towa-screenshots img").attr("src", path);
    });

    // fadeout on layout click
    $(".acf-fc-popup li a").click(function() {
      $(".towa-screenshots").removeClass("active");
    });
  };

  _.setUpEscapeListener = function() {
    // set up escape listeners (click on screenshot container)
    $(".towa-screenshots").click(function() {
      $(".towa-screenshots").removeClass("active");
    });
  };

  _.imagePath = function(that) {
    var path = "";

    $.each(self.sections, function() {
      if ($(that).data("layout") === this.name) {
        path =
          self.componentsPath +
          "/" +
          this.name +
          "/" +
          this.name +
          vars.sectionImgSuffix;
      }
    });

    return path;
  };

  _.constructor();

  return self;
})(jQuery);
