<div id="menuHeader" class="d-md-block d-none">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Chess academy</a></li>
                </ul>
            </div>
            <div class="menus">
                <ul>
                    @foreach ($categories as $category)
                        <li><a href="javascript:void(0)" class="mega_menu" data-url="{{ route('get_subcategories') }}"
                                data-id="{{ $category->id }}">{{ $category->title }} <i class='bx bx-chevron-down'></i></a>
                        </li>
                    @endforeach
                    <li><a href="javascript:void(0)">Competition <i class='bx bx-chevron-down'></i></a></li>
                    <li><a href="javascript:void(0)">Blog</a></li>
                    <li><a href="javascript:void(0)">Contact</a></li>
                </ul>
            </div>

            <!-- Hidden menu -->
            <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>