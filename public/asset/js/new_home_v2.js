$(document).ready(function () {
    // JavaScript Document
    let menuBtn = document.querySelector(".menu-btn");
    let menu = document.querySelector(".nav");
    let menuItem = document.querySelectorAll(".nav-link");
    let selectedSport;
    let selectedCoachSport;
    let selectedAcademySport;
    let locationId;
    let locationCoachId;
    let locationAcademyId;
  
    // menuBtn.addEventListener('click', function () {
    //     menuBtn.classList.toggle('active');
    //     menu.classList.toggle('active');
    // })
  
    // menuItem.forEach(function (menuItem) {
    //     menuItem.addEventListener('click', function () {
    //         menuBtn.classList.toggle('active');
    //         menu.classList.toggle('active');
    //     })
    // })
  
    $(".tab-content ul li a").click(function () {
      $(".tab-content ul li a").removeClass();
      $(this).addClass("select");
      var index = $(".tab-content ul li a").index($(this));
      $(".tab-details > div").hide();
      $(".tab-details > div")
        .filter(":eq(" + index + ")")
        .show();
    });
  
    //search js
  
    //basic search
  
    $("#searchAcademy").on("input", function () {
      const searchTerm = $(this).val();
      const resultsContainer = $("#results");
  
      if (searchTerm.length > 3) {
        $.ajax({
          url: "/bmp-search",
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            search_type: "basic",
            tbl: "bmp_academy_details",
            term: searchTerm,
          },
          success: function (response) {
            resultsContainer.empty();
  
            // Clear previous results
            resultsContainer.empty();
  
            if (response.results && response.results.length > 0) {
              console.log(response);
              $(".search-results-academy").show();
  
              response.results.forEach((result) => {
                let displayText;
  
                if (result.city_id != 0) {
                  displayText = `
                    <span style="color: #FF5733;">${result.name}</span> - 
                    <span style="color: #198244;">${result.sport_name}</span> - 
                    <span style="color: #157468;">${result.locality_name}</span> - 
                    <span style="color: #354785;">${result.city}</span>
                `;
                } else if (result.city_id == 0) {
                  displayText = `
                    <span style="color: #FF5733;">${result.name}</span> - 
                    <span style="color: #198244;">${result.sport_name}</span> - 
                    <span style="color:#354785;">${result.city}</span> - 
                    <span style="color: #157468;">${result.state}</span>
                `;
                } else {
                  displayText = `
                    <span style="color: #FF5733;">${result.name}</span>
                `;
                }
  
                // Append the formatted result
                resultsContainer.append(
                  `<a href="${result.url}">${displayText}</a>`
                );
              });
            } else {
              resultsContainer.html("<p>No results found</p>");
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX request failed:", status, error);
          },
        });
      } else {
        $(".search-results-academy").hide(); // Hide the results container if input length is 2 or less
        resultsContainer.empty(); // Clear any previous results
      }
    });
  
    $("#searchCoach").on("input", function () {
      const searchTerm = $(this).val();
      const resultsContainer = $("#coach-results");
  
      if (searchTerm.length > 1) {
        $.ajax({
          url: "/bmp-search",
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            search_type: "basic",
            tbl: "bmp_coach_details",
            term: searchTerm,
          },
          success: function (response) {
            console.log(response);
            resultsContainer.empty();
  
            if (response.results && response.results.length > 0) {
              $(".search-results-coach").show();
  
              response.results.forEach((result) => {
                let displayText;
  
                if (result.city_id != 0) {
                  displayText = `
                                        <span style="color: #FF5733;">${result.name}</span> - 
                                        <span style="color: #198244;">${result.sport_name}</span> - 
                                        <span style="color: #157468;">${result.locality_name}</span> - 
                                        <span style="color: #354785;">${result.city}</span>
                                    `;
                } else if (result.city_id == 0) {
                  displayText = `
                                        <span style="color: #FF5733;">${result.name}</span> - 
                                        <span style="color: #198244;">${result.sport_name}</span> - 
                                        <span style="color:#354785;">${result.city}</span> - 
                                        <span style="color: #157468;">${result.state}</span>
                                    `;
                } else {
                  displayText = `
                                        <span style="color: #FF5733;">${result.name}</span>
                                    `;
                }
  
                resultsContainer.append(
                  `<a href="${result.url}">${displayText}</a>`
                );
              });
            } else {
              resultsContainer.html("<p>No results found</p>");
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX request failed:", status, error);
          },
        });
      } else {
        $(".search-results-coach").hide(); // Hide the results container if input length is 2 or less
        resultsContainer.empty(); // Clear any previous results
      }
    });
  
    $("#searchPlayer").on("input", function () {
      const searchTerm = $(this).val();
      const resultsContainer = $("#player-results");
  
      if (searchTerm.length > 1) {
        $.ajax({
          url: "/bmp-search",
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            search_type: "basic",
            tbl: "bmp_player_details",
            term: searchTerm,
          },
          success: function (response) {
            resultsContainer.empty();
  
            if (response.results && response.results.length > 0) {
              $(".search-results-players").show();
  
              response.results.forEach((result) => {
                let displayText;
  
                if (result.city_id != 0) {
                  displayText = `
                                        <span style="color: #FF5733;">${result.name}</span> - 
                                        <span style="color: #198244;">${result.sport_name}</span> - 
                                        <span style="color: #157468;">${result.locality_name}</span> - 
                                        <span style="color: #354785;">${result.city}</span>
                                    `;
                } else if (result.city_id == 0) {
                  displayText = `
                                        <span style="color: #FF5733;">${result.name}</span> - 
                                        <span style="color: #198244;">${result.sport_name}</span> - 
                                        <span style="color:#354785;">${result.city}</span> - 
                                        <span style="color: #157468;">${result.state}</span>
                                    `;
                } else {
                  displayText = `
                                        <span style="color: #FF5733;">${result.name}</span>
                                    `;
                }
  
                // Append the formatted result
                resultsContainer.append(
                  `<a href="${result.url}">${displayText}</a>`
                );
              });
            } else {
              resultsContainer.html("<p>No results found</p>");
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX request failed:", status, error);
          },
        });
      } else {
        $(".search-results-players").hide();
        resultsContainer.empty(); // Clear any previous results
      }
    });
    //basic search ends
  
    //player sport and location search
    $("#searchPlayerSport").on("change", function () {
      selectedSport = $(this).val();
    });
  
    $("#searchPlayerLocation").on("click", function () {
      $("#searchPlayerLocation").val("");
    });
  
    $("#searchPlayerLocation").on("input", function () {
      const searchTerm = $(this).val();
      const resultsContainer = $("#player-location-results");
  
      if (selectedSport) {
        $.ajax({
          url: "/bmp-search",
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            search_type: "pre_location_search",
            sport_id: selectedSport,
            tbl: "bmp_player_details",
            term: searchTerm,
          },
          success: function (response) {
            console.log(response);
            resultsContainer.empty();
  
            if (response.results && response.results.length > 0) {
              console.log(response);
              $(".search-results").show();
              resultsContainer.empty(); // Clear previous results if any
  
              response.results.forEach((result) => {
                let displayContent;
  
                if (result.city_id === 0) {
                  // Display city and state
                  displayContent = `<div class="result-item" data-loc-id="${result.loc_id}" data-city="${result.city}">
                                      <span style="font-weight:700">City:</span>  <span style="color:#FF5733;">${result.city}</span>, <span style="color:#157468;">${result.state}</span>
                                    </div>`;
                } else {
                  // Display locality_name and city in different colors
                  displayContent = `<div class="result-item" data-loc-id="${result.loc_id}" data-locality="${result.locality_name}">
                                     <span style="font-weight:700">Locality:</span>   <span style="color:#FF5733">${result.locality_name}</span>, <span style="#157468">${result.city}</span>
                                    </div>`;
                }
  
                resultsContainer.append(displayContent);
              });
            } else {
              resultsContainer.html("<p>No results found</p>");
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX request failed:", status, error);
          },
        });
      } else {
        $(".search-results").hide(); // Hide the results container if input length is 2 or less
        resultsContainer.empty(); // Clear any previous results
      }
    });
  
    $(document).on("click", ".result-item", function () {
      let resultName;
      if ($(this).data("city")) {
        resultName = $(this).data("city");
      } else if ($(this).data("locality")) {
        resultName = $(this).data("locality");
      }
  
      locationId = $(this).data("loc-id");
      $("#searchPlayerLocation").val(resultName);
      $(".search-results").hide(); // Hide the results container after selection
    });
  
    $("#playerSearchButton").on("click", function () {
      $.ajax({
        url: "/bmp-search",
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          search_type: "advanced_search",
          tbl: "bmp_player_details",
          sport_id: selectedSport,
          loc_id: locationId,
        },
        success: function (response) {
          window.open(response.results.url, "_self");;
        },
        error: function (xhr, status, error) {
          console.error("AJAX request failed:", status, error);
        },
      });
    });
  
    //player sport and location ends
  
    //coach sport and location search
  
    $("#searchCoachSport").on("change", function () {
      selectedCoachSport = $(this).val();
    });
  
    $("#searchCoachLocation").on("click", function () {
      $("#searchCoachLocation").val("");
    });
  
    $("#searchCoachLocation").on("input", function () {
      const searchTerm = $(this).val();
      const resultsContainer = $("#coach-location-results");
  
      if (selectedCoachSport) {
        $.ajax({
          url: "/bmp-search",
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            search_type: "pre_location_search",
            sport_id: selectedCoachSport,
            tbl: "bmp_coach_details",
            term: searchTerm,
          },
          success: function (response) {
            resultsContainer.empty();
  
            if (response.results && response.results.length > 0) {
              $(".search-results").show();
              resultsContainer.empty(); // Clear previous results if any
  
              response.results.forEach((result) => {
                let displayContent;
  
                if (result.city_id === 0) {
                  // Display city and state
                  displayContent = `<div class="result-coach-item" data-loc-coach-id="${result.loc_id}" data-city="${result.city}">
                                    <span style="font-weight:700">City:</span> <span style="color:#FF5733;">${result.city}</span>, <span style="color:#157468;">${result.state}</span>
                                </div>`;
                } else {
                  // Display locality_name and city in different colors
                  displayContent = `<div class="result-coach-item" data-loc-coach-id="${result.loc_id}" data-locality="${result.locality_name}">
                                    <span style="font-weight:700">Locality:</span> <span style="color:#FF5733;">${result.locality_name}</span>, <span style="color:#157468;">${result.city}</span>
                                </div>`;
                }
  
                resultsContainer.append(displayContent);
              });
            } else {
              resultsContainer.html("<p>No results found</p>");
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX request failed:", status, error);
          },
        });
      } else {
        $(".search-results").hide(); // Hide the results container if input length is 2 or less
        resultsContainer.empty(); // Clear any previous results
      }
    });
  
    $(document).on("click", ".result-coach-item", function () {
      let resultName;
      if ($(this).data("city")) {
        resultName = $(this).data("city");
      } else if ($(this).data("locality")) {
        resultName = $(this).data("locality");
      }
  
      locationCoachId = $(this).data("loc-coach-id");
      $("#searchCoachLocation").val(resultName);
      $(".search-results").hide(); // Hide the results container after selection
    });
  
    $("#coachSearchButton").on("click", function () {
      $.ajax({
        url: "/bmp-search",
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          search_type: "advanced_search",
          tbl: "bmp_coach_details",
          sport_id: selectedCoachSport,
          loc_id: locationCoachId,
        },
        success: function (response) {
          window.open(response.results.url, "_self");;
        },
        error: function (xhr, status, error) {
          console.error("AJAX request failed:", status, error);
        },
      });
    });
  
    //coach sport and location searchends
  
    //academy sport and location search
  
    $("#searchAcademySport").on("change", function () {
      selectedAcademySport = $(this).val();
    });
  
    $("#searchAcademyLocation").on("click", function () {
      $("#searchAcademyLocation").val("");
    });
  
    $("#searchAcademyLocation").on("input", function () {
      const searchTerm = $(this).val();
      const resultsContainer = $("#academy-location-results");
  
      if (selectedAcademySport) {
        $.ajax({
          url: "/bmp-search",
          method: "POST",
          data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            search_type: "pre_location_search",
            sport_id: selectedAcademySport,
            tbl: "bmp_academy_details",
            term: searchTerm,
          },
          success: function (response) {
            resultsContainer.empty();
  
            if (response.results && response.results.length > 0) {
              $(".search-results").show();
              resultsContainer.empty(); // Clear previous results if any
  
              response.results.forEach((result) => {
                let displayContent;
  
                if (result.city_id === 0) {
                  // Display city and state
                  displayContent = `<div class="result-academy-item" data-loc-academy-id="${result.loc_id}" data-city="${result.city}">
                                    <span style="font-weight:700">City:</span> <span style="color:#FF5733;">${result.city}</span>, <span style="color:#157468;">${result.state}</span>
                                </div>`;
                } else {
                  // Display locality_name and city in different colors
                  displayContent = `<div class="result-academy-item" data-loc-academy-id="${result.loc_id}" data-locality="${result.locality_name}">
                                    <span style="font-weight:700">Locality:</span> <span style="color:#FF5733;">${result.locality_name}</span>, <span style="color:#157468;">${result.city}</span>
                                </div>`;
                }
  
                resultsContainer.append(displayContent);
              });
            } else {
              resultsContainer.html("<p>No results found</p>");
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX request failed:", status, error);
          },
        });
      } else {
        $(".search-results").hide(); // Hide the results container if input length is 2 or less
        resultsContainer.empty(); // Clear any previous results
      }
    });
  
    $(document).on("click", ".result-academy-item", function () {
      let resultName;
      if ($(this).data("city")) {
        resultName = $(this).data("city");
      } else if ($(this).data("locality")) {
        resultName = $(this).data("locality");
      }
  
      locationAcademyId = $(this).data("loc-academy-id");
      $("#searchAcademyLocation").val(resultName);
      $(".search-results").hide(); // Hide the results container after selection
    });
  
    $("#academySearchButton").on("click", function () {
      $.ajax({
        url: "/bmp-search",
        method: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          search_type: "advanced_search",
          tbl: "bmp_academy_details",
          sport_id: selectedAcademySport,
          loc_id: locationAcademyId,
        },
        success: function (response) {
          window.open(response.results.url, "_self");;
        },
        error: function (xhr, status, error) {
          console.error("AJAX request failed:", status, error);
        },
      });
    });
  
    $(document).click(function (event) {
      const $target = $(event.target);
      if (
        !$target.closest("#searchAcademyLocation").length &&
        !$target.closest("#academy-location-results").length
      ) {
        $("#academy-location-results").hide();
        $("#searchAcademyLocation").val("");
      }
    });
    $(document).click(function (event) {
      const $target = $(event.target);
      if (
        !$target.closest("#searchCoachLocation").length &&
        !$target.closest("#coach-location-results").length
      ) {
        $("#coach-location-results").hide();
        $("#searchCoachLocation").val("");
      }
    });
    $(document).click(function (event) {
      const $target = $(event.target);
      if (
        !$target.closest("#searchPlayerLocation").length &&
        !$target.closest("#player-location-results").length
      ) {
        $("#player-location-results").hide();
        $("#searchPlayerLocation").val("");
      }
    });
    $(document).click(function (event) {
      const $target = $(event.target);
      if (
        !$target.closest("#searchPlayer").length &&
        !$target.closest("#player-results").length
      ) {
        $("#player-results").hide();
        $("#searchPlayer").val("");
      }
    });
    $(document).click(function (event) {
      const $target = $(event.target);
      if (
        !$target.closest("#searchAcademy").length &&
        !$target.closest("#results").length
      ) {
        $("#results").hide();
        $("#searchAcademy").val("");
      }
    });
    $(document).click(function (event) {
      const $target = $(event.target);
      if (
        !$target.closest("#searchCoach").length &&
        !$target.closest("#coach-results").length
      ) {
        $("#coach-results").hide();
        $("#searchCoach").val("");
      }
    });
  
    //academy sport and location search ends
    setTimeout(function () {
      $(".loader_img").hide();
      $(".popular-coaches-section .coach_card").removeClass("hidden");
      $(".select-sport-section .sport_card").removeClass("hidden");
      $(".top-cities-section .city_card").removeClass("hidden");
      $(".js-popular-sports-academies .academy_card").removeClass("hidden");
    }, 3000);
  
    function initializeSlider(
      scrollLeftSelector,
      scrollRightSelector,
      sliderSelector
    ) {
      let $scrollLeft = $(scrollLeftSelector);
      let $scrollRight = $(scrollRightSelector);
      let $slider = $(sliderSelector);
  
      function getScrollAmount() {
        return $(window).width() >= 1100 ? 400 : 275;
      }
  
      $scrollLeft.click(function () {
        $slider.animate({ scrollLeft: `-=${getScrollAmount()}` }, "smooth");
      });
  
      $scrollRight.click(function () {
        $slider.animate({ scrollLeft: `+=${getScrollAmount()}` }, "smooth");
      });
    }
  
    // Initialize the slider with the specified selectors
    initializeSlider("#scroll-left1", "#scroll-right1", ".popular-coaches-js");
    initializeSlider("#scroll-left2", "#scroll-right2", ".sport-js");
    initializeSlider("#scroll-left3", "#scroll-right3", ".js-top-cities");
    initializeSlider("#scroll-left4", "#scroll-right4", ".js-popular-sports-academies");
  
    
  });
  