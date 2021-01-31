<nav class="navbar navbar-expand-md navbar-light">
    <button class="navbar-toggler ml-auto mb-2 bg-light" type="button" data-toggle="collapse" data-target="#myNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="myNavbar">
        <div class="container-fluid">
            <div class="row">
                <!-- sidebar -->
                <div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top">
                    <a href="{{route('home')}}" class="navbar-brand text-white d-block mx-auto text-center py-3 mb-4 bottom-border">TravelHolic</a>
                    <div class="bottom-border pb-3">
                        <img src="/storage/{{auth()->user()->username}}/profile_image/{{auth()->user()->profile->image}}" width="50" class="rounded-circle mr-3">
                        <a href="{{route('show.user.profile', auth()->user()->name)}}" class="text-white">{{auth()->user()->name}}</a>
                    </div>

                    <ul class="navbar-nav flex-column mt-4">
                        <li class="nav-item">
                            {{-- Dashboard--}}
                            <a href="{{route('dashboard')}}" class="nav-link text-white p-3 mb-2 sidebar-link @yield('dashboard')">
                                <i class="fas fa-home text-light fa-lg mr-3"></i>
                                Dashboard
                            </a>
                        </li>
                        {{-- Profile--}}
                        <li class="nav-item">
                            <a href="{{route('profile')}}" class="nav-link text-white p-3 mb-2 sidebar-link @yield('profile')">
                                <i class="fas fa-user text-light fa-lg mr-3"></i>
                                Profile
                            </a>
                        </li>
                        {{-- Blog--}}
                        <li class="nav-item dropdown" >
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white p-3 mb-2 sidebar-link @yield('blog')" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                <i class="fas fa-envelope text-light fa-lg mr-3"></i>
                                Blog
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="{{route('dashboard.blog')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                    Index
                                </a>
                                <a href="{{route('dashboard.blog.create')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                    Create
                                </a>
                            </div>
                        </li>

                        {{-- Tour --}}
                        @can('isTourVendor')
                            <li class="nav-item dropdown" >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white p-3 mb-2 sidebar-link @yield('tour')" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                    <i class="fas fa-envelope text-light fa-lg mr-3"></i>
                                    Tour
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="{{route('dashboard.tour')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Index
                                    </a>

                                    <a href="{{route('dashboard.tour.create')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Create
                                    </a>
                                </div>
                            </li>
                        @endcan

                        {{-- Tour --}}
                        @can('isHotelVendor')
                            <li class="nav-item dropdown" >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white p-3 mb-2 sidebar-link @yield('hotel')" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                    <i class="fas fa-envelope text-light fa-lg mr-3"></i>
                                    Hotels
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="{{route('dashboard.hotel')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Index
                                    </a>

                                    <a href="{{route('dashboard.hotel.create')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Create
                                    </a>
                                    <a href="{{route('dashboard.hotel.bookings')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Bookings
                                    </a>
                                </div>
                            </li>
                        @endcan

                        {{-- Tour --}}
                        @can('isVehicleVendor')
                            <li class="nav-item dropdown" >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white p-3 mb-2 sidebar-link @yield('vehicle')" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                    <i class="fas fa-envelope text-light fa-lg mr-3"></i>
                                    Vehicle
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="{{route('dashboard.vehicle')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Index
                                    </a>

                                    <a href="{{route('dashboard.vehicle.create')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Create
                                    </a>
                                    <a href="" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Bookings
                                    </a>
                                </div>
                            </li>
                        @endcan

                        @can('isStandard')
                            <li class="nav-item dropdown" >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white p-3 mb-2 sidebar-link @yield('booking')" role="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                    <i class="fas fa-envelope text-light fa-lg mr-3"></i>
                                    My Bookings
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a href="{{route('dashboard.tour.booking')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Tour
                                    </a>
                                    <a href="{{route('dashboard.hotel.booking')}}" class="nav-item dropdown-item text-white p-3 mb-2 sidebar-link">
                                        Hotel
                                    </a>
                                </div>
                            </li>
                        @endcan
{{--                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link @yield('current')"><i class="fas fa-shopping-cart text-light fa-lg mr-3"></i>Sales</a></li>--}}
{{--                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link @yield('current')"><i class="fas fa-chart-line text-light fa-lg mr-3"></i>Analytics</a></li>--}}
{{--                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link @yield('current')"><i class="fas fa-chart-bar text-light fa-lg mr-3"></i>Charts</a></li>--}}
{{--                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link @yield('current')"><i class="fas fa-table text-light fa-lg mr-3"></i>Tables</a></li>--}}
{{--                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link @yield('current')"><i class="fas fa-wrench text-light fa-lg mr-3"></i>Settings</a></li>--}}
{{--                        <li class="nav-item"><a href="#" class="nav-link text-white p-3 mb-2 sidebar-link @yield('current')"><i class="fas fa-file-alt text-light fa-lg mr-3"></i>Documentation</a></li>--}}
                    </ul>
                </div>
                <!-- end of sidebar -->

                <!-- top-nav -->
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto bg-dark fixed-top py-2 top-navbar">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h4 class="text-light text-uppercase mb-0">@yield('headerName')</h4>
                        </div>
                        <div class="col-md-5">
                            <form>
                                <div class="input-group">
                                    <input type="text" class="form-control search-input" placeholder="Search...">
                                    <button type="button" class="btn btn-white search-button"><i class="fas fa-search text-danger"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <ul class="navbar-nav">
                                <li class="nav-item icon-parent"><a href="#" class="nav-link icon-bullet"><i class="fas fa-comments text-muted fa-lg"></i></a></li>
                                <li class="nav-item icon-parent"><a href="#" class="nav-link icon-bullet"><i class="fas fa-bell text-muted fa-lg"></i></a></li>
                                <li class="nav-item ml-md-auto"><a  href="" class="nav-link" data-toggle="modal" data-target="#sign-out"><i class="fas fa-sign-out-alt text-danger fa-lg"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end of top-nav -->
            </div>
        </div>
    </div>
</nav>

<!-- modal -->
<div class="modal fade" id="sign-out">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Want to leave?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Press logout to leave
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Stay Here</button>
                <button type="button" onclick=" event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger" data-dismiss="modal">Logout</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end of modal -->
