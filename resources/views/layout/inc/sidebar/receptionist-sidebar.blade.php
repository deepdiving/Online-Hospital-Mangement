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
                <li class="{{ request()->is('appointment/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('appointment/*')?'true':'false'}}"><i class="mdi mdi-calendar-blank"></i><span class="hide-menu"> Appointment</span></a>
                    <ul aria-expanded="{{ Request::is('appointment/*')?'true':'false'}}" class="collapse {{ Request::is('appointment/*')?'in':''}}">
                        <li><a href="{{url('appointment/')}}" class="{{ request()->is('appointment/') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Make Appointment </a></li>
                        <li><a href="{{url('appointment-list')}}" class="{{ request()->is('appointment-list') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Appointments</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('hospital/admission/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('hospital/admission/*')?'true':'false'}}"><i class="mdi mdi mdi-hospital"></i><span class="hide-menu"> Admission</span></a>
                    <ul aria-expanded="{{ Request::is('hospital/admission/*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('hospital/admission/create')}}" class="{{ request()->is('hospital/admission/create') ? 'active' : '' }}"><i class="mdi mdi-hospital" style="font-size:16px"></i> Admission Form</a></li>
                        <li><a href="{{url('hospital/admission')}}" class="{{ request()->is('hospital/admission') ? 'active' : '' }}"><i class="mdi mdi-hotel" style="font-size:16px"></i> Admited List</a></li>
                        <li><a href="{{url('hospital/discharge-list')}}" class="{{ request()->is('hospital/discharge-list') ? 'active' : '' }}"><i class="mdi mdi-human-greeting" style="font-size:16px"></i> Discharged list</a></li>
                        <li><a href="{{url('hospital/admission/voided')}}" class="{{ request()->is('hospital/admission/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-forever" style="font-size:16px"></i> Voided</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('diagnostic/bill/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('diagnostic/bill/*')?'true':'false'}}"><i class="mdi mdi-newspaper"></i><span class="hide-menu"> Diagnostic</span></a>
                    <ul aria-expanded="{{ Request::is('diagnostic/bill/*')?'true':'false'}}" class="collapse {{ Request::is('diagnostic/bill/*')?'in':''}}">
                        <li><a href="{{url('diagnostic/bill/create')}}" class="{{ request()->is('diagnostic/bill/create') ? 'active' : '' }}"><i class="mdi mdi-table-edit" style="font-size:16px"></i> New Bill</a></li>
                        <li><a href="{{url('diagnostic/bill')}}" class="{{ request()->is('diagnostic/bill') || request()->is('diagnostic/bill/invoice/*') ? 'active' : '' }}"><i class="fa fa-money" style="font-size:16px"></i> All Bills</a></li>
                        <li><a href="{{url('diagnostic/bill/voided')}}" class="{{  request()->is('diagnostic/bill/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-variant" style="font-size:16px"></i> Void List</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('hospital/emergency/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('hospital/emergency/*')?'true':'false'}}"><i class="mdi mdi-ambulance"></i><span class="hide-menu"> Emergency</span></a>
                    <ul aria-expanded="{{ Request::is('hospital/emergency/*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('hospital/emergency/create')}}" class="{{ request()->is('hospital/emergency/create') ? 'active' : '' }}"><i class="mdi mdi-ambulance" style="font-size:16px"></i> Emergency Form</a></li>
                        <li><a href="{{url('hospital/emergency')}}" class="{{ request()->is('hospital/emergency') ? 'active' : '' }}"><i class="mdi mdi-view-list" style="font-size:16px"></i> Emergency List</a></li>
                        <li><a href="{{url('hospital/emergency/voided')}}" class="{{ request()->is('hospital/emergency/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-forever" style="font-size:16px"></i> Voided</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('hospital/operation/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('hospital/operation/*')?'true':'false'}}"><i class="mdi mdi-needle"></i><span class="hide-menu"> Operation</span></a>
                    <ul aria-expanded="{{ Request::is('hospital/operation/*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('hospital/operation/')}}" class="{{ request()->is('hospital/operation/') ? 'active' : '' }}"><i class="mdi mdi-needle" style="font-size:16px"></i> Operations</a></li>
                        <li><a href="{{url('hospital/operation/voided')}}" class="{{ request()->is('hospital/operation/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-forever" style="font-size:16px"></i> Voided</a></li>
                    </ul>
                </li>
                <li><a href="{{url('hospital/beds/bed/status')}}" class="{{ request()->is('hospital/beds/bed/status') ? 'active' : '' }}"><i class="mdi mdi-map-marker-radius" style="font-size:16px"></i><span class="hide-menu"> Bed Map</span></a></li>
                <li><a href="{{url('reports/user-wise-transaction?start='.date('Y-m-d').'&end='.date('Y-m-d').'&user='.Sentinel::getUser()->id)}}" class="{{ request()->is('reports/user-wise-transaction') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> <span class="hide-menu"> My Transaction </span></a></li>
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