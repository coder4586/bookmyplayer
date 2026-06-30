$(document).ready(function() {

    $('.top_menu').click(function() {
        $('.top_menu').removeClass('active');
        $(this).addClass('active');
        
        $('.content-page').hide();
        
        if (this.id === 'dashboard_box') {
            $('#dashboard_page').show();
        } else if (this.id === 'academy_box') {
            $('#academy_page').show();
        } else if (this.id === 'coach_box') {
            $('#coach_page').show();
        } else if (this.id === 'players_box') {
            $('#players_page').show();
        }
    });

    const $searchInput = $('#academy-search-input');
    const $resultsBox = $('#academy-results-box');
    const $resultsList = $('#academy-results-list');

    // Function to call AJAX and fetch results
    $searchInput.on('input', function() {
        const query = $(this).val().trim();
        if (query.length > 1) {
            $.ajax({
                url: "/bmp-search", // Replace with your actual API URL
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    search_type: "basic",
                    term: query,
                    tbl: "bmp_academy_details", // Ensure we are only searching for academy
                },
                success: function(response) {
                    console.log(response);
                    let html = "";
                    if (response.results && response.results.length === 0) {
                        html += '<li class="no-results">No results found</li>';
                    } else {
                        response.results.forEach((entity) => {
                            let locationInfo = "";

                            // Build locationInfo based on available data
                            if (entity.city_id === 0) {
                                if (entity.city && entity.state) {
                                    locationInfo = `${entity.city}, ${entity.state}`;
                                } else if (entity.city) {
                                    locationInfo = entity.city;
                                } else if (entity.state) {
                                    locationInfo = entity.state;
                                }
                            } else {
                                if (entity.locality_name && entity.city) {
                                    locationInfo = `${entity.locality_name}, ${entity.city}`;
                                } else if (entity.locality_name) {
                                    locationInfo = entity.locality_name;
                                } else if (entity.city) {
                                    locationInfo = entity.city;
                                }
                            }

                            html += `
                                <li class="academy-result-item">
                                    <div class="academy-result-name">${entity.name}-<span class="master_sport"> ${entity.sport_name} </span> - <span class="master_location"> ${locationInfo} </span></div>
                                </li>
                            `;
                        });
                    }
                    $resultsList.html(html);
                    $resultsBox.show();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            $resultsBox.hide();
        }
    });

    // Close the dropdown when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#academy-search-container').length) {
            $resultsBox.hide();
        }
    });

    $(document).on('click', '.academy-result-name', function () {
        $('#profile_page').removeClass('hidden');
        $resultsBox.hide();
      });
});
