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

                <li class="{{ request()->is('hospital/emergency/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('hospital/emergency/*')?'true':'false'}}"><i class="mdi mdi-ambulance"></i><span class="hide-menu"> Emergency</span></a>
                    <ul aria-expanded="{{ Request::is('hospital/emergency/*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('hospital/emergency/create')}}" class="{{ request()->is('hospital/emergency/create') ? 'active' : '' }}"><i class="mdi mdi-ambulance" style="font-size:16px"></i> Emergency Form</a></li>
                        <li><a href="{{url('hospital/emergency')}}" class="{{ request()->is('hospital/emergency') ? 'active' : '' }}"><i class="mdi mdi-view-list" style="font-size:16px"></i> Emergency List</a></li>
                        <li><a href="{{url('hospital/emergency/voided')}}" class="{{ request()->is('hospital/emergency/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-forever" style="font-size:16px"></i> Voided</a></li>
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

                <li class="{{ request()->is('hospital/operation/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('hospital/operation/*')?'true':'false'}}"><i class="mdi mdi-needle"></i><span class="hide-menu"> Operation</span></a>
                    <ul aria-expanded="{{ Request::is('hospital/operation/*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('hospital/operation/')}}" class="{{ request()->is('hospital/operation/') ? 'active' : '' }}"><i class="mdi mdi-needle" style="font-size:16px"></i> Operations</a></li>
                        <li><a href="{{url('hospital/operation/type')}}" class="{{ request()->is('hospital/operation/type/*') ? 'active' : '' }}"><i class="mdi mdi-heart-pulse" style="font-size:16px"></i> Types</a></li>
                        <li><a href="{{url('hospital/operation/service')}}" class="{{ request()->is('hospital/operation/service/*') ? 'active' : '' }}"><i class="mdi mdi-view-list" style="font-size:16px"></i> Services</a></li>
                        <li><a href="{{url('hospital/operation/voided')}}" class="{{ request()->is('hospital/operation/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-forever" style="font-size:16px"></i> Voided</a></li>
                    </ul>
                </li>

                {{-- <li class="{{ request()->is('appointment/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('appointment/*')?'true':'false'}}"><i class="mdi mdi-calendar-blank"></i><span class="hide-menu">Appointment</span></a>
                    <ul aria-expanded="{{ Request::is('appointment/*')?'true':'false'}}" class="collapse {{ Request::is('appointment/*')?'in':''}}">
                        <li><a href="{{url('appointment/')}}" class="{{ request()->is('appointment/') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Make Appointment </a></li>
                        <li><a href="{{url('appointment-list')}}" class="{{ request()->is('appointment-list') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Appointments</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('schedule/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('schedule/*')?'true':'false'}}"><i class="fa fa-clock-o"></i><span class="hide-menu">Doctor schedule</span></a>
                    <ul aria-expanded="{{ Request::is('schedule/*')?'true':'false'}}" class="collapse {{ Request::is('schedule/*')?'in':''}}">
                        <li><a href="{{url('schedule')}}" class="{{ request()->is('schedule/') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> New Schedule</a></li>
                        <li><a href="{{url('schedule')}}" class="{{ request()->is('schedule/*') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> Schedule</a></li>
                    </ul>
                </li>
                
                <li class="{{ request()->is('doctor/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('doctor/*')?'true':'false'}}"><i class="fa fa-user-md"></i><span class="hide-menu">Doctor</span></a>
                    <ul aria-expanded="{{ Request::is('schedule/*')?'true':'false'}}" class="collapse {{ Request::is('schedule/*')?'in':''}}">
                        <li><a href="{{url('doctor')}}" class="{{ request()->is('doctor/') ? 'active' : '' }}"><i class="fa fa-stethoscope"></i> Doctors</a></li>
                        <li><a href="{{url('doctor/create')}}" class="{{ request()->is('doctor/create/*') ? 'active' : '' }}"><i class="fa fa-user-md"></i> New Doctor</a></li> 
                    </ul>
                </li>  --}}

                <li class="{{ request()->is('hospital/beds/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('hospital/beds/*')?'true':'false'}}"><i class="mdi mdi-seat-flat"></i><span class="hide-menu"> Beds</span></a>
                    <ul aria-expanded="{{ Request::is('hospital/beds/*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('hospital/beds/bedtype')}}" class="{{ request()->is('hospital/beds/bedtype') ? 'active' : '' }}"><i class="mdi mdi-sofa" style="font-size:16px"></i> Bed Type</a></li>
                        <li><a href="{{url('hospital/beds/bed')}}" class="{{ request()->is('hospital/beds/bed') ? 'active' : '' }}"><i class="mdi mdi-seat-flat" style="font-size:16px"></i> Beds</a></li>
                        <li><a href="{{url('hospital/beds/bed/status')}}" class="{{ request()->is('hospital/beds/bed/status') ? 'active' : '' }}"><i class="mdi mdi-map-marker-radius" style="font-size:16px"></i> Bed Map</a></li>
                        <li><a href="{{url('hospital/bedcharge')}}" class="{{ request()->is('hospital/bedcharge') ? 'active' : '' }}"><i class="mdi mdi-content-paste" style="font-size:16px"></i> Bed Charge</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('hospital/services/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('hospital/services/*')?'true':'false'}}"><i class="mdi mdi-nutrition"></i><span class="hide-menu"> Services</span></a>
                    <ul aria-expanded="{{ Request::is('hospital/services/*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('hospital/services/servicecategory')}}" class="{{ request()->is('hospital/beds/bedtype') ? 'active' : '' }}"><i class="mdi mdi-palette" style="font-size:16px"></i> Service Category</a></li>
                        <li><a href="{{url('hospital/services/service')}}" class="{{ request()->is('hospital/services/service') ? 'active' : '' }}"><i class="mdi mdi-table-edit" style="font-size:16px"></i> Service</a></li>
                    </ul>
                </li>


                  <li class="{{ request()->is('departments/*') ? 'active' : '' }}">
                      <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('departments/*')?'true':'false'}}"><i class="mdi mdi-nutrition"></i><span class="hide-menu"> Doctor Departments</span></a>
                      <ul aria-expanded="{{ Request::is('departments*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                          <li><a href="{{url('departments')}}" class="{{ request()->is('departments') ? 'active' : '' }}"><i class="mdi mdi-palette" style="font-size:16px"></i> New Department</a></li>
                      </ul>
                  </li>


                <li class="{{ request()->is('patient/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('vendor*')?'true':'false'}}"><i class="mdi mdi-human-male-female"></i><span class="hide-menu"> Patients</span></a>
                    <ul aria-expanded="{{ Request::is('vendor*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('patient')}}" class="{{ request()->is('patient/*') && !request()->is('patient/create') ? 'active' : '' }}"><i class="mdi mdi-seat-flat-angled" style="font-size:16px"></i> Patients</a></li>
                        <li><a href="{{url('patient/create')}}" class="{{ request()->is('patient/create') ? 'active' : '' }}"><i class="fa fa fa-user-plus" style="font-size:16px"></i> New Patients</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('reports/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('reports/*')?'true':'false'}}"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Reports</span></a>
                    <ul aria-expanded="{{ Request::is('reports/*')?'true':'false'}}" class="collapse {{ Request::is('reports/*')?'in':''}}">
                        <li><a href="{{url('reports/hospital-today?start='.date('Y-m-d').'&end='.date('Y-m-d'))}}" class="{{ request()->is('reports/hospital-today') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Today's Report</a></li>
                        <li><a href="{{url('reports/expense?start='.date('Y-m-01').'&end='.date('Y-m-t').'&category=All')}}" class="{{ request()->is('reports/expense') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Expense Reports <sup class="newItem">New</sup></a></li>
                        <li><a href="{{url('reports/cash-flow?start='.date('Y-m-01').'&end='.date('Y-m-t').'&type=All')}}" class="{{ request()->is('reports/cash-flow') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Cash Flow</a></li>
                        <li><a href="{{url('reports/admission-report')}}" class="{{ request()->is('reports/admission-report') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Admission Today</a></li>
                        {{-- <li><a href="{{url('reports/admission-report')}}" class="{{ request()->is('reports/admission-report') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Emergency Today</a></li>
                        <li><a href="{{url('reports/admission-report')}}" class="{{ request()->is('reports/admission-report') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Operation Today</a></li>
                        <li><a href="{{url('reports/admission-report')}}" class="{{ request()->is('reports/admission-report') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Discharged Today</a></li>
                        <li><a href="{{url('reports/admission-report')}}" class="{{ request()->is('reports/admission-report') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Bed Service</a></li> --}}
                    </ul>
                </li>



                <li class="{{ request()->is('referral/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('referral/*')?'true':'false'}}"><i class="mdi mdi-transit-transfer"></i><span class="hide-menu">Manage Referral</span></a>
                    <ul aria-expanded="{{ Request::is('referral/*')?'true':'false'}}" class="collapse {{ Request::is('referral/*')?'in':''}}">
                        <li><a href="{{ url('referral/category') }}" class="{{ request()->is('referral/category') ? 'active' : '' }}"><i class="fa fa-user-plus"></i> Referral Category</a></li>
                        <li><a href="{{ url('referral/create') }}" class="{{ request()->is('referral/create') ? 'active' : '' }}"><i class="fa fa-user-plus"></i> New Referral</a></li>
                        <li><a href="{{ url('referral') }}" class="{{ request()->is('referral/*') && !request()->is('referral/create') ? 'active' : '' }}"><i class="mdi  mdi-transit-transfer"></i> Referrals</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('accounts/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}"><i class="mdi mdi-cash-usd"></i><span class="hide-menu">Accounts</span></a>
                    <ul aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}" class="collapse {{ Request::is('accounts/*')?'in':''}}">
                        {{-- <li><a href="{{url('accounts/transaction/receivepayment')}}" class="{{ request()->is('accounts/transaction/receivepayment') ? 'active' : '' }}"><i class="mdi mdi-cash-usd"></i> Due Collection</a></li> --}}
                        <li><a href="{{url('accounts/transaction/?start='.date('Y-m-01').'&end='.date('Y-m-t').'&type=All')}}" class="{{ request()->is('accounts/transaction') ? 'active' : '' }}"><i class="mdi mdi-file-document"></i> See Statement</a></li>
                        <li><a href="{{url('accounts/due')}}" class="{{ request()->is('accounts/due/*') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> Due Collection List</a></li>
                    </ul>
                </li>

                {{-- <li class="{{ request()->is('dues/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('dues/*')?'true':'false'}}"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Dues</span></a>
                    <ul aria-expanded="{{ Request::is('dues/*')?'true':'false'}}" class="collapse {{ Request::is('accounts/*')?'in':''}}">
                        <li><a href="{{url('dues/due')}}" class="{{ request()->is('dues/due/*') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> Collection List</a></li>
                    </ul>
                </li> --}}

                <li class="{{ request()->is('expense/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('bankaccount/*')?'true':'false'}}"><i class="mdi mdi-chart-scatterplot-hexbin"></i><span class="hide-menu">Expense</span></a>
                    <ul aria-expanded="{{ Request::is('expense/*')?'true':'false'}}" class="collapse {{ Request::is('expense/*')?'in':''}}">
                        <li><a href="{{url('expense/')}}" class="{{ request()->is('/expense/') ? 'active' : '' }}"><i class="mdi mdi-dns"></i> Manage Expenses</a></li>
                        <li><a href="{{url('expense/create')}}" class="{{ request()->is('/expense/create') ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> Add Expense</a></li>
                        <li><a href="{{url('expense/voided')}}" class="{{ request()->is('expense/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-forever" style="font-size:16px"></i> Voided</a></li>
                        <li class="{{ (Request::is('category/*'))?'active':''}}">
                            <a class="has-arrow" href="#" aria-expanded="{{ (Request::is('expenses/category/*')) ?'true':'false'}}"><i class="mdi mdi-lan"></i> Categories</a>
                            <ul aria-expanded="{{ (Request::is('category/*'))?'true':'false'}}" class="collapse {{ (Request::is('category/*') || Request::is('category/*'))?'in':''}}">
                                <li><a href="{{url('expenses/category/')}}" class="{{ request()->is('expenses/category/') ? 'active' : '' }}"><i class="mdi mdi-format-list-bulleted"></i> Manage Categories</a></li>
                                <li><a href="{{url('expenses/category/create')}}" class="{{ request()->is('expenses/category/create') ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> New Category</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
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
