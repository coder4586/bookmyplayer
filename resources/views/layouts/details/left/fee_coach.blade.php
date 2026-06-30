<!-- Fee Batch Tab -->
<div class="mob_academy_box">
    <div class="mob_academy_fee_box">
        <p class="mob_academy_fee_heading">{{ "Coach Details" }}</p>
    </div>
    <div class="mob_academy_fee_list">
        <ul>
            @if($data['d']->name)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Name" width="20" height="20" />
                    <span class="fee_bold">Name:</span><span class="text_capital">{{ $data['d']->name }}</span>
                </li>
            @endif

            @if($data['d']->common_location)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Location" width="20" height="20" />
                    <span class="fee_bold"> Location:</span> <span class="text_capital">{{ $data['d']->common_location}}</span>
                </li>
            @endif

            @if($data['d']->training_location)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Training" width="20" height="20" />
                    <span class="fee_bold"> Training Mode:</span>
                    <span class="text_capital">
                    @php
                        $locations = explode(',', $data['d']->training_location);
                        $modes = [];
                        foreach($locations as $index => $location) {
                            if($location == 1) {
                                $modes[] = 'Online';
                            } elseif($location == 2) {
                                $modes[] = 'Offline';
                            }
                        }
                        echo implode(count($modes) > 1 ? ' & ' : ', ', $modes);
                    @endphp
                    </span>
                </li>
            @endif

            @if($data['d']->fee)
                <li style="display: flex; align-items: start;">
                <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Fees" width="20" height="20" />
                <span class="fee_bold" style="margin-left: 5px;">Fees :</span><span class="text_capital">{{ $data['d']->fee . ' (Rs)' }}</span>
            </li>
            @endif

            @if($data['d']->package)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Packages" width="20" height="20" />
                    <span class="fee_bold"> Packages:</span> <span class="text_capital">{{ $data['d']->package . ' (Rs)' }}</span>
                </li>
            @endif

            @if($data['d']->sport)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Sport" width="20" height="20" />
                    <span class="fee_bold">Sport:</span> <span class="text_capital"> {{ ucfirst($data['d']->sport) }}</span>
                </li>
            @endif

            @if($data['d']->phone)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Contact" width="20" height="20" />
                    <span class="fee_bold">Contact:</span> <span class="text_capital">{{ $data['d']->phone }}</span>
                </li>
            @endif

            @if($data['d']->gender)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Gender" width="20" height="20" />
                    <span class="fee_bold"> Gender:</span> <span class="text_capital">{{ ucfirst($data['d']->gender) }} </span>
                </li>
            @endif

            @if($data['d']->experience)
                <li>
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/rank.svg" loading="lazy" alt="Experience" width="20" height="20" />
                    <span class="fee_bold"> Experience:</span> <span class="text_capital"> {{ $data['d']->experience .' years' }}</span>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- Fee Batch Tab End -->
