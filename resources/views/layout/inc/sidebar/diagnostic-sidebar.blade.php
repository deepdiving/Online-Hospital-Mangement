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

                <li class="{{ request()->is('schedule/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('schedule/*')?'true':'false'}}"><i class="fa fa-clock-o"></i><span class="hide-menu">Doctor schedule</span></a>
                    <ul aria-expanded="{{ Request::is('schedule/*')?'true':'false'}}" class="collapse {{ Request::is('schedule/*')?'in':''}}">
                        <li><a href="{{url('schedule')}}" class="{{ request()->is('schedule/') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> New Schedule</a></li>
                            <li><a href="{{url('schedule/chart/')}}" class="{{ request()->is('schedule/chart/') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> Schedule Chart</a></li>
                    </ul>

                </li> 

                </li>

            <li class="{{ request()->is('patientlist/*') ? 'active' : '' }}">
                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('patientlist/*')?'true':'false'}}"><i class="fa fa-clock-o"></i><span class="hide-menu">Prescription List</span></a>
                <ul aria-expanded="{{ Request::is('schedule/*')?'true':'false'}}" class="collapse {{ Request::is('schedule/*')?'in':''}}">
                    <li><a href="{{url('diagon-prescription-list')}}" class="{{ request()->is('diagon-prescription-list/') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> Prescription List</a></li>
                </ul>
            </li>

                
                <li class="{{ request()->is('doctor/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('doctor/*')?'true':'false'}}"><i class="fa fa-user-md"></i><span class="hide-menu">Doctor</span></a>
                    <ul aria-expanded="{{ Request::is('schedule/*')?'true':'false'}}" class="collapse {{ Request::is('schedule/*')?'in':''}}">
                        <li><a href="{{url('doctor')}}" class="{{ request()->is('doctor/') ? 'active' : '' }}"><i class="fa fa-stethoscope"></i> Doctors</a></li>
                        <li><a href="{{url('doctor/create')}}" class="{{ request()->is('doctor/create/*') ? 'active' : '' }}"><i class="fa fa-user-md"></i> New Doctor</a></li> 
                    </ul>
                </li>  
                
                <li class="{{ request()->is('reports/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('reports/*')?'true':'false'}}"><i class="mdi mdi-chart-areaspline"></i><span class="hide-menu">Reports</span></a>
                    <ul aria-expanded="{{ Request::is('reports/*')?'true':'false'}}" class="collapse {{ Request::is('reports/*')?'in':''}}">
                        <li><a href="{{url('reports/diagnostic-today?start='.date('Y-m-d').'&end='.date('Y-m-d'))}}" class="{{ request()->is('reports/diagnostic-today') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Today's Report</a></li>
                        <li><a href="{{url('reports/expense?start='.date('Y-m-01').'&end='.date('Y-m-t').'&category=All')}}" class="{{ request()->is('reports/expense') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Expense Reports <sup class="newItem">New</sup></a></li>
                        <li><a href="{{url('reports/cash-flow?start='.date('Y-m-01').'&end='.date('Y-m-t').'&type=All')}}" class="{{ request()->is('reports/cash-flow') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Cash Flow</a></li>
                        <li><a href="{{url('reports/delivary-test')}}" class="{{ request()->is('reports/delivary-test') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Today's delivery</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('diagnostic/bill/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('diagnostic/bill/*')?'true':'false'}}"><i class="mdi mdi-newspaper"></i><span class="hide-menu"> Billing</span></a>
                    <ul aria-expanded="{{ Request::is('diagnostic/bill/*')?'true':'false'}}" class="collapse {{ Request::is('diagnostic/bill/*')?'in':''}}">
                        <li><a href="{{url('diagnostic/bill/create')}}" class="{{ request()->is('diagnostic/bill/create') ? 'active' : '' }}"><i class="mdi mdi-table-edit" style="font-size:16px"></i> New Bill</a></li>
                        <li><a href="{{url('diagnostic/bill')}}" class="{{ request()->is('diagnostic/bill') || request()->is('diagnostic/bill/invoice/*') ? 'active' : '' }}"><i class="fa fa-money" style="font-size:16px"></i> All Bills</a></li>
                        <li><a href="{{url('diagnostic/bill/voided')}}" class="{{  request()->is('diagnostic/bill/voided') ? 'active' : '' }}"><i class="mdi mdi-delete-variant" style="font-size:16px"></i> Void List</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('patient/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('vendor*')?'true':'false'}}"><i class="mdi mdi-seat-flat-angled"></i><span class="hide-menu"> Patients</span></a>
                    <ul aria-expanded="{{ Request::is('vendor*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('patient')}}" class="{{ request()->is('patient/*') && !request()->is('patient/create') ? 'active' : '' }}"><i class="mdi mdi-seat-recline-normal" style="font-size:16px"></i> Patients</a></li>
                        <li><a href="{{url('patient/create')}}" class="{{ request()->is('patient/create') ? 'active' : '' }}"><i class="mdi mdi-table-edit" style="font-size:16px"></i> New Patients</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('diagnostic/testlists/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('diagnostic/testlists/*')?'true':'false'}}"><i class="fa fa-stethoscope"></i><span class="hide-menu">Manage Tests</span></a>
                    <ul aria-expanded="{{ Request::is('diagnostic/testlists/*')?'true':'false'}}" class="collapse {{ Request::is('diagnostic/testlists/*')?'in':''}}">
                        <li><a href="{{ url('diagnostic/testlists') }}" class="{{ request()->is('diagnostic/testlists') ? 'active' : '' }}"><i class="fa fa-list"></i> Test List</a></li>
                        <li><a href="{{ url('diagnostic/categories') }}" class="{{ request()->is('diagnostic/categories') ? 'active' : '' }}"><i class="fa fa-list-alt"></i> Test Category</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('referral/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('referral/*')?'true':'false'}}"><i class="mdi mdi-transit-transfer"></i><span class="hide-menu">Manage Referral</span></a>
                    <ul aria-expanded="{{ Request::is('referral/*')?'true':'false'}}" class="collapse {{ Request::is('referral/*')?'in':''}}">
                        <li><a href="{{ url('referral/category') }}" class="{{ request()->is('referral/category') ? 'active' : '' }}"><i class="fa fa-user-plus"></i> Referral Category</a></li> 
                        <li><a href="{{ url('referral/create') }}" class="{{ request()->is('diagnostic/referrals/create') ? 'active' : '' }}"><i class="fa fa-user-plus"></i> New Referral</a></li>
                        <li><a href="{{ url('referral') }}" class="{{ request()->is('referral/') ? 'active' : '' }}"><i class="fa fa-address-card"></i> Referrals</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('accounts/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Accounts</span></a>
                    <ul aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}" class="collapse {{ Request::is('accounts/*')?'in':''}}">
                        <li><a href="{{url('accounts/transaction/receivepayment')}}" class="{{ request()->is('accounts/transaction/receivepayment') ? 'active' : '' }}"><i class="mdi mdi-cash-usd"></i> Due Collection</a></li>
                        <li><a href="{{url('accounts/transaction/?start='.date('Y-m-01').'&end='.date('Y-m-t').'&type=All')}}" class="{{ request()->is('accounts/transaction') ? 'active' : '' }}"><i class="mdi mdi-file-document"></i> See Statement</a></li>
                    </ul>
                </li>

                {{-- <li class="{{ request()->is('dues/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('dues/*')?'true':'false'}}"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Dues</span></a>
                    <ul aria-expanded="{{ Request::is('dues/*')?'true':'false'}}" class="collapse {{ Request::is('accounts/*')?'in':''}}">
                        <li><a href="{{url('dues/due')}}" class="{{ request()->is('dues/due/*') ? 'active' : '' }}"><i class="mdi mdi-cash-usd"></i> Dues</a></li>
                        <li><a href="{{url('dues/due/create')}}" class="{{ request()->is('dues/due/create') ? 'active' : '' }}"><i class="mdi mdi-file-document"></i> due Collection</a></li>
                    </ul>
                </li> --}}

                <li class="{{ request()->is('expense/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('bankaccount/*')?'true':'false'}}"><i class="mdi mdi-chart-scatterplot-hexbin"></i><span class="hide-menu">Expense</span></a>
                    <ul aria-expanded="{{ Request::is('expense/*')?'true':'false'}}" class="collapse {{ Request::is('expense/*')?'in':''}}">
                        <li><a href="{{url('expense/')}}" class="{{ request()->is('/expense/') ? 'active' : '' }}"><i class="mdi mdi-dns"></i> Manage Expenses</a></li>
                        <li><a href="{{url('expense/create')}}" class="{{ request()->is('/expense/create') ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> Add Expense</a></li>
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
