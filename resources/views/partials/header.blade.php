<nav class="navbar navbar-expand-lg">
    <div class="container-fluid flex-nowrap">
      <a class="navbar-brand" href="#"><img src="{{ asset('assets/images/logo.png') }}" alt="" class="lazy"></a>
      <div class="d-flex justify-content-between w-100 align-items-center">
      <form class="d-flex" id="searchForm">
        <input class="" type="text" placeholder="Search" name="query" value="{{ request()->has('query') && request()->get('query') ? request()->get('query') : '' }}">
        <button><i class='bx bx-search'></i></button>
      </form>
      <div>
        <ul class="navbar-nav">
          <li class="nav-item ">
            <a class="nav-link detect_location" href="#">Detect your location  <i class='bx bxs-map'></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link registerBtn " href="#" >Register</a>
          </li>
        </ul>
      </div>

      </div>
    </div>
  </nav>

@include('partials.menu')
