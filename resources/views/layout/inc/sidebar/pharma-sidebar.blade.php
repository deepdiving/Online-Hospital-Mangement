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
                <li class="{{ request()->is('reports/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('reports/*')?'true':'false'}}"><i class="mdi mdi-chart-areaspline"></i><span class="hide-menu">Reports</span></a>
                    <ul aria-expanded="{{ Request::is('reports/*')?'true':'false'}}" class="collapse {{ Request::is('reports/*')?'in':''}}">
                        <li class="{{ Request::is('reports/p&l/*')?'active':''}}">
                            <a class="has-arrow" href="#" aria-expanded="{{ Request::is('reports/p&l/*')?'true':'false'}}"><i class="mdi mdi-content-duplicate"></i> Profit & Loss</a>
                            <ul aria-expanded="{{ Request::is('reports/p&l/*')?'true':'false'}}" class="collapse {{ Request::is('reports/p&l/*')?'in':''}}">
                                <li><a href="{{url('reports/p&l/salewise')}}" class="{{ (Request::is('reports/p&l/salewise')) ?'active':''}}"><i class="mdi mdi-content-duplicate"></i> Sale Wise</a></li>
                                <li><a href="{{url('reports/p&l/itemwise')}}" class="{{ (Request::is('reports/p&l/itemwise')) ?'active':''}}"><i class="mdi mdi-content-duplicate"></i> Item Wise</a></li>
                            </ul>
                        </li>
                        <li><a href="{{url('reports/sales?start='.date('Y-m-01').'&end='.date('Y-m-t').'&customer=All')}}" class="{{ request()->is('reports/sales') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Sales Reports <sup class="newItem">New</sup></a></li>
                        <li><a href="{{url('reports/purchase?start='.date('Y-m-01').'&end='.date('Y-m-t').'&manufacturer=All')}}" class="{{ request()->is('reports/purchase') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Purchase Reports</a></li>
                        <li><a href="{{url('reports/expense?start='.date('Y-m-01').'&end='.date('Y-m-t').'&category=All')}}" class="{{ request()->is('reports/expense') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Expense Reports <sup class="newItem">New</sup></a></li>
                        <li><a href="{{url('reports/payment?start='.date('Y-m-01').'&end='.date('Y-m-t').'&manufacturer=All')}}" class="{{ request()->is('reports/payment') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Supplier Payments</a></li>
                        <li><a href="{{url('reports/received?start='.date('Y-m-01').'&end='.date('Y-m-t').'&customer=All')}}" class="{{ request()->is('reports/received') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Cash On Sales</a></li>
                    </ul>
                </li>
                <li class="{{ request()->is('sale/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('sale*')?'true':'false'}}"><i class="mdi mdi-scale-balance"></i><span class="hide-menu"> Sales</span></a>
                    <ul aria-expanded="{{ Request::is('sale*')?'true':'false'}}" class="collapse {{ Request::is('sale*')?'in':''}}">
                        <li><a href="{{url('sale/create')}}" class="{{ request()->is('/sale/*') ? 'active' : '' }}"><i class="mdi mdi-scale"></i> New Sale</a></li>
                        <li><a href="{{url('sale')}}" class="{{ request()->is('sale') || request()->is('sale/invoice/*') ? 'active' : '' }}"><i class="mdi mdi-chart-timeline"></i> Sales List</a></li>
                        <li><a href="{{url('sale/voided')}}" class="{{ request()->is('/sale/voided/*') ? 'active' : '' }}"><i class="mdi mdi-delete-variant"></i> Voided List</a></li>
                    </ul>
                </li>
        
                <li class="{{ request()->is('patient/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('vendor*')?'true':'false'}}"><i class="mdi mdi-seat-flat-angled"></i><span class="hide-menu"> Patients</span></a>
                    <ul aria-expanded="{{ Request::is('vendor*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                        <li><a href="{{url('patient')}}" class="{{ request()->is('patient/*') && !request()->is('patient/create') ? 'active' : '' }}"><i class="mdi mdi-seat-recline-normal" style="font-size:16px"></i> Patients</a></li>
                        <li><a href="{{url('patient/create')}}" class="{{ request()->is('patient/create') ? 'active' : '' }}"><i class="mdi mdi-table-edit" style="font-size:16px"></i> New Patients</a></li>
                    </ul>
                </li>
        
                <li class="{{ request()->is('products/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('products*')?'true':'false'}}"><i class="fa fa-medkit" style="font-size:17px"></i><span class="hide-menu"> Manage Products</span></a>
                    <ul aria-expanded="{{ Request::is('products*')?'true':'false'}}" class="collapse {{ Request::is('products*')?'in':''}}">
                        <li><a href="{{url('products/product')}}" class="{{ request()->is('products/product/*') ? 'active' : '' }}"><i class="mdi mdi-pill"></i> Manage Medicines</a></li>
                        <li><a href="{{url('products/category')}}" class="{{ request()->is('products/category/*') ? 'active' : '' }}"><i class="mdi mdi-format-list-bulleted-type"></i> Manage Categories</a></li>
                        <li><a href="{{url('products/type')}}" class="{{ request()->is('products/type/*') ? 'active' : '' }}"><i class="mdi mdi-format-list-bulleted-type"></i> Manage Types</a></li>
                        <li><a href="{{url('products/unit')}}" class="{{ request()->is('products/unit/*') ? 'active' : '' }}"><i class="mdi mdi-google-circles-extended"></i> Manage Units</a></li>
                        <li><a href="{{url('products/export-import')}}" class="{{ request()->is('products/export-import/*') ? 'active' : '' }}"><i class="mdi mdi-repeat"></i> Export/Import</a></li>
                    </ul>
                </li>
        
                <li class="{{ request()->is('purchase/*') || request()->is('manufacturers/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('purchase*')?'true':'false'}}"><i class="mdi mdi-ambulance"></i><span class="hide-menu"> Purchases</span></a>
                    <ul aria-expanded="{{ Request::is('purchase*')?'true':'false'}}" class="collapse {{ Request::is('purchase*')?'in':''}}">
                        <li><a href="{{url('purchase/create')}}" class="{{ request()->is('/purchase/*') ? 'active' : '' }}"><i class="mdi mdi-cart-plus"></i> New Purchase</a></li>
                        <li><a href="{{url('purchase')}}" class="{{ request()->is('purchase') || request()->is('purchase/invoice/*') ? 'active' : '' }}"><i class="mdi mdi-chart-timeline"></i> Purchase List</a></li>
                        <li><a href="{{url('purchase/voided')}}" class="{{ request()->is('/purchase/voided/*') ? 'active' : '' }}"><i class="mdi mdi-delete-variant"></i> Voided List</a></li>
                        <li><a href="{{url('manufacturers/manufacturer')}}" class="{{ request()->is('manufacturers/*') ? 'active' : '' }}"><i class="icon-user"></i> Manufacturers</a></li>
                    </ul>
                </li>
        
                <li class="{{ request()->is('stocks/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('stocks/*')?'true':'false'}}"><i class="mdi mdi-chart-pie"></i><span class="hide-menu">Stocks</span></a>
                    <ul aria-expanded="{{ Request::is('stocks/*')?'true':'false'}}" class="collapse {{ Request::is('stocks/*')?'in':''}}">
                        <li><a href="{{url('stocks/lowstock')}}" class="{{ request()->is('stocks/lowstock') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Low Stocks </a></li>
                        <li><a href="{{url('stocks/expiry?expiry=upcoming')}}" class="{{ request()->is('stocks/expiry') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Expiry Stock</a></li>
                        <li><a href="{{url('stocks/closing')}}" class="{{ request()->is('stocks/closing') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Closing Stock</a></li>
                        <li><a href="{{url('stocks/batch')}}" class="{{ request()->is('stocks/batch') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Batch Stock</a></li>
                    </ul>
                </li>
        
                <li class="{{ request()->is('accounts/*') ? 'active' : '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Accounts</span></a>
                    <ul aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}" class="collapse {{ Request::is('accounts/*')?'in':''}}">
                        <li><a href="{{url('accounts/transaction/makepayment')}}" class="{{ request()->is('accounts/transaction/makepayment') ? 'active' : '' }}"><i class="mdi mdi-cash-usd"></i> Supplier Payment</a></li>
                        <li><a href="{{url('accounts/transaction/receivepayment')}}" class="{{ request()->is('accounts/transaction/receivepayment') ? 'active' : '' }}"><i class="mdi mdi-cash-usd"></i> Due Collection</a></li>
                        <li><a href="{{url('accounts/transaction/?start='.date('Y-m-01').'&end='.date('Y-m-t').'&type=All')}}" class="{{ request()->is('accounts/transaction') ? 'active' : '' }}"><i class="mdi mdi-file-document"></i> See Statement</a></li>
                    </ul>
                </li>
        
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