<div class="filter">
    <div class="filter_header d-flex justify-content-between">
        <div>
            <h3><i class='bx bx-filter-alt'></i> Filter</h3>
        </div>
        <div>
            <i class='bx bx-x' id="closeFilter"></i>
        </div>
    </div>
    <div class="applyFilters">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="m-0">Applied Filters</h5>
            </div>
            <div>
                <a href="{{ url('/') }}" class="clearFilters"> <i class="bx bx-x"></i> Clear All</a>
            </div>
        </div>
        <div class="applied_filter_tags_main">
            @if (request()->has('locality') && request()->get('locality') != '')
                <a href="javascript:void(0)" class="applied_filter_tags">{{ request()->get('locality') }} <i
                        class="bx bx-x deleteParam" data-name="locality"></i></a>
            @endif
            @if (request()->has('type'))
                <a href="javascript:void(0)" class="applied_filter_tags">{{ request()->get('type') }} <i
                        class="bx bx-x deleteParam" data-name="type"></i></a>
            @endif
            @if (request()->has('acedemy_verified'))
                <a href="javascript:void(0)" class="applied_filter_tags">Verified <i class="bx bx-x deleteParam"
                        data-name="acedemy_verified"></i></a>
            @endif
            @if (request()->has('acedemy_open'))
                <a href="javascript:void(0)" class="applied_filter_tags">Opened <i class="bx bx-x deleteParam"
                        data-name="acedemy_open"></i></a>
            @endif
        </div>
    </div>
    <form action="" method="get">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button
                        class="accordion-button {{ request()->has('locality') && request()->get('locality') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                        aria-expanded="false" aria-controls="flush-collapseOne">
                        <img src="{{ asset('assets/images/map_search.png') }}" alt="" class="lazy">&nbsp;
                        Localities
                    </button>
                </h2>
                <div id="flush-collapseOne"
                    class="accordion-collapse collapse {{ request()->has('locality') && request()->get('locality') ? 'show' : '' }}"
                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body p-0">
                        <input type="text" class="form-control" placeholder="Search Localities" name="locality"
                            value="{{ request()->has('locality') && request()->get('locality') ? request()->get('locality') : '' }}">
                        <div class="localities">
                            <ul>
                                @if (session()->get('locality'))
                                    @php
                                        $locality = session()->get('locality');
                                        $reversedLocality = array_reverse($locality);
                                    @endphp
                                    @foreach ($reversedLocality as $key => $item)
                                        <li><a href="javascript:void(0)" class="locality_tags">{{ $item }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button
                        class="accordion-button  {{ request()->has('type') && request()->get('type') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                        aria-expanded="false" aria-controls="flush-collapseTwo">
                        <img src="{{ asset('assets/images/search_icons.png') }}" alt="" class="lazy">&nbsp;
                        Search By
                    </button>
                </h2>
                <div id="flush-collapseTwo"
                    class="accordion-collapse collapse  {{ request()->has('type') && request()->get('type') ? 'show' : '' }}"
                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="radio" class="form-check-input" id="acedemy" name="type"
                                    value="acedemy"
                                    {{ request()->has('type') && request()->get('type') == 'acedemy' ? 'checked' : '' }}>
                                <label for="acedemy">Acedemy</label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" class="form-check-input" id="coach" name="type"
                                    value="coach"
                                    {{ request()->has('type') && request()->get('type') == 'coach' ? 'checked' : '' }}>
                                <label for="coach">Coach</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button
                        class="accordion-button  {{ request()->has('rating') && request()->get('rating') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                        aria-expanded="false" aria-controls="flush-collapseThree">
                        <img src="{{ asset('assets/images/ic_twotone-stars.png') }}" alt=""
                            class="lazy">&nbsp; Ratings
                    </button>
                </h2>
                <div id="flush-collapseThree"
                    class="accordion-collapse collapse {{ request()->has('rating') && request()->get('rating') ? 'show' : '' }}"
                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body p-0">
                        <div class="d-flex align-items-center gap-2">
                            <input type="radio" name="rating" value="5" id="rating_5"
                                {{ request()->has('rating') && request()->get('rating') == 5 ? 'checked' : '' }}>
                            <label for="rating_5">
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <span><strong>(5)</strong></span>
                            </label>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <input type="radio" name="rating" value="4" id="rating_4"
                                {{ request()->has('rating') && request()->get('rating') == 4 ? 'checked' : '' }}>
                            <label for="rating_4">
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating"></i>
                                <span><strong>(4)</strong></span>
                            </label>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <input type="radio" name="rating" value="3" id="rating_3"
                                {{ request()->has('rating') && request()->get('rating') == 3 ? 'checked' : '' }}>
                            <label for="rating_3">
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating"></i>
                                <i class="bx bx-star rating"></i>
                                <span><strong>(3)</strong></span>
                            </label>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <input type="radio" name="rating" value="2" id="rating_2"
                                {{ request()->has('rating') && request()->get('rating') == 2 ? 'checked' : '' }}>
                            <label for="rating_2">
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating"></i>
                                <i class="bx bx-star rating"></i>
                                <i class="bx bx-star rating"></i>
                                <span><strong>(2)</strong></span>
                            </label>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <input type="radio" name="rating" value="1" id="rating_1"
                                {{ request()->has('rating') && request()->get('rating') == 1 ? 'checked' : '' }}>
                            <label for="rating_1">
                                <i class="bx bx-star rating checked"></i>
                                <i class="bx bx-star rating"></i>
                                <i class="bx bx-star rating"></i>
                                <i class="bx bx-star rating"></i>
                                <i class="bx bx-star rating"></i>
                                <span><strong>(1)</strong></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button
                        class="accordion-button  {{ request()->has('acedemy_verified') && request()->get('acedemy_verified') ? '' : 'collapsed' }} {{ request()->has('acedemy_open') && request()->get('acedemy_open') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour"
                        aria-expanded="false" aria-controls="flush-collapseThree">
                        <img src="{{ asset('assets/images/2746988-200 2.png') }}" alt=""
                            class="lazy">&nbsp; Acedemies Status
                    </button>
                </h2>
                <div id="flush-collapseFour"
                    class="accordion-collapse collapse {{ request()->has('acedemy_verified') && request()->get('acedemy_verified') ? 'show' : '' }} {{ request()->has('acedemy_open') && request()->get('acedemy_open') ? 'show' : '' }}"
                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body p-0">
                        <div>
                            <input type="checkbox" class="form-check-input" id="verified_acedemy"
                                name="acedemy_verified" value="1"
                                {{ request()->has('acedemy_verified') && request()->get('acedemy_verified') == 1 ? 'checked' : '' }}>
                            <label for="verified_acedemy">Verified Acedemy</label>
                        </div>
                        <div class="mt-2">
                            <input type="checkbox" class="form-check-input" id="open_acedemy" name="acedemy_open"
                                value="1"
                                {{ request()->has('acedemy_open') && request()->get('acedemy_open') == 1 ? 'checked' : '' }}>
                            <label for="open_acedemy">Open Acedemy</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="mt-3 filterApplyBtn">Apply Filters</button>
    </form>
</div>
