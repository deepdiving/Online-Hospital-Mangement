<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <?php $userImage = Pharma::getinfo('users','id',Sentinel::getUser()->id)?>
        <!-- User profile -->
        <div class="user-profile" style="background: url({{!empty($userImage->profile_banar)?asset(Storage::url($userImage->profile_banar)) : asset('material//assets/images/users/1.jpg')}}) no-repeat; background-position: center; background-size: cover;">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{!empty($userImage->profile_image)?asset(Storage::url($userImage->profile_image)) : asset('material//assets/images/users/1.jpg')}}" alt="user"></div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{Sentinel::getUser()->name}}</a>
                <div class="dropdown-menu animated flipInY">
                    <a href="{{url('myprofile')}}" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    <a href="{{url('users/activities')}}" class="dropdown-item"><i class="mdi mdi-run-fast"></i> My Activities</a>
                    <a href="{{url('users/notification')}}" class="dropdown-item"><i class="mdi mdi-alarm-multiple"></i> My Notification</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url('myprofile')}}" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{url('logout')}}" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li><a href="{{url('dashboard')}}"><i class="mdi mdi-home"></i><span class="hide-menu">Dashboard</span></a></li>

                <li class="{{ request()->is('prescription/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('prescription/*')?'true':'false'}}"><i class="mdi mdi-calendar-text"></i><span class="hide-menu">Prescription</span></a>
                    <ul aria-expanded="{{ Request::is('prescription/*')?'true':'false'}}" class="collapse {{ Request::is('prescription/*')?'in':''}}">
                        <li><a href="{{url('prescription/')}}" class="{{ request()->is('prescription/') ? 'active' : '' }}"><i class="mdi mdi-calendar-plus"></i> Make Prescription </a></li>
                        <li><a href="{{url('prescription/list')}}" class="{{ request()->is('prescription/list') || request()->is('prescription/invoice/*') ? 'active' : '' }}"><i class="mdi mdi-dns"></i> Prescriptions</a></li>
                        <li><a href="{{url('prescription/voided')}}" class="{{ request()->is('prescription/voided') ? 'active' : '' }}"><i class="mdi mdi-archive"></i> Void</a></li> 
                    </ul>
                </li>   
            
                <li><a href="{{url('medicines')}}" class="{{ request()->is('medicines/') ? 'active' : '' }}"><i class="mdi mdi-pill"></i><span class="hide-menu"> Medicines</span></a></li>
                <li><a href="{{url('doctor/medicine/type')}}" class="{{ request()->is('doctor/medicine/type/*') ? 'active' : '' }}"><i class="mdi mdi-chart-pie"></i> <span class="hide-menu"> Categories</span></a></li>  
                <li><a href="{{url('doctor/medicine/routine')}}" class="{{ request()->is('doctor/medicine/routine/*') ? 'active' : '' }}"><i class="mdi mdi-calendar-clock"></i> <span class="hide-menu"> Routine</span></a></li> 
                <li><a href="{{url('logout')}}"><i class="mdi mdi-power"></i> <span class="hide-menu"> Logout</span></a></li> 

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <div class="sidebar-footer">
        <a href="{{url('myprofile')}}" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <a href="{{url('users/activities')}}" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-run-fast"></i></a>
        <a href="{{url('logout')}}" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
    </div>
    <!-- End Bottom points-->
</aside>
