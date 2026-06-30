<!-- Modal -->
<div class="modal fade top-aligned" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body city-sport-popup"></div>
        </div>
    </div>
</div>

<!-- Menu Header -->
<div id="menuHeader" class="d-md-block d-none">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-start" class="breadcrumb_wrap">
            <div class="breadcrumbs">
                @if(count($data['breadcrumbs'])>0)
                <span><a href="/">Home</a></span>
                @endif
                @foreach($data['breadcrumbs'] as $breadcrumb)
                    <img src="{{env('AWS_CF_BASE_URL')}}/asset/images/black_arrow_top.svg" alt="arrow" width="14" height="8">
                    <span><a href="{{ $breadcrumb->link }}">{{ $breadcrumb->name }}</a></span>
                @endforeach
            </div>
            <div class="menus">
                <ul>
                    <li><a href="/">Home</a></li>
                    <li class="down_icon"><a href="javascript:void(0)" class="mega_menu" data-url="{{ route('get_subcategories') }}"
                            data-id="2"> Academies <i class='bx bx-chevron-down'></i></a>
                    </li>
                    <li class="down_icon"><a href="javascript:void(0)" class="mega_menu" data-url="{{ route('get_subcategories') }}" data-id="3">Coaches <i class='bx bx-chevron-down'></i></a></li>
                    <li class="down_icon"><a href="javascript:void(0)" class="mega_menu" data-url="{{ route('get_subcategories') }}"
                            data-id="1"> City <i class='bx bx-chevron-down'></i></a>
                    </li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>