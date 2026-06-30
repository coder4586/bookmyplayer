<!-- table section  -->

<div class="row table_section">

    <div class="col-lg-6">
        <div class="mobile_academy_table nearest_school">
            <div class="mobile_academy_table_heading">
                <h3>Nearby Schools ({{ count($data['schools']) }})</h3>
            </div>
            <div class="mobile_academy_school_table">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" class="mobile_academy_position_middle">#</th>
                            <th scope="col">school name</th>
                            <th scope="col" class="mobile_academy_position_middle mob_table_border">location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['schools'] as $school)
                        <tr>
                            <td class="mobile_academy_position_middle mob_academy_table_color">{{ $loop->iteration }}</td>
                            <td class="mob_academy_table_color">{{ $school->school_name }}</td>
                            <td class="mobile_academy_position_middle mob_academy_table_color mob_table_border">
                                {{ implode(', ', array_filter([$school->cluster, $school->block, $school->district])) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="col-lg-6">
        <div class="mobile_academy_table nearest_school">
            <div class="mobile_academy_table_heading">
                <h3>other {{$data['d']->sport}} Academies Nearby ({{count($data['nearbyacademies'])}})</h3></div>
            <div class="mobile_academy_school_table">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">academy Name</th>
                            <th scope="col" class="mob_table_border">location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['nearbyacademies'] as $nearbyacademie)
                        <tr>
                            <td class="mobile_academy_position_middle mob_academy_table_color">{{ $loop->iteration }}</td>
                            <td class="mob_academy_table_color">
                                <a href="{{ $nearbyacademie->url }}" target="_blank">{{ $nearbyacademie->name }}</a>
                            </td>
                            <td class="mob_table_border mob_academy_table_color">
                                {{ implode(', ', array_filter([$nearbyacademie->address1, $nearbyacademie->address2,
                                $nearbyacademie->city])) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="mobile_academy_table nearest_school">
            <div class="mobile_academy_table_heading">
                <h3>Participate In {{$data['d']->sport}} Tournaments ({{ count($data['upcomingtournament']) }})</h3>
            </div>
            <div class="mobile_academy_school_table">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="mob_table_border">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['upcomingtournament'] as $tournament)
                        <tr>
                            <td class="mobile_academy_position_middle mob_academy_table_color">{{ $loop->iteration }}</td>
                            <td class="mob_academy_table_color">
                                <a href="{{ $tournament->url }}" target="_blank">{{ $tournament->name }}</a>
                            </td>
                            <td class="mob_table_border mob_academy_table_color">{{ $tournament->level }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="mobile_academy_table nearest_school">
            <div class="mobile_academy_table_heading">
                <h3>Recognised {{$data['d']->sport}} Certifications ({{ count($data['certificates']) }})</h3>
            </div>
            <div class="mobile_academy_school_table">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" class="mobile_academy_position_middle">#</th>
                            <th scope="col" class="table_tournament_name">Name</th>
                            <th scope="col" class="mobile_academy_position_middle">Institute</th>
                            <th scope="col" class="mob_table_border">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['certificates'] as $certificate)
                        <tr>
                            <td class="mobile_academy_position_middle mob_academy_table_color">{{ $loop->iteration }}</td>
                            <td class="mob_academy_table_color stadium_trim"><a href="{{ $certificate->url }}"
                                    target="_blank">{{ $certificate->name }}</a></td>
                            <td class="mob_table_border mob_academy_table_color">{{ $certificate->authority }}</td>
                            <td class="mob_table_border mob_academy_table_color">{{ $certificate->level }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- table section ends -->
