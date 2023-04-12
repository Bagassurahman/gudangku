<div class="page-header">
    <div class="search-form">
        <form action="#" method="GET">
            <div class="input-group">
                <input class="form-control search-input" name="search" placeholder="Type something..." type="text" />
                <span class="input-group-btn">
                    <span id="close-search"><i class="ion-ios-close-empty"></i></span>
                </span>
            </div>
        </form>
    </div>
    <!--================================-->
    <!-- Page Header  Start -->
    <!--================================-->
    <nav class="navbar navbar-expand-lg">
        <ul class="list-inline list-unstyled mg-r-20">
            <!-- Mobile Toggle and Logo -->
            <li class="list-inline-item align-text-top"><a class="hidden-md hidden-lg" href="#"
                    id="sidebar-toggle-button"><i class="ion-navicon tx-20"></i></a></li>
            <!-- PC Toggle and Logo -->
            <li class="list-inline-item align-text-top"><a class="hidden-xs hidden-sm" href="#"
                    id="collapsed-sidebar-toggle-button"><i class="ion-navicon tx-20"></i></a></li>
        </ul>
        <!--================================-->
        <!-- Mega Menu Start -->
        <!--================================-->
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">


            </ul>
        </div>
        <!--/ Mega Menu End-->
        <!--/ Brand and Logo End -->
        <!--================================-->
        <!-- Header Right Start -->
        <!--================================-->
        <div class="header-right pull-right">
            <ul class="list-inline justify-content-end">


                <li class="list-inline-item dropdown">
                    <a href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="select-profile">Hai, {{ Auth::user()->name }}</span>
                        <img src="assets/images/avatar/avatar1.png" class="img-fluid wd-35 ht-35 rounded-circle"
                            alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-profile shadow-2">
                        <div class="user-profile-area">
                            <div class="user-profile-heading">
                                <div class="profile-thumbnail">
                                    <img src="assets/images/avatar/avatar1.png"
                                        class="img-fluid wd-35 ht-35 rounded-circle" alt="">
                                </div>
                                <div class="profile-text">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <span> {{ Auth::user()->email }}</span>
                                </div>
                            </div>

                            <a href="page-singin.html" class="dropdown-item"><i class="icon-power"
                                    aria-hidden="true"></i> Sign-out</a>
                        </div>
                    </div>
                </li>
                <!-- Profile Dropdown End -->
                <!--================================-->
                <!-- Setting Sidebar Start -->
                <!--================================-->

                <!--/ Setting Sidebar End -->
            </ul>
        </div>
        <!--/ Header Right End -->
    </nav>
</div>
