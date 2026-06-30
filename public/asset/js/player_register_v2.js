let latitude, longitude, skill;

function initializeLocation() {
  latitude = localStorage.getItem("latitude");
  longitude = localStorage.getItem("longitude");

  if (latitude && longitude) {
    latitude = parseFloat(latitude);
    longitude = parseFloat(longitude);
    console.log("Using stored coordinates:", latitude, longitude);
  } else if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function (position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        localStorage.setItem("latitude", latitude);
        localStorage.setItem("longitude", longitude);
        console.log("New coordinates obtained:", latitude, longitude);
      },
      function (error) {
        console.error("Error getting location:", error.message);
      }
    );
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
}

initializeLocation();

!(function (root, factory) {
  if (typeof define === "function" && define.amd) {
    define(["jquery"], function ($) {
      return factory(root, $);
    });
  } else if (typeof exports === "object") {
    factory(root, require("jquery"));
  } else {
    factory(root, root.jQuery || root.Zepto);
  }
})(this, function (global, $) {
  "use strict";
  var PLUGIN_NAME = "remodal";

  var NAMESPACE =
    (global.REMODAL_GLOBALS && global.REMODAL_GLOBALS.NAMESPACE) || PLUGIN_NAME;

  var ANIMATIONSTART_EVENTS = $.map(
    [
      "animationstart",
      "webkitAnimationStart",
      "MSAnimationStart",
      "oAnimationStart",
    ],

    function (eventName) {
      return eventName + "." + NAMESPACE;
    }
  ).join(" ");

  var ANIMATIONEND_EVENTS = $.map(
    ["animationend", "webkitAnimationEnd", "MSAnimationEnd", "oAnimationEnd"],

    function (eventName) {
      return eventName + "." + NAMESPACE;
    }
  ).join(" ");

  var DEFAULTS = $.extend(
    {
      hashTracking: true,
      closeOnConfirm: true,
      closeOnCancel: true,
      closeOnEscape: true,
      closeOnOutsideClick: true,
      modifier: "",
      appendTo: null,
    },
    global.REMODAL_GLOBALS && global.REMODAL_GLOBALS.DEFAULTS
  );

  var STATES = {
    CLOSING: "closing",
    CLOSED: "closed",
    OPENING: "opening",
    OPENED: "opened",
  };

  var STATE_CHANGE_REASONS = {
    CONFIRMATION: "confirmation",
    CANCELLATION: "cancellation",
  };

  var IS_ANIMATION = (function () {
    var style = document.createElement("div").style;

    return (
      style.animationName !== undefined ||
      style.WebkitAnimationName !== undefined ||
      style.MozAnimationName !== undefined ||
      style.msAnimationName !== undefined ||
      style.OAnimationName !== undefined
    );
  })();

  var IS_IOS = /iPad|iPhone|iPod/.test(navigator.platform);

  var current;

  var scrollTop;

  function getAnimationDuration($elem) {
    if (
      IS_ANIMATION &&
      $elem.css("animation-name") === "none" &&
      $elem.css("-webkit-animation-name") === "none" &&
      $elem.css("-moz-animation-name") === "none" &&
      $elem.css("-o-animation-name") === "none" &&
      $elem.css("-ms-animation-name") === "none"
    ) {
      return 0;
    }

    var duration =
      $elem.css("animation-duration") ||
      $elem.css("-webkit-animation-duration") ||
      $elem.css("-moz-animation-duration") ||
      $elem.css("-o-animation-duration") ||
      $elem.css("-ms-animation-duration") ||
      "0s";

    var delay =
      $elem.css("animation-delay") ||
      $elem.css("-webkit-animation-delay") ||
      $elem.css("-moz-animation-delay") ||
      $elem.css("-o-animation-delay") ||
      $elem.css("-ms-animation-delay") ||
      "0s";

    var iterationCount =
      $elem.css("animation-iteration-count") ||
      $elem.css("-webkit-animation-iteration-count") ||
      $elem.css("-moz-animation-iteration-count") ||
      $elem.css("-o-animation-iteration-count") ||
      $elem.css("-ms-animation-iteration-count") ||
      "1";

    var max;
    var len;
    var num;
    var i;

    duration = duration.split(", ");
    delay = delay.split(", ");
    iterationCount = iterationCount.split(", ");

    // The 'duration' size is the same as the 'delay' size
    for (
      i = 0, len = duration.length, max = Number.NEGATIVE_INFINITY;
      i < len;
      i++
    ) {
      num =
        parseFloat(duration[i]) * parseInt(iterationCount[i], 10) +
        parseFloat(delay[i]);

      if (num > max) {
        max = num;
      }
    }

    return max;
  }

  function getScrollbarWidth() {
    if ($(document).height() <= $(window).height()) {
      return 0;
    }

    var outer = document.createElement("div");
    var inner = document.createElement("div");
    var widthNoScroll;
    var widthWithScroll;

    outer.style.visibility = "hidden";
    outer.style.width = "100px";
    document.body.appendChild(outer);

    widthNoScroll = outer.offsetWidth;

    // Force scrollbars
    outer.style.overflow = "scroll";

    // Add inner div
    inner.style.width = "100%";
    outer.appendChild(inner);

    widthWithScroll = inner.offsetWidth;

    // Remove divs
    outer.parentNode.removeChild(outer);

    return widthNoScroll - widthWithScroll;
  }

  function lockScreen() {
    if (IS_IOS) {
      return;
    }

    var $html = $("html");
    var lockedClass = namespacify("is-locked");
    var paddingRight;
    var $body;

    if (!$html.hasClass(lockedClass)) {
      $body = $(document.body);

      // Zepto does not support '-=', '+=' in the `css` method
      paddingRight =
        parseInt($body.css("padding-right"), 10) + getScrollbarWidth();

      $body.css("padding-right", paddingRight + "px");
      $html.addClass(lockedClass);
    }
  }

  function unlockScreen() {
    if (IS_IOS) {
      return;
    }

    var $html = $("html");
    var lockedClass = namespacify("is-locked");
    var paddingRight;
    var $body;

    if ($html.hasClass(lockedClass)) {
      $body = $(document.body);

      paddingRight =
        parseInt($body.css("padding-right"), 10) - getScrollbarWidth();

      $body.css("padding-right", paddingRight + "px");
      $html.removeClass(lockedClass);
    }
  }

  function setState(instance, state, isSilent, reason) {
    var newState = namespacify("is", state);
    var allStates = [
      namespacify("is", STATES.CLOSING),
      namespacify("is", STATES.OPENING),
      namespacify("is", STATES.CLOSED),
      namespacify("is", STATES.OPENED),
    ].join(" ");

    instance.$bg.removeClass(allStates).addClass(newState);

    instance.$overlay.removeClass(allStates).addClass(newState);

    instance.$wrapper.removeClass(allStates).addClass(newState);

    instance.$modal.removeClass(allStates).addClass(newState);

    instance.state = state;
    !isSilent &&
      instance.$modal.trigger(
        {
          type: state,
          reason: reason,
        },
        [
          {
            reason: reason,
          },
        ]
      );
  }

  function syncWithAnimation(doBeforeAnimation, doAfterAnimation, instance) {
    var runningAnimationsCount = 0;

    var handleAnimationStart = function (e) {
      if (e.target !== this) {
        return;
      }

      runningAnimationsCount++;
    };

    var handleAnimationEnd = function (e) {
      if (e.target !== this) {
        return;
      }

      if (--runningAnimationsCount === 0) {
        // Remove event listeners
        $.each(
          ["$bg", "$overlay", "$wrapper", "$modal"],
          function (index, elemName) {
            instance[elemName].off(
              ANIMATIONSTART_EVENTS + " " + ANIMATIONEND_EVENTS
            );
          }
        );

        doAfterAnimation();
      }
    };

    $.each(
      ["$bg", "$overlay", "$wrapper", "$modal"],
      function (index, elemName) {
        instance[elemName]
          .on(ANIMATIONSTART_EVENTS, handleAnimationStart)
          .on(ANIMATIONEND_EVENTS, handleAnimationEnd);
      }
    );

    doBeforeAnimation();

    if (
      getAnimationDuration(instance.$bg) === 0 &&
      getAnimationDuration(instance.$overlay) === 0 &&
      getAnimationDuration(instance.$wrapper) === 0 &&
      getAnimationDuration(instance.$modal) === 0
    ) {
      $.each(
        ["$bg", "$overlay", "$wrapper", "$modal"],
        function (index, elemName) {
          instance[elemName].off(
            ANIMATIONSTART_EVENTS + " " + ANIMATIONEND_EVENTS
          );
        }
      );

      doAfterAnimation();
    }
  }

  function halt(instance) {
    if (instance.state === STATES.CLOSED) {
      return;
    }

    $.each(
      ["$bg", "$overlay", "$wrapper", "$modal"],
      function (index, elemName) {
        instance[elemName].off(
          ANIMATIONSTART_EVENTS + " " + ANIMATIONEND_EVENTS
        );
      }
    );

    instance.$bg.removeClass(instance.settings.modifier);
    instance.$overlay.removeClass(instance.settings.modifier).hide();
    instance.$wrapper.hide();
    unlockScreen();
    setState(instance, STATES.CLOSED, true);
  }

  function parseOptions(str) {
    var obj = {};
    var arr;
    var len;
    var val;
    var i;

    // Remove spaces before and after delimiters
    str = str.replace(/\s*:\s*/g, ":").replace(/\s*,\s*/g, ",");

    // Parse a string
    arr = str.split(",");
    for (i = 0, len = arr.length; i < len; i++) {
      arr[i] = arr[i].split(":");
      val = arr[i][1];

      // Convert a string value if it is like a boolean
      if (typeof val === "string" || val instanceof String) {
        val = val === "true" || (val === "false" ? false : val);
      }

      // Convert a string value if it is like a number
      if (typeof val === "string" || val instanceof String) {
        val = !isNaN(val) ? +val : val;
      }

      obj[arr[i][0]] = val;
    }

    return obj;
  }

  function namespacify() {
    var result = NAMESPACE;

    for (var i = 0; i < arguments.length; ++i) {
      result += "-" + arguments[i];
    }

    return result;
  }

  function handleHashChangeEvent() {
    var id = location.hash.replace("#", "");
    var instance;
    var $elem;

    if (!id) {
      // Check if we have currently opened modal and animation was completed
      if (
        current &&
        current.state === STATES.OPENED &&
        current.settings.hashTracking
      ) {
        current.close();
      }
    } else {
      // Catch syntax error if your hash is bad
      try {
        $elem = $("[data-" + PLUGIN_NAME + '-id="' + id + '"]');
      } catch (err) {}

      if ($elem && $elem.length) {
        instance = $[PLUGIN_NAME].lookup[$elem.data(PLUGIN_NAME)];

        if (instance && instance.settings.hashTracking) {
          instance.open();
        }
      }
    }
  }

  function Remodal($modal, options) {
    var $body = $(document.body);
    var $appendTo = $body;
    var remodal = this;

    remodal.settings = $.extend({}, DEFAULTS, options);
    remodal.index = $[PLUGIN_NAME].lookup.push(remodal) - 1;
    remodal.state = STATES.CLOSED;

    remodal.$overlay = $("." + namespacify("overlay"));

    if (
      remodal.settings.appendTo !== null &&
      remodal.settings.appendTo.length
    ) {
      $appendTo = $(remodal.settings.appendTo);
    }

    if (!remodal.$overlay.length) {
      remodal.$overlay = $("<div>")
        .addClass(
          namespacify("overlay") + " " + namespacify("is", STATES.CLOSED)
        )
        .hide();
      $appendTo.append(remodal.$overlay);
    }

    remodal.$bg = $("." + namespacify("bg")).addClass(
      namespacify("is", STATES.CLOSED)
    );

    remodal.$modal = $modal
      .addClass(
        NAMESPACE +
          " " +
          namespacify("is-initialized") +
          " " +
          remodal.settings.modifier +
          " " +
          namespacify("is", STATES.CLOSED)
      )
      .attr("tabindex", "-1");

    remodal.$wrapper = $("<div>")
      .addClass(
        namespacify("wrapper") +
          " " +
          remodal.settings.modifier +
          " " +
          namespacify("is", STATES.CLOSED)
      )
      .hide()
      .append(remodal.$modal);
    $appendTo.append(remodal.$wrapper);

    // Add the event listener for the close button
    remodal.$wrapper.on(
      "click." + NAMESPACE,
      "[data-" + PLUGIN_NAME + '-action="close"]',
      function (e) {
        e.preventDefault();

        remodal.close();
      }
    );

    // Add the event listener for the cancel button
    remodal.$wrapper.on(
      "click." + NAMESPACE,
      "[data-" + PLUGIN_NAME + '-action="cancel"]',
      function (e) {
        e.preventDefault();

        remodal.$modal.trigger(STATE_CHANGE_REASONS.CANCELLATION);

        if (remodal.settings.closeOnCancel) {
          remodal.close(STATE_CHANGE_REASONS.CANCELLATION);
        }
      }
    );

    // Add the event listener for the confirm button
    remodal.$wrapper.on(
      "click." + NAMESPACE,
      "[data-" + PLUGIN_NAME + '-action="confirm"]',
      function (e) {
        e.preventDefault();

        remodal.$modal.trigger(STATE_CHANGE_REASONS.CONFIRMATION);

        if (remodal.settings.closeOnConfirm) {
          remodal.close(STATE_CHANGE_REASONS.CONFIRMATION);
        }
      }
    );

    // Add the event listener for the overlay
    remodal.$wrapper.on("click." + NAMESPACE, function (e) {
      var $target = $(e.target);

      if (!$target.hasClass(namespacify("wrapper"))) {
        return;
      }

      if (remodal.settings.closeOnOutsideClick) {
        remodal.close();
      }
    });
  }

  Remodal.prototype.open = function () {
    var remodal = this;
    var id;

    // Check if the animation was completed
    if (remodal.state === STATES.OPENING || remodal.state === STATES.CLOSING) {
      return;
    }

    id = remodal.$modal.attr("data-" + PLUGIN_NAME + "-id");

    if (id && remodal.settings.hashTracking) {
      scrollTop = $(window).scrollTop();
      location.hash = id;
    }

    if (current && current !== remodal) {
      halt(current);
    }

    current = remodal;
    lockScreen();
    remodal.$bg.addClass(remodal.settings.modifier);
    remodal.$overlay.addClass(remodal.settings.modifier).show();
    remodal.$wrapper.show().scrollTop(0);
    remodal.$modal.focus();

    syncWithAnimation(
      function () {
        setState(remodal, STATES.OPENING);
      },

      function () {
        setState(remodal, STATES.OPENED);
      },

      remodal
    );
  };

  Remodal.prototype.close = function (reason) {
    var remodal = this;

    // Check if the animation was completed
    if (
      remodal.state === STATES.OPENING ||
      remodal.state === STATES.CLOSING ||
      remodal.state === STATES.CLOSED
    ) {
      return;
    }

    if (
      remodal.settings.hashTracking &&
      remodal.$modal.attr("data-" + PLUGIN_NAME + "-id") ===
        location.hash.substr(1)
    ) {
      location.hash = "";
      $(window).scrollTop(scrollTop);
    }

    syncWithAnimation(
      function () {
        setState(remodal, STATES.CLOSING, false, reason);
      },

      function () {
        remodal.$bg.removeClass(remodal.settings.modifier);
        remodal.$overlay.removeClass(remodal.settings.modifier).hide();
        remodal.$wrapper.hide();
        unlockScreen();

        setState(remodal, STATES.CLOSED, false, reason);
      },

      remodal
    );
  };

  Remodal.prototype.getState = function () {
    return this.state;
  };

  Remodal.prototype.destroy = function () {
    var lookup = $[PLUGIN_NAME].lookup;
    var instanceCount;

    halt(this);
    this.$wrapper.remove();

    delete lookup[this.index];
    instanceCount = $.grep(lookup, function (instance) {
      return !!instance;
    }).length;

    if (instanceCount === 0) {
      this.$overlay.remove();
      this.$bg.removeClass(
        namespacify("is", STATES.CLOSING) +
          " " +
          namespacify("is", STATES.OPENING) +
          " " +
          namespacify("is", STATES.CLOSED) +
          " " +
          namespacify("is", STATES.OPENED)
      );
    }
  };

  $[PLUGIN_NAME] = {
    lookup: [],
  };

  $.fn[PLUGIN_NAME] = function (opts) {
    var instance;
    var $elem;

    this.each(function (index, elem) {
      $elem = $(elem);

      if ($elem.data(PLUGIN_NAME) == null) {
        instance = new Remodal($elem, opts);
        $elem.data(PLUGIN_NAME, instance.index);

        if (
          instance.settings.hashTracking &&
          $elem.attr("data-" + PLUGIN_NAME + "-id") === location.hash.substr(1)
        ) {
          instance.open();
        }
      } else {
        instance = $[PLUGIN_NAME].lookup[$elem.data(PLUGIN_NAME)];
      }
    });

    return instance;
  };

  $(document).ready(function () {
    let locationId;
    let topImage = "";
    let imageFileId;

    $("#file-upload").on("change", function () {
      $("#player_loader").attr("src", "https://f005.backblazeb2.com/file/bmpcdn90/asset/images/loader.gif");
      $('#player_loader').show();
      let fileInput = $(this)[0];
      let file = fileInput.files[0];
  
      if (file) {
          let formData = new FormData();
          formData.append("type", "player");
          formData.append("typeId", 3);
          formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
          formData.append("file", file);
  
          $.ajax({
              url: "/api/upload-temp-photos",
              type: "POST",
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                  if (response.status==1) {
                      imageFileId = response.result.fileId;
                      let fileUrl = response.result.url;
                      $("#player_loader").attr("src", fileUrl);
                  }
              },
              error: function (xhr, status, error) {
                  console.error("Upload Failed:", xhr.responseText);
                  $('#player_loader').hide();
              }
          });
      }
  });

    var currentDate = new Date();
    var eightYearsEarlier = new Date(currentDate.setFullYear(currentDate.getFullYear() - 8));
    var formattedDate = eightYearsEarlier.toISOString().split('T')[0]; // Format the date to YYYY-MM-DD

    $("#player_dob")
        .attr("type", "text")
        .attr("placeholder", "Birth Date");

    $("#player_dob").on("focus", function() {
        this.type = 'date';
        this.value = formattedDate; // Set the default value when the input is focused
        this.showPicker();
    });

    $("#player_dob").on("blur", function() {
        if (this.value === '') {
            this.type = 'text';
            this.value = ''; // Clear the value when the input loses focus if no date was selected
        }
    });

    //------- validation code --------//
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    const phonePattern = /^[0-9]{10}$/;
    let otpInputs3 = $(".mob_otp_input5");
    let otpBox11 = $("#otp51");
    let otpBox22 = $("#otp52");
    let otpBox33 = $("#otp53");
    let otpBox44 = $("#otp54");

    const sports = [];

    $("#getOtpBtn").click(function (event) {
      event.preventDefault();
      var phoneNumber = $("#coach_phone").val();
      var userEmail = $("#coach_email").val();
      var isValid = true;

      var errorMessage = "";

      if (!$("#player_loader").is(":visible")) {
        isValid = false;
        errorMessage = "Please upload your profile image.";
    }

  if ($("#locationInput").val() === "" && locationId != 17500) {
    isValid = false;
    errorMessage = "Please select your City.";
  }

      if (!$("#terms_check").is(":checked")) {
        isValid = false;
        errorMessage = "Please agree to the terms and privacy policy.";
      }
      if (!$("input[name='is_guardian']").is(":checked")) {
        isValid = false;
        errorMessage = "Please select who are you.";
      }

      if ($("#coach_phone").val() === "") {
        isValid = false;
        errorMessage = "Please enter your phone number.";
      } else if (!phonePattern.test(phoneNumber)) {
        isValid = false;
        errorMessage = "Please enter a valid 10-digit Phone Number.";
      }

      if ($("#player_weight").val() === "") {
        isValid = false;
        errorMessage = "Please select your Weight.";
      }
      if ($("#player_dob").val() === "") {
        isValid = false;
        errorMessage = "Please select your Birth Date.";
      }
      if ($("#player_dob").val()) {
        const dob = new Date($("#player_dob").val());
        const minDate = new Date();
        minDate.setFullYear(minDate.getFullYear() - 8);

        if (dob > minDate) {
          isValid = false;
          errorMessage = "You must be at least 8 years old to register.";
        }
      }

      if ($("#coach_email").val() === "") {
        isValid = false;
        errorMessage = "Please enter your Email.";
      } else if (!emailPattern.test(userEmail)) {
        isValid = false;
        errorMessage = "Please enter a valid Email Address.";
      }



      if ($("#player-heading").val() === "") {
        isValid = false;
        errorMessage = "Please enter your Profile Heading.";
      }

      if ($("#player_feet").val() === "") {
        isValid = false;
        errorMessage = "Please select your Height.";
      }

      if ($("#coach_sport").val() === "") {
        isValid = false;
        errorMessage = "Please select your Sport.";
      }

      if ($("#coach_name").val() === "") {
        isValid = false;
        errorMessage = "Please enter your Full Name.";
      }

      if (isValid) {
        const userDetails = {
          email: $("#coach_email").val(),
          phone: $("#coach_phone").val(),
        };

        $.ajax({
          type: "POST",
          url: "https://www.bookmyplayer.com/api/check-user-exist",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            phone: userDetails.phone,
            email: userDetails.email,
          },
          dataType: "json",
          success(response) {
            if (response.status === 1) {
              $("#error-message").html("User Already Exists.").show();
            } else {
              $("#otp51").val("");
              $("#otp52").val("");
              $("#otp53").val("");
              $("#otp54").val("");
              sendOtp(userDetails.phone, "signup_otp");
            }
          },
          error(response) {
            $("#error-message").text(response).removeClass("d-none");
          },
        });
        $("#phoneNumberSpan").text("+91" + $("#coach_phone").val());
      } else {
        $("#error-message").html(errorMessage).show();
      }
    });

    $("#resend-otp-signup").click(function () {
      sendOtp($("#coach_phone").val(), "resend_signup_otp");
    });

    $(document).on("closed", ".remodal", function () {
      history.replaceState(null, null, " ");
    });

    $(document).on("opened", "[data-remodal-id=modal01]", function () {
      otpBox11.focus();
    });

    $("#coach_email").on("focusout", function () {
      if ($(this).val().length > 1) {
        checkUserDetailsExists("email", $(this).val());
      }
    });

    $("#coach_phone").on("focusout", function () {
      if ($(this).val().length > 1) {
        checkUserDetailsExists("mobile", $(this).val());
      }
    });

    getSportList();

    function sendOtp(phone, type) {
      $.ajax({
        type: "POST",
        url: "https://www.bookmyplayer.com/otp/send",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          phone: phone,
          type: type,
        },
        dataType: "json",
        success(response) {
          if (response.status === 0 && type === "signup_otp") {
            $("#error-message").html(response.message).show();
          } else if (response.status === 1 && type === "resend_signup_otp") {
            $("#time").show();
            $("#resend-otp-signup").hide();
            startCountdown();
          } else {
            startCountdown();
            var inst = $("[data-remodal-id=modal01]").remodal();
            inst.open();
          }
        },
        error(response) {
          $("#error-message").text(response).removeClass("d-none");
        },
      });
    }

    function getSportList() {
      $.ajax({
        type: "POST",
        url: "https://www.bookmyplayer.com/get-admin-sports",
        headers: {
          "X-CSRF-TOKEN": csrfToken,
        },
        data: {
          _token: csrfToken,
        },
        success: function (response) {
          response.data.map((sportsList) => {
            const capitalizedSport = sportsList.name;
            const sportId = sportsList.id;
            const sportObject = {
              sportId: sportId,
              capitalizedSport: capitalizedSport,
            };
            sports.push(sportObject);
          });
          updateSportOptions();
        },
        error: function (error) {
          console.error("Error:", error);
        },
      });
    }

    function updateSportOptions() {
      const $sportSelect = $("#coach_sport");

      // Clear existing options except the first one
      $sportSelect.find("option:not(:first)").remove();

      sports.forEach((sport) => {
        const $option = $("<option></option>")
          .val(sport.sportId)
          .text(sport.capitalizedSport);
        $sportSelect.append($option);
      });
    }

    function checkUserDetailsExists(type, value) {
      const inputField =
        type === "email" ? $("#coach_email") : $("#coach_phone");

      function validate() {
        $.ajax({
          type: "POST",
          url: "https://www.bookmyplayer.com/user-details/check",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            mobile: value,
            email: value,
            type: type,
          },
          dataType: "json",
          success(response) {
            if (response.status === 1) {
              inputField.removeClass("green-text").addClass("red-text");
            } else {
              inputField.removeClass("red-text").addClass("green-text");
            }
          },
          error(response) {
            alert(response);
          },
        });
      }

      if (type === "mobile") {
        if (value.length !== 10) {
          inputField.addClass("text-danger");
        } else {
          inputField.removeClass("text-danger");
          validate();
        }
      } else if (type === "email") {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailPattern.test(value)) {
          inputField.removeClass("text-danger");
          validate();
        } else {
          inputField.addClass("text-danger");
        }
      }
    }

    //login js

    otpInputs3.on("input", function (e) {
      let o = $(".mob_otp_input5").index(this);
      1 === e.target.value.length
        ? o < $(".mob_otp_input5").length - 1 &&
          $(".mob_otp_input5")
            .eq(o + 1)
            .focus()
        : 0 === e.target.value.length &&
          o > 0 &&
          $(".mob_otp_input5")
            .eq(o - 1)
            .focus();
    });
    otpInputs3.on("keydown", function (e) {
      let o = $(".mob_otp_input5").index(this);
      "Backspace" === e.key &&
        0 === e.target.value.length &&
        o > 0 &&
        $(".mob_otp_input5")
          .eq(o - 1)
          .focus();
    });
    otpInputs3.on("keypress", function (e) {
      $(this).val().length >= 1 && e.preventDefault();
    });
    $("#otp51, #otp52, #otp53, #otp54").on("input", function () {
      var e = !0;
      $("#otp51, #otp52, #otp53, #otp54").each(function () {
        if ("" === $(this).val()) return (e = !1), !1;
      }),
        e
          ? ($("#btn-signup3").prop("disabled", !1),
            $("#btn-signup3").removeClass("disable_btn"),
            $("#btn-signup3").addClass("signup_verify_btn"))
          : ($("#btn-signup3").prop("disabled", !0),
            $("#btn-signup3").addClass("disable_btn"),
            $("#btn-signup3").removeClass("signup_verify_btn"));
    });

    function formatName(e) {
      return e
        .split(" ")
        .map(function (e) {
          return e.charAt(0).toUpperCase() + e.slice(1).toLowerCase();
        })
        .join(" ");
    }

    let locationList = [];

    $("#locationInput").on("input", async function () {
      locationId = null;
      let inputVal = $(this).val().toLowerCase();

      if (inputVal.length === 0) {
        $("#location-name").empty();
        $(".location-list").css("display", "none");
        return;
      }

      const localities = await getMasterLocalities(inputVal, 1);
      locationList = localities.map(function (locality) {
        return {
          id: locality.id,
          postcode: locality.postcode,
          locality_name:
            locality.locality_name.charAt(0).toUpperCase() +
            locality.locality_name.slice(1),
          city:
            locality.city_id != 0
              ? `${
                  locality.city.charAt(0).toUpperCase() + locality.city.slice(1)
                }, `
              : "",
          state:
            locality.state.charAt(0).toUpperCase() + locality.state.slice(1),
          city_id: locality.city_id,
        };
      });
      updateLocationDropdown(locationList, inputVal);
    });

    function updateLocationDropdown(locations, filter) {
      $("#location-name").empty(); // Clear previous options
      $(".location-list").css("display", "block");

      let filteredLocation = locations.filter((location) => 
        location.locality_name.toLowerCase().includes(filter.toLowerCase()) || 
        location.postcode.toString().includes(filter)
      );

      if (filteredLocation.length === 0) {
        $(".location-list").css("display", "none");
      } else {
        filteredLocation.forEach(function (location) {
          $("#location-name").append(
            '<li class="dropdown-item location-item for_wrap" data-id="' +
              location.id +
              '">' +
              location.locality_name +
              ", " +
              location.city +
              (location.city_id == 1
                ? " <span style='color: green;'>" + location.city + "</span>"
                : "") +
              " " +
              location.state +"-"+location.postcode+
              " (" +
              (location.city_id == 0
                ? "<span style='color: blue;'>City</span>"
                : "<span style='color: red;'>Locality</span>") +
              ")" +
              "</li>"
          );
        });
      }
    }

    function selectFirstLocation() {
      let firstLocation = $("#location-name li:first-child");
      if (firstLocation.length) {
        firstLocation.trigger("click");
      }
    }

    $("#location-name").on("click", ".location-item", function () {
      locationId = $(this).data("id");
      let localityName = $(this).text();
      $("#locationInput").val(localityName);
      $("#loc_id_input").val(locationId);
      $("#location-name").empty();
      $(".location-list").css("display", "none");
      $("#locationInput").data("selected", true);
    });

    $(document).click(function (event) {
      if (!$(event.target).closest("#location-name, .location-list").length) {
        // selectFirstLocation();
        if (!$("#locationInput").data("selected")) {
          $("#locationInput").val("");
        }
        $(".location-list").css("display", "none");
      }
    });

    $("#locationInput").on("keydown", function (e) {
      if (e.key === "Enter" || e.key === "Tab") {
        selectFirstLocation();
        $("#locationInput").data("selected", true);
      } else {
        $("#locationInput").data("selected", false);
      }
    });
    $("#locationInput").on("click", function () {
      $(this).data("selected", false);
    });
    // master functions
    function getMasterLocalities(term, type) {
      return new Promise((resolve, reject) => {
        let data =
          type === 1
            ? {
                term: term,
              }
            : {
                loc_id: term,
              };
        $.ajax({
          url: "https://www.bookmyplayer.com/coach/get-location-master",
          type: "GET",
          async: true,
          data: data,
          success: function (response) {
            console.log(response.locations);
            if (Array.isArray(response.locations)) {
              resolve(response.locations);
            } else {
              resolve([]);
            }
          },
          error: function (xhr, status, error) {
            console.error(
              "An error occurred while fetching localities:",
              error
            );
            reject(error);
          },
        });
      });
    }
    otpBox44.on("input", function () {
      if (
        otpBox11.val() &&
        otpBox22.val() &&
        otpBox33.val() &&
        otpBox44.val()
      ) {
        let e = formatName($("#coach_name").val()),
          o = $("#coach_phone").val(),
          p = $("#player_dob").val(),
          q = $("#player_weight").val(),
          n = $("#coach_email").val().toLowerCase(),
          k = $("#player-heading").val(),
          s = otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val(),
          sportId = $("#coach_sport").val(),
          newCity = locationId ? null : $("#locationInput").val(),
          custom_postcode = $("#postcode_custom").val() ?? "",
          custom_city = $("#city_custom").val() ?? "",
          custom_state = $("#state_custom").val() ?? "",
          custom_address = $("#address_custom").val() ?? "",
          custom_address_1 = $("#address_one_custom").val() ?? "",
          heightValue = $("#player_feet").val(),
          guardian =  $("input[name='is_guardian']:checked").val();

          var customLat = $('#custom_outside_latitude').val();
          var customLng = $('#custom_outside_longitude').val();

          // alert(custom_postcode)
          // alert(custom_city)
          // alert(custom_state)
          // alert(custom_address)
          // alert(custom_address_1)

        var formData = new FormData();
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        formData.append("name", e);
        formData.append("phone", o);
        formData.append("dob", p);
        formData.append("weight", q);
        formData.append("height", heightValue);
        formData.append("email", n);
        formData.append("type_id", 3);
        formData.append("otp", s);
        formData.append("sport_id", sportId);
        formData.append("loc_id", locationId);
        formData.append("new_city", newCity);
        formData.append("is_guardian", guardian);
        if(customLat){
          formData.append("lat", customLat);
        }else{
          formData.append("lat", latitude);
        }
        if(customLng){
          formData.append("lng", customLng);
        }else{
          formData.append("lng", longitude);
        }
        formData.append("heighlight", k);
        formData.append("skill", skill);
        formData.append("cus_locality_name", custom_address);
        formData.append("cus_district", custom_city);
        formData.append("cus_state", custom_state);
        formData.append("cus_postcode", custom_postcode);
        formData.append("cus_address1", custom_address_1);
        formData.append("photos", imageFileId);



        $.ajax({
          type: "POST",
          url: "https://www.bookmyplayer.com/register/validate",
          data: formData,
          processData: false, // Important!
          contentType: false, // Important!
          success(e) {
            if (e.status == 1) {
              if (e.redirect_url != null && e.redirect_url != "") {
                window.location.href = e.redirect_url;
              } else {
                location.reload();
              }
            } else if (e.status == 0) {
              $("#errorMsg2").text(e.message);
              $("#errorMsg2").removeClass("d-none");
            }
          },
          error(e) {
            $("#errorMsg2").text(JSON.stringify(e));
            $("#errorMsg2").removeClass("d-none");
          },
        });
      }
    });

    let countdownTimer;

    function startCountdown() {
      let timeLeft = 120;
      const endTime = Date.now() + timeLeft * 1000; // Calculate the end time

      if (countdownTimer) {
        clearInterval(countdownTimer); // Clear any existing interval
      }

      countdownTimer = setInterval(function () {
        const now = Date.now();
        const timeDiff = Math.max(0, endTime - now); // Calculate remaining time in ms
        const minutes = Math.floor(timeDiff / 60000);
        const seconds = Math.floor((timeDiff % 60000) / 1000);

        if (timeDiff <= 0) {
          clearInterval(countdownTimer);
          countdownTimer = null; // Clear the interval ID
          $("#resend-otp-signup").show();
          $("#time").hide();
        } else {
          $("#time").text(`Resend OTP In ${minutes}m ${seconds}s`);
        }
      }, 1000);
    }
    // add custom address popup
    var $btn = $("#btn-add-your-city");
    var $btnSubmitAddress = $("#btn-add-custom-address");
    var $popup = $("#popup");
    var $span = $(".close").first();
    var $errorMessageDiv = $("#error-message-cus-address");

    var previousValues = {
      city: "",
      state: "",
      postalCode: "",
      address: "",
    };

    function openPopup() {
      // Set previous values if they exist
      $("#custome_city").val(previousValues.city);
      $("#custome_state").val(previousValues.state);
      $("#custome_post").val(previousValues.postalCode);
      $("#custome_address").val(previousValues.address);

      $("body").addClass("popup-active");
      $popup.css("display", "flex");
    }

    function closePopup() {
      $("body").removeClass("popup-active");
      $popup.css("display", "none");
    }

    function closePopup2() {
      $("body").removeClass("popup-active");
      $popup.css("display", "none");
      $("#locationInput").css("border", "1px solid green");
      $("#locationInput").attr("placeholder", "New City Added");
    }

    $btn.on("click", function (event) {
      event.preventDefault();
      openPopup();
    });

    if ($span.length) {
      $span.on("click", closePopup);
    }

    $(window).on("click", function (event) {
      if ($(event.target).is($popup)) {
        closePopup();
      }
    });

    $btnSubmitAddress.on("click", function (event) {
      event.preventDefault();

      var cusCity = $("#custome_city").val().trim();
      var cusState = $("#custome_state").val().trim();
      var cusPostalCode = $("#custome_post").val().trim();
      var cusAddress = $("#custome_address").val().trim();
      var cusAddress1 = $("#custome_address_1").val().trim();
      var cusLatitude = $("#custom_latitude").val().trim();
      var cusLongitude = $("#custom_longitude").val().trim();
      var errorMessage = "";

      if (!cusPostalCode) {
        errorMessage = "Please enter your postal code.";
      } else if (!cusAddress) {
        errorMessage = "Please enter your address.";
      } else if (!cusCity) {
        errorMessage = "Please enter your city.";
      } else if (!cusState) {
        errorMessage = "Please enter your state.";
      } else {
        $("#city_custom").val(cusCity);
        $("#state_custom").val(cusState);
        $("#postcode_custom").val(cusPostalCode);
        $("#address_custom").val(cusAddress);
        $("#address_one_custom").val(cusAddress1);
        $("#custom_outside_latitude").val(cusLatitude);
        $("#custom_outside_longitude").val(cusLongitude);
        $("#locationInput").val("");
        locationId = 17500;

        previousValues = {
          city: cusCity,
          state: cusState,
          postalCode: cusPostalCode,
          address: cusAddress,
        };
        closePopup2();
        return;
      }

      $errorMessageDiv.html(errorMessage).show();
      setTimeout(function () {
        $errorMessageDiv.html("").hide();
      }, 3000);
    });

    $("#file-upload").on("change", function () {
      let profileImageUrl = $(this).val();
      let profileImage = profileImageUrl.split("\\").pop(); // Note the double backslash for Windows paths
      let userName = "";
      let locId = $("#loc_id_input").val();

      $.ajax({
        url: `https://www.bookmyplayer.com/player/dashboard/update-profile`,
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          logo: profileImage,
          name: userName,
          loc_id: locId,
        },
        async: true,
        success: async function (response) {},
        error: function (xhr, status, error) {
          console.error(xhr);
        },
      });
    });


    $('#close-modal-btn').click(function(event) {
      event.preventDefault(); // Prevent default link behavior
      var modal = $('[data-remodal-id="modal01"]').remodal(); // Get the modal instance
      modal.close(); // Close the modal
  });

  const categories = {
    1: ['Football Goalkeeper', 'Football Defender', 'Midfielder', 'Football Forward', 'Other'], //football
    2: ['Guard', 'Basketball Forward', 'Center', 'Other'], //basketball
    3: ['Batsman', 'Bowler', 'Wicketkeeper', 'All Rounder', 'Other'], //Cricket
    4: ['Kumite Fighter', 'Kata Competitor', 'Special Technique', 'Other'], //karate
    5: ['Swimming Style', 'Other'], //swimming
    6: ['Single', 'Double', 'Other'], //badminton
    7: ['Tee Shot', 'Fairway', 'Approach Shot', 'Short Game', 'Putting', 'Golf-All-Rounder', 'Other'], //golf
    8: ['Rifle', 'Pistol', 'Shotgun', 'Running Target Shooter', 'Shooting-All-Rounder', 'Other'], //shooting done
    9: ['MMA Striker', 'Grappler', 'MMA-All-Rounder', 'MMA Specialist', 'MMA Defender', 'Other'], //MMA
    10: ['Raider', 'Kabaddi Defender', 'Kabaddi-All-Rounder', 'Other'], //kabaddi
   11: ['Artistic Gymnast', 'Rhythmic Gymnast', 'Trampoline Gymnast', 'Other'], //gymnastics
    12: ['Dance', 'Painting', 'Other'], //arts
    13: ['Opening Player', 'Midgame Player', 'Endgame Player', 'Chess Defensive Player', 'Aggressive Player', 'Other'], //chess
    15: ['Hockey Forward', 'Hockey Defense', 'Goal keeper', 'Specialist', 'Other'], //hockey
    16: ['Single Player', 'Double Player', 'Tennis-All-Rounder', 'Other'], //tennis
    17: ['Wrestling Style', 'Other'], //wretling*
    18: ['Weight Class', 'Fighting Style', 'Other'], //boxing
    19: ['Driver', 'Pit Crew Member', 'Engineer', 'Other'], //motorsports
    20: ['Pool Player', 'Snooker Player', 'Carom Billiards Player', 'Trick Shot Artist', 'Other'], //billiard
    21: ['Table Tennis Offensive Player', 'Table Tennis Defensive Player', 'Table Tennis All Rounder', 'Other'], //table-tennis
    22: ['Chaser', 'Defender', 'Other'], //khokho
    23: ['Offensive Player', 'Defensive Player','All-Round Squash Player','Shot Specialist', 'Positional Player', 'Other'], //squash
    24: ['Epee', 'Foil', 'Sabre', 'Fencing-All-Rounder', 'Other'], //fencing
    25: ['Figure Skating', 'Speed Skating', 'Inline Skating', 'Roller Derby', 'Other'], //skating
    26: ['Sprinter', 'Middle Distance Runner', 'Long Distance Runner', 'Hurdler', 'Jumper', 'Thrower', 'Combined Event', 'Other'], //athletics
    27: ['Setter', 'Outside Hitter','Middle Blocker', 'Libero', 'Other'], //volleyball
    28: ['Sparring', 'Form', 'Breaking', 'Other'], //teakwando*
    29: ['Recurve Archery', 'Compound Archery', 'Barebow Archery', 'Flight Archery', 'Bowhunting', 'Other'], //archery
    30: ['Forward', 'Back', 'Other'], //rugby
    31: ['Weightlifting', 'Cardio Training', 'Functional Training', 'Group Fitness', 'Other'], //gym
    32: ['Hatha Yoga', 'Vinyasa Yoga', 'Ashtanga Yoga', 'Yin Yoga', 'Restorative Yoga', 'Prenatal Yoga', 'Kids Yoga', 'Other'], // yog
    34: ['Strength Training', 'Cardiovascular Training', 'Functional-Training', 'Flexibility and Mobility Training', 'Nutrition Coaching', 'Specialized Training', 'Other'], // personal-trainer
    35: ['Silambam Weapon Technique', 'Silambam Empty Hand Technique', 'Silambam Form Demonstration', 'Other'], // silambam
    36: ['Infielder', 'Outfielder', 'Pitcher', 'Catcher', 'Other'], //baseball
    37: ['Snooker Offensive Player', 'Snooker Defensive Player', 'Snooker All-Round Player', 'Cue Ball Control', 'Break-Off Specialist', 'Other'], //snooker
    38: ['Carrom Striker', 'Queen Specialist', 'Board Control', 'Break Specialist', 'Carrom-All-Rounder', 'Other'], //carrom
    39: ['Goalkeeper', 'Backcourt Player', 'Wing Player', 'Pivot Player', 'Defense Specialist', 'Other'], //handball
    40: ['Weapon Technique', 'Empty Hand Technique', 'Healing Technique', 'Form Demonstration', 'Other'], //kalaripayayttu
  };


  const subCategories = {


    // 1.Football
    'Football Goalkeeper': ['Traditional Goalkeeper', 'Sweeper Keeper'],
    'Football Defender': ['Center Back', 'Full Back', 'Wing Back', 'Sweeper'],
    'Midfielder': ['Central Midfielder', 'Defensive Midfielder', 'Attacking Midfielder', 'Wide Midfielder'],
    'Football Forward': ['Striker', 'Winger', 'Centre Forward', 'Second Striker'],
    'Other':['Other'],

      // 2.Basketball
      'Guard': ['Point Guard', 'Shooting Guard'],
      'Basketball Forward': ['Small Forward', 'Power Forward'],
      'Center': ['Center'],
      'Other':['Other'],

        // 3.Cricket
    'Batsman': ['Opening Batsman', 'Top-Order Batsman', 'Middle-Order Batsman', 'Lower-Order Batsman'],
    'Bowler': ['Fast Bowler', 'Medium-Pace Bowler', 'Spin Bowlers'],
    'Wicketkeeper': ['Specialist Wicketkeeper', 'Batsman-Wicketkeeper'],
    'All Rounder': ['Batting All-Rounder', 'Bowling All-Rounder'],
    'Other':['Other'],

      // 4.Karate
      'Kumite Fighter': ['Offensive Fighter', 'Defensive Fighter'],
      'Kata Competitor': ['Individual Kata', 'Team Kata'],
      'Special Technique': ['Breaking Technique', 'Demonstration Techniques'],
      'Other':['Other'],

        //5. Swimming
    'Swimming Style': ['Freestyle Swimmer', 'Backstroke Swimmer', 'Breaststroke Swimmer', 'Butterfly Swimmer', 'Individual Medley Swimmer', 'Distance Swimmer', 'Sprint Swimmer', 'Relay Swimmer', 'Open Water Swimmer'],
    'Other':['Other'],

      //6. Badminton
      'Single': ['Men\'s Single', 'Women\'s Single'],
      'Double': ['Men\'s Double', 'Women\'s Double', 'Mixed Double'],
      'Other':['Other'],

        //7. Golf
    'Tee Shot': ['Driver Specialist'],
    'Fairway': ['Fairway Specialist'],
    'Approach Shot': ['Iron Specialist'],
    'Short Game': ['Wedge Specialist'],
    'Putting': ['Putter Specialist'],
    'Golf-All-Rounder': ['Versatile Player'],
    'Other':['Other'],

      //8. Shooting
      'Rifle': ['Air Rifle', 'Prone Rifle'],
      'Pistol': ['Air Pistol', 'Rapid Fire Pistol'],
      'Shotgun': ['Trap', 'Skeet'],
      'Running Target Shooter': ['Moving Target'],
      'Shooting-All-Rounder': ['Versatile Shooter'],
      'Other':['Other'],

        //9. MMA
    'MMA Striker': ['Boxer', 'Muay Thai Fighter'],
    'Grappler': ['Wrestler', 'Brazilian Jiu-Jitsu'],
    'MMA-All-Rounder': ['Mixed Martial Artist'],
    'MMA Specialist': ['Submission Specialist', 'Ground-and-Pound Fighter'],
    'MMA Defender': ['Counter Striker'],
    'Other':['Other'],

      //10. Kabbadi
      'Raider': ['Lead Raider', 'Secondary Raider'],
      'Kabaddi Defender': ['Cover Defender', 'Corner Defender'],
      'Kabaddi-All-Rounder': ['Lead All-Rounder', 'Support All-Rounder'],
      'Other':['Other'],

        //11. Gymnastics
    'Artistic Gymnast': ['Floor Specialist', 'Uneven Bars Specialist', 'Balance Beam Specialist', 'Vault Specialist'],
    'Rhythmic Gymnast': ['Hoop Specialist', 'Ball Specialist', 'Ribbon Specialist'],
    'Trampoline Gymnast': ['Trampoline Specialist'],
    'Other':['Other'],

      //12. Arts
      'Dance': ['Ballet Dancer', 'Contemporary Dancer', 'Hip-Hop Dancer'],
      'Painting': ['Abstract', 'Acrylic', 'Watercolor'],
      'Other':['Other'],

        //13. Chess
    'Opening Player': ['Opening Specialist'],
    'Midgame Player': ['Tactician', 'Strategist'],
    'Endgame Player': ['Endgame Specialist'],
    'Chess Defensive Player': ['Defender'],
    'Aggressive Player': ['Attacker'],
    'Other':['Other'],

      //15. Hockey
      'Hockey Forward': ['Left Wing', 'Right Wing', 'Center'],
      'Hockey Defense': ['Left Defense', 'Right Defense'],
      'Goal keeper': ['Goalkeeper'],
      'Specialist': ['Power Play Specialist', 'Penalty Kill Specialist'],
      'Other':['Other'],

        //16. Tennis
    'Single Player': ['Baseline Player', 'Serve-and-Volley Player', 'All-Court Player'],
    'Double Player': ['Net Player', 'Baseline Double Player'],
    'Tennis-All-Rounder': ['Versatile Doubles Player'],
    'Other':['Other'],

      //17. Wrestling
      'Wrestling Style': ['Freestyle Wrestler', 'Greco-Roman Wrestler', 'Submission Wrestler'],
      'Other':['Other'],

        //18. Boxing
    'Weight Class': ['Flyweight', 'Bantamweight', 'Featherweight', 'Lightweight', 'Welterweight', 'Middleweight', 'Heavyweight'],
    'Fighting Style': ['Out-Boxer', 'Swarmer', 'Counterpunch', 'Slugger'],
    'Other':['Other'],

      //19. Motorsports
      'Driver': ['Formula 1 Driver', 'Rally Driver', 'Endurance Driver', 'NASCAR Driver', 'MotoGP Rider'],
      'Pit Crew Member': ['Chief Mechanic','Tire Specialist', 'Fuel Specialist'],
      'Engineer': ['Race Engineer', 'Data Analyst'],
      'Other':['Other'],

        //20. Billiards
    'Pool Player': ['8-Ball Player', '9-Ball Player', 'Straight Pool Player'],
    'Snooker Player': ['Break Builder', 'Safety Player'],
    'Carom Billiards Player': ['3-Cushion Specialist', 'Artistic Billiards Player'],
    'Trick Shot Artist': ['Trick Shot Specialist'],
    'Other':['Other'],

      //21. Table tennis
      'Table Tennis Offensive Player': ['Attacker', 'Loop Driver'],
      'Table Tennis Defensive Player': ['Chopper', 'Blocker'],
      'Table Tennis All Rounder': ['All-Round Attacker', 'Counter Driver'],
      'Other':['Other'],

      //22. Kho-Kho
    'Chaser': ['Attacker', 'Pole Diver', 'Chain Chaser'],
    'Defender': ['Dodger', 'Pole Dodger', 'Chain Dodger'],
    'Other':['Other'],

    //23. Squash
    'Offensive Player':['Attacker'],
    'Defensive Player':['Retriever'],
    'All-Round Squash Player':['All-Court Player'],
    'Shot Specialist':['Drop Shot Specialist', 'Lob Specialist'],
    'Positional Player':['Front Court Player', 'Back Court Player'],
    'Other':['Other'],

      //24. Fencing
      'Epee': ['Offensive Epeeist', 'Defensive Epeeist'],
      'Foil': ['Offensive Foilist', 'Defensive Foilist'],
      'Sabre': ['Offensive Sabreur', 'Defensive Sabreur'],
      'Fencing-All-Rounder': ['Versatile Fencer'],
      'Other':['Other'],

      //25. Skating
      'Figure Skating': ['Singles Skater', 'Pairs Skater', 'Ice Dancers'],
      'Speed Skating': ['Short Track Skater', 'Long Track Skater'],
      'Inline Skating': ['Freestyle Skater', 'Speed Skater'],
      'Roller Derby': ['Jammer','Blocker'],
      'Other':['Other'],

        //26. Athletics
    'Sprinter': ['100m Sprinter', '200m Sprinter'],
    'Middle Distance Runner': ['800m Runner', '1500m Runner'],
    'Long Distance Runner': ['5000m Runner', '10000m Runner'],
    'Hurdler': ['110m Hurdle', '400m Hurdles'],
    'Jumper': ['Long Jump', 'High Jump', 'Triple Jump'],
    'Thrower': ['Shot Putter', 'Discus Thrower', 'Javelin Thrower', 'Hammer Thrower'],
    'Combined Event': ['Decathlete', 'Heptathlete'],
    'Other':['Other'],

      //27. Volleyball
      'Setter': ['Main Setter', 'Secondary Setter'],
      'Outside Hitter': ['Left-side Hitter', 'Right-side Hitter'],
      'Middle Blocker': ['Quick Middle', 'Strong Middle'],
      'Libero': ['Defensive Libero', 'Serving Libero'],
      'Other':['Other'],


      //28. Teakwando
      'Sparring': ['Offensive Fighter', 'Defensive Fighter', 'Counter Attacker'],
      'Form': ['Individual Poomsae', 'Team Poomsae'],
      'Breaking': ['Power Breaking', 'Technical Breaking'],
      'Other':['Other'],


    //29. Archery
    'Recurve Archery': ['Recurve Target Archer', 'Recurve Field Archer'],
    'Compound Archery': ['Compound Target Archer', '3D Archer'],
    'Barebow Archery': ['Barebow Target Archer', 'Barebow Field Archer'],
    'Flight Archery': ['Distance Shooter'],
    'Bowhunting': ['Bowhunter'],
    'Other':['Other'],


    //30. Rugby
    'Forward': ['Prop', 'Hooker', 'Lock', 'Flanker', 'Number 8'],
    'Back': ['Scrum-Half', 'Fly-Half', 'Center', 'Wing', 'Full-Back'],
    'Other':['Other'],


    //31. Gym
    'Weightlifting': ['Bodybuilder', 'Powerlifter', 'Olympic Weightlifter'],
    'Cardio Training': ['Runner', 'Cyclist'],
    'Functional Training': ['CrossFit Athlete', 'HIIT Trainer'],
    'Group Fitness': ['Aerobics Instructor', 'Yoga Instructor'],
    'Other':['Other'],

        //32. Yoga
        'Hatha Yoga': ['Beginner Instructor', 'Advanced Instructor'],
        'Vinyasa Yoga': ['Flow Instructor'],
        'Ashtanga Yoga': ['Primary Series Instructor', 'Advanced Series Instructor'],
        'Yin Yoga': ['Yin Instructor'],
        'Restorative Yoga': ['Restorative Instructor'],
        'Prenatal Yoga': ['Prenatal Instructor'],
        'Kids Yoga': ['Kids Instructor'],
        'Other':['Other'],

    //34. persnol trainer
    'Strength Training': ['Weightlifting Coach', 'Powerlifting Coach', 'Bodybuilding Coach'],
    'Cardiovascular Training': ['Running Coach', 'Cycling Coach'],
    'Functional-Training': ['CrossFit Coach', 'HIIT Coach'],
    'Flexibility and Mobility Training': ['Yoga Instructor', 'Pilates Instructor'],
    'Nutrition Coaching': ['Nutritionist'],
    'Specialized Training': ['Rehabilitation Trainer', 'Sports Performance Coach'],
    'Other':['Other'],

        //35. Silambam
  'Silambam Weapon Technique': ['Single Stick Fighter', 'Double Stick Fighter', 'Long Stick Fighter', 'Short Stick Fighter', 'Knife Fighter'],
    'Silambam Empty Hand Technique': ['Striker', 'Grappler'],
    'Silambam Form Demonstration': ['Performer', 'Choreographer'],
    'Other':['Other'],

    //36. Baseball
    'Infielder': ['First Baseman', 'Second Baseman', 'Shortstop', 'Third Baseman'],
    'Outfielder': ['Left Fielder', 'Center Fielder', 'Right Fielder'],
    'Pitcher': ['Starting Pitcher', 'Relief Pitcher', 'Closer'],
    'Catcher': ['Catcher'],
    'Other':['Other'],

      //37. Snooker
  'Snooker Offensive Player': ['Break Builder', 'Potting Specialist'],
  'Snooker Defensive Player': ['Safety Player', 'Snooker Specialist'],
  'Snooker All-Round Player': ['Versatile Player'],
  'Cue Ball Control': ['Positioning Expert'],
  'Break-Off Specialist': ['Break-Off Expert'],
  'Other':['Other'],


    //38. Carrom
    'Carrom Striker': ['Offensive Striker', 'Defensive Striker'],
    'Queen Specialist': ['Queen Hunter'],
    'Board Control': ['Center Control Player', 'Edge Control Player'],
    'Break Specialist': ['Break Expert'],
    'Carrom-All-Rounder': ['All-Round Player'],
    'Other':['Other'],

      //39. Handball
      'Goalkeeper': ['Primary Goalkeeper', 'Reserve Goalkeeper'],
      'Backcourt Player': ['Left Back', 'Right Back', 'Center Back'],
      'Wing Player': ['Left Wing', 'Right Wing'],
      'Pivot Player': ['Pivot'],
      'Defense Specialist': ['Defense Specialist'],
      'Other':['Other'],


    //40. Kalaripayattu
    'Weapon Technique': ['Long Stick Fighter', 'Short Stick Fighter', 'Dagger Fighter', 'Sword and Shield Fighter', 'Flexible Sword Fighter'],
    'Empty Hand Technique': ['Striker', 'Grappler'],
    'Healing Technique': ['Marma Specialist'],
    'Form Demonstration': ['Performers'],
    'Other':['Other'],
  };
  let selectedCategories = [];

  $('#coach_sport').change(function() {
    const sport = $(this).val();
    updateSubCategories(sport);
  });

  $(document).on('change', '.sub-category', function() {
    const category = $(this).val();
    updateSubSubCategories(category);
  });

  $(document).on('change', '.form-check-input', function() {
    updateSkill(); // Update the skill variable when a checkbox is clicked
  });

  function updateSubCategories(sport) {
    const subCategoryContainer = $('#subCategoryContainer');
    subCategoryContainer.empty();
    $('#subSubCategoryContainer').empty();
    selectedCategories = [];

    if (sport && categories[sport]) {
      subCategoryContainer.append(createCategorySelect());
    }
  }

  function updateSubSubCategories(category) {
    if (category && !selectedCategories.includes(category)) {
      selectedCategories.push(category);
      $('#subSubCategoryContainer').append(createSubCategoryCheckboxes(category, subCategories[category]));
      $(`.sub-category option[value="${category}"]`).remove();
    }
  }

  function createCategorySelect() {
    let select = '<div class="sub-category-container mt-3"><label for="subCategory">Select Category:(You can select more than one.)</label><br>';
    select += '<select class="sub-category form-control" name="subCategory">';
    select += '<option value="">--Select Category--</option>';
    let availableOptions = categories[$('#coach_sport').val()].filter(option => !selectedCategories.includes(option));
    availableOptions.forEach(option => {
      select += `<option value="${option}">${option}</option>`;
    });
    select += '</select></div>';
    return select;
  }

  function createSubCategoryCheckboxes(category, options = []) {
    let checkboxes = `<div class="checkbox-container mt-3" id="${category}"><label>${category}</label><br>`;
    options.forEach(option => {
      checkboxes += `<label class="mb-2" style="margin-right:25px;"><input type="checkbox" class="form-check-input" name="${category}[]" value="${option}"> ${option}</label>`;
    });
    checkboxes += '</div>';
    return checkboxes;
  }


  function updateSkill() {
    const selectedCheckboxes = $('.form-check-input:checked').map(function() {
      return $(this).val();
    }).get();

    // Filter out any unwanted values such as "on"
    const filteredCheckboxes = selectedCheckboxes.filter(value => value !== 'on');

    skill = filteredCheckboxes.join(','); // Update the skill variable with a comma-separated string
  }

  $('#custome_post').on('input', function() {
    var pincode = $(this).val();
    const resultsContainer = $("#pincode-location-results");
  if(pincode.length>1){
    $.ajax({
        url: 'bmp-search',
        method: 'POST',
        data: {
            _token:$('meta[name="csrf-token"]').attr('content'),
            search_type: 'pincode_search',
            term: pincode,
            tbl:'bmp_coach_details',
        },
        success: function(response) {
          console.log(response);
          resultsContainer.empty();
          if (response.results && response.results.length > 0) {
            $(".search-results").show();
            response.results.forEach(result => {
                let displayContent;

                const capitalizeFirstLetter = (string) => {

                    if (typeof string !== 'string') return '';
                    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
                };

                const postcode = result.postcode;
                const localityName = capitalizeFirstLetter(result.locality_name);
                const district = capitalizeFirstLetter(result.district);
                const state = capitalizeFirstLetter(result.state);
                const customLatitude = result.lat;
                const customLongitude= result.lng;

                displayContent = `
                    <div class="result-item" data-address="${localityName}" data-state="${state}" data-city="${district}" data-postcode="${result.postcode}" data-lat="${customLatitude}" data-lng="${customLongitude}">
                        <span style="color:#FF5733;" class="text-capitalized">${postcode}</span>,
                        <span style="color:#ab4855;" class="text-capitalized">${localityName}</span>-
                        <span style="color:#198244;" class="text-capitalized">${district}</span>-
                        <span style="color:#157468;" class="text-capitalized">${state}</span>
                    </div>`;

                $(".search-results").append(displayContent);
            });
        }  else {
          $(".search-results").hide();
      }
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
        }
    })
  }else {
      $(".search-results").hide();
      resultsContainer.empty(); // Clear any previous results
  }
  });

  $(document).on('click', function(event) {
    if (!$(event.target).closest('#custome_post, .search-results').length) {
      $(".search-results").hide();
    }
  });

  $(document).on('click', '.result-item', function () {
    let address= $(this).data('address');
    let city= $(this).data('city');
    let state= $(this).data('state');
    let postcode= $(this).data('postcode');
    let customLat= $(this).data('lat');
    let customLng= $(this).data('lng');

    $("#custome_city").val(city);
    $("#custome_address").val(address);
    $("#custome_state").val(state);
    $("#custome_post").val(postcode);
    $("#custom_latitude").val(customLat);
    $("#custom_longitude").val(customLng);
    $(".search-results").hide(); // Hide the results container after selection
  });


  });




});
