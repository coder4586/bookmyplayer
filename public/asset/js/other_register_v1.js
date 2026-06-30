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
        [{ reason: reason }]
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

  function namespacify() {
    var result = NAMESPACE;

    for (var i = 0; i < arguments.length; ++i) {
      result += "-" + arguments[i];
    }

    return result;
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
    //------- validation code --------//
    const csrfToken = $('meta[name="csrf-token"]').attr("content");
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    const phonePattern = /^[0-9]{10}$/;
    let otpInputs3 = $(".mob_otp_input7");
    let otpBox11 = $("#otp71");
    let otpBox22 = $("#otp72");
    let otpBox33 = $("#otp73");
    let otpBox44 = $("#otp74");

    const sports = [];

    $("#getOtpBtn").click(function (event) {
      event.preventDefault();
      var phoneNumber = $("#coach_phone").val();
      var userEmail = $("#coach_email").val();
      var isValid = true;

      var errorMessage = "";

      if (!$("#terms_check").is(":checked")) {
        isValid = false;
        errorMessage = "Please agree to the terms and privacy policy.";
      }
      if ($("#coach_phone").val() === "") {
        isValid = false;
        errorMessage = "Please enter your Phone Number.";
      } else if (!phonePattern.test(phoneNumber)) {
        isValid = false;
        errorMessage = "Please enter a valid 10-digit Phone Number.";
      }
      if ($("#coach_email").val() === "") {
        isValid = false;
        errorMessage = "Please enter your Email.";
      } else if (!emailPattern.test(userEmail)) {
        isValid = false;
        errorMessage = "Please enter a valid Email Address.";
      }
      if ($("#coach_description").val() === "") {
        isValid = false;
        errorMessage = "Please enter your Description.";
      }
      if ($("#locationInput").val() === "") {
        isValid = false;
        errorMessage = "Please select your City.";
      }

      if ($("#other_service").val() === "") {
        isValid = false;
        errorMessage = "Please select your Service.";
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
      location.reload(); // This line will refresh the page
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
            $("#error-message").text(response.message).removeClass("d-none");
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
      const sportSelect = document.getElementById("coach_sport");


      if (sportSelect) {
      while (sportSelect.options.length > 1) {
        sportSelect.remove(1);
      }

      sports.forEach((sport) => {
        const option = document.createElement("option");
        option.value = sport.sportId;
        option.text = sport.capitalizedSport;
        sportSelect.appendChild(option);
      });
    }


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
      let o = $(".mob_otp_input7").index(this);
      1 === e.target.value.length
        ? o < $(".mob_otp_input7").length - 1 &&
          $(".mob_otp_input7")
            .eq(o + 1)
            .focus()
        : 0 === e.target.value.length &&
          o > 0 &&
          $(".mob_otp_input7")
            .eq(o - 1)
            .focus();
    });
    otpInputs3.on("keydown", function (e) {
      let o = $(".mob_otp_input7").index(this);
      "Backspace" === e.key &&
        0 === e.target.value.length &&
        o > 0 &&
        $(".mob_otp_input7")
          .eq(o - 1)
          .focus();
    });
    otpInputs3.on("keypress", function (e) {
      $(this).val().length >= 1 && e.preventDefault();
    });
    $("#otp71, #otp72, #otp73, #otp74").on("input", function () {
      var e = !0;
      $("#otp71, #otp72, #otp73, #otp74").each(function () {
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
      locationId=null;
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
          locality_name: locality.locality_name,
          city: locality.city,
          state: locality.state,
          city_id: locality.city_id,
        };
      });
      updateLocationDropdown(locationList, inputVal);
    });
  
    function updateLocationDropdown(locations, filter) {
      $("#location-name").empty(); // Clear previous options
      $(".location-list").css("display", "block");
  
      let filteredLocation = locations.filter((location) =>
        location.locality_name.toLowerCase().includes(filter)
      );
  
      if (filteredLocation.length === 0) {
        $(".location-list").css("display", "none");
      } else {
        filteredLocation.forEach(function (location) {
          $("#location-name").append(
            '<li class="dropdown-item location-item" data-id="' +
              location.id +
              '">' +
              location.locality_name +
              "," +
              (location.city_id == 1
                ? " <span style='color: green;'>" + location.city + "</span>"
                : "") +
              " " +
              location.state +
              " (" +
              (location.city_id == 0
                ? "<span style='color: blue;'>city</span>"
                : "<span style='color: red;'>locality</span>") +
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
      $("#location-name").empty();
      $(".location-list").css("display", "none");
    });
  
    $(document).click(function (event) {
      if (!$(event.target).closest("#location-name, .location-list").length) {
        selectFirstLocation();
        $(".location-list").css("display", "none");
      }
    });
  
    $("#locationInput").on("keydown", function (e) {
      if (e.key === "Enter" || e.key === "Tab") {
        selectFirstLocation();
      }
    });
  
    // master functions
    function getMasterLocalities(term, type) {
      return new Promise((resolve, reject) => {
        let data = type === 1 ? { term: term } : { loc_id: term };
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
            console.error("An error occurred while fetching localities:", error);
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
          n = $("#coach_email").val().toLowerCase(),
          m = $("#coach_description").val().toLowerCase(),
          s = otpBox11.val() + otpBox22.val() + otpBox33.val() + otpBox44.val(),
          newType = $("#coach_sport").val(),
          sportId= 2,
          newCity = locationId ? null : $("#locationInput").val();


        // Proceed with AJAX request
        $.ajax({
          type: "POST",
          url: "https://www.bookmyplayer.com/register/validate",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            name: e,
            phone: o,
            email: n,
            type_id: 4,
            sport_id: sportId,
            otp: s,
            type: newType,
            description: m,
            loc_id: locationId,
            new_city:newCity
          },
          success(e) {
            if (e.status == 1) {
              location.reload();
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

    function startCountdown() {
      let timeLeft = 300;
      const countdownTimer = setInterval(function () {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        if (timeLeft <= 0) {
          clearInterval(countdownTimer);
          $("#resend-otp-signup").show();
          $("#time").hide();
        } else {
          $("#time").text(`Resend OTP In ${minutes}m ${seconds}s`);
          timeLeft--;
        }
      }, 1000);
    }
  });


});
