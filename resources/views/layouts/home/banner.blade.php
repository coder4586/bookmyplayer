<section class="home-banner-section clearfix">
    <div class="container">
        <h1>Search Coach, Academy, Player In your area... </h1>
        <p>18000+ Players, 40000 Acadefffffmies, 67000 Coaches, 3800 Teams</p>
        <div class="search-tabs clearfix">
            <div class="tab-content">
                <ul>
                    <li><a href="javascript:void(0)" class="select">Academy</a></li>
                    <li><a href="javascript:void(0)">Coach</a></li>
                    <li><a href="javascript:void(0)">Player</a></li>
                    <li><a href="javascript:void(0)">Others</a></li>
                </ul>
            </div>
            <div class="tab-details">
                <div>
                    <div class="row">
                        <div class="col-md-3 academySportSearch">
                            <select name="" id="searchAcademySport" class="form-control">
                                <option value="">Select Sport Type</option>
                                <option value="29">Archery</option>
                                <option value="12">Arts</option>
                                <option value="26">Athletics</option>
                                <option value="6">Badminton</option>
                                <option value="36">Baseball</option>
                                <option value="2">Basketball</option>
                                <option value="20">Billiard</option>
                                <option value="18">Boxing</option>
                                <option value="3">Cricket</option>
                                <option value="38">Carrom</option>
                                <option value="13">Chess</option>
                                <option value="24">Fencing</option>
                                <option value="1">Football</option>
                                <option value="7">Golf</option>
                                <option value="31">Gym</option>
                                <option value="11">Gymnastics</option>
                                <option value="39">Handball</option>
                                <option value="15">Hockey</option>
                                <option value="10">Kabaddi</option>
                                <option value="40">Kalaripayayttu</option>
                                <option value="4">Karate</option>
                                <option value="22">Khokho</option>
                                <option value="19">Motorsports</option>
                                <option value="9">MMA</option>
                                <option value="34">Personal Trainer</option>
                                <option value="30">Rugby</option>
                                <option value="28">Taekwondo</option>
                                <option value="21">Table Tennis</option>
                                <option value="16">Tennis</option>
                                <option value="25">Skating</option>
                                <option value="37">Snooker</option>
                                <option value="8">Shooting</option>
                                <option value="35">Silambam</option>
                                <option value="23">Squash</option>
                                <option value="5">Swimming</option>
                                <option value="27">Volleyball</option>
                                <option value="17">Wrestling</option>
                                <option value="32">Yoga</option>

                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <input type="text" class="form-control your-location" id="searchAcademyLocation" placeholder="Select Location" autocomplete="off">
                            <div class="search-results" id="academy-location-results"></div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <input type="text" class="form-control" id="searchAcademy" placeholder="Search by Academy name" autocomplete="off">
                            <div class="search-results-academy" id="results"></div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="academySearchButton" class="btn btn-secondary btn-lg"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                </div>
                <div style="display:none;">
                    <div class="row">
                        <div class="col-md-3 coachSportSearch">
                            <select name="" id="searchCoachSport" class="form-control">
                            <option value="">Select Sport Type</option>
                                <option value="29">Archery</option>
                                <option value="12">Arts</option>
                                <option value="26">Athletics</option>
                                <option value="6">Badminton</option>
                                <option value="36">Baseball</option>
                                <option value="2">Basketball</option>
                                <option value="20">Billiard</option>
                                <option value="18">Boxing</option>
                                <option value="3">Cricket</option>
                                <option value="38">Carrom</option>
                                <option value="13">Chess</option>
                                <option value="24">Fencing</option>
                                <option value="1">Football</option>
                                <option value="7">Golf</option>
                                <option value="31">Gym</option>
                                <option value="11">Gymnastics</option>
                                <option value="39">Handball</option>
                                <option value="15">Hockey</option>
                                <option value="10">Kabaddi</option>
                                <option value="40">Kalaripayayttu</option>
                                <option value="4">Karate</option>
                                <option value="22">Khokho</option>
                                <option value="19">Motorsports</option>
                                <option value="9">MMA</option>
                                <option value="34">Personal Trainer</option>
                                <option value="30">Rugby</option>
                                <option value="28">Taekwondo</option>
                                <option value="21">Table Tennis</option>
                                <option value="16">Tennis</option>
                                <option value="25">Skating</option>
                                <option value="37">Snooker</option>
                                <option value="8">Shooting</option>
                                <option value="35">Silambam</option>
                                <option value="23">Squash</option>
                                <option value="5">Swimming</option>
                                <option value="27">Volleyball</option>
                                <option value="17">Wrestling</option>
                                <option value="32">Yoga</option>

                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <input type="text" class="form-control your-location" id="searchCoachLocation" placeholder="Select Location" autocomplete="off">
                            <div class="search-results" id="coach-location-results"></div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <input type="text" class="form-control" id="searchCoach" placeholder="Search by Coach name" autocomplete="off">
                            <div class="search-results-coach" id="coach-results"></div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="coachSearchButton" class="btn btn-secondary btn-lg"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                </div>
                <div style="display:none;">
                    <div class="row">
                        <div class="col-md-3 playerSportSearch">
                            <select name="" id="searchPlayerSport" class="form-control">
                            <option value="">Select Sport Type</option>
                                <option value="29">Archery</option>
                                <option value="12">Arts</option>
                                <option value="26">Athletics</option>
                                <option value="6">Badminton</option>
                                <option value="36">Baseball</option>
                                <option value="2">Basketball</option>
                                <option value="20">Billiard</option>
                                <option value="18">Boxing</option>
                                <option value="3">Cricket</option>
                                <option value="38">Carrom</option>
                                <option value="13">Chess</option>
                                <option value="24">Fencing</option>
                                <option value="1">Football</option>
                                <option value="7">Golf</option>
                                <option value="31">Gym</option>
                                <option value="11">Gymnastics</option>
                                <option value="39">Handball</option>
                                <option value="15">Hockey</option>
                                <option value="10">Kabaddi</option>
                                <option value="40">Kalaripayayttu</option>
                                <option value="4">Karate</option>
                                <option value="22">Khokho</option>
                                <option value="19">Motorsports</option>
                                <option value="9">MMA</option>
                                <option value="34">Personal Trainer</option>
                                <option value="30">Rugby</option>
                                <option value="28">Taekwondo</option>
                                <option value="21">Table Tennis</option>
                                <option value="16">Tennis</option>
                                <option value="25">Skating</option>
                                <option value="37">Snooker</option>
                                <option value="8">Shooting</option>
                                <option value="35">Silambam</option>
                                <option value="23">Squash</option>
                                <option value="5">Swimming</option>
                                <option value="27">Volleyball</option>
                                <option value="17">Wrestling</option>
                                <option value="32">Yoga</option>

                            </select>
                        </div>
                        <div class="col-md-3 position-relative">
                            <input type="text" class="form-control your-location" id="searchPlayerLocation" placeholder="Select Location" autocomplete="off">
                            <div class="search-results" id="player-location-results"></div>
                        </div>
                        <div class="col-md-4 position-relative">
                            <input type="text" class="form-control" id="searchPlayer" placeholder="Search by Player name" autocomplete="off">
                            <div class="search-results-players" id="player-results"></div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary btn-lg" id="playerSearchButton"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                </div>
                <div style="display:none;">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="" id="" class="form-control">
                                <option value="">Select Sport Type</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control your-location" id="" placeholder="Select Location" autocomplete="off">
                        </div>
                        <div class="col-md-4 position-relative">
                            <input type="text" class="form-control" id="" placeholder="Search by Other" autocomplete="off">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary btn-lg"><i class="fa-solid fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="counter-section clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-6">
                <div class="counter">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/counter-players-icon.svg" loading="lazy" alt="Player Icon" width="60" height="60"></figure>
                    <h4>18000+</h4>
                    <h6>Players</h6>
                </div>
            </div>
            <div class="col-sm-3 col-6">
                <div class="counter">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/counter-academies-icon.svg" loading="lazy" alt="Academy Icon" width="60" height="60"></figure>
                    <h4>40000+</h4>
                    <h6>Academies</h6>
                </div>
            </div>
            <div class="col-sm-3 col-6">
                <div class="counter">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/counter-coaches-icon.svg" loading="lazy" alt="Coach Icon" width="60" height="60"></figure>
                    <h4>67000+</h4>
                    <h6>Coaches</h6>
                </div>
            </div>
            <div class="col-sm-3 col-6">
                <div class="counter">
                    <figure><img src="{{env('AWS_CF_BASE_URL')}}/asset/images/counter-teams-icon.svg" loading="lazy" alt="Teams Icon" width="60" height="60"></figure>
                    <h4>3800+</h4>
                    <h6>Teams</h6>
                </div>
            </div>
        </div>
    </div>
</section>