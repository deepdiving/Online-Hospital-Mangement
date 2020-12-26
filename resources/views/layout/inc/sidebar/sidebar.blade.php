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
                @if(Sentinel::hasAccess('report-management'))
                    <li class="{{ request()->is('reports/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('reports/*')?'true':'false'}}"><i class="mdi mdi-chart-areaspline"></i><span class="hide-menu">Reports</span></a>
                        <ul aria-expanded="{{ Request::is('reports/*')?'true':'false'}}" class="collapse {{ Request::is('reports/*')?'in':''}}">
                            @if(Sentinel::hasAccess('report-today'))
                            <li><a href="{{url('reports/today?start='.date('Y-m-d').'&end='.date('Y-m-d'))}}" class="{{ request()->is('reports/today') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Today's Report</a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-income-statement'))
                            <li><a href="{{url('reports/income-statement?start='.date('Y-01-01').'&end='.date('Y-12-t'))}}" class="{{ request()->is('reports/income-statement') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Income Statement</a></li>
                            @endif

                            @if(Sentinel::hasAccess('report-p&l'))
                            <li class="{{ Request::is('reports/p&l/*')?'active':''}}">
                                <a class="has-arrow" href="#" aria-expanded="{{ Request::is('reports/p&l/*')?'true':'false'}}"><i class="mdi mdi-content-duplicate"></i> Profit & Loss</a>
                                <ul aria-expanded="{{ Request::is('reports/p&l/*')?'true':'false'}}" class="collapse {{ Request::is('reports/p&l/*')?'in':''}}">
                                    <li><a href="{{url('reports/p&l/salewise')}}" class="{{ (Request::is('reports/p&l/salewise')) ?'active':''}}"><i class="mdi mdi-content-duplicate"></i> Sale Wise</a></li>
                                    <li><a href="{{url('reports/p&l/itemwise')}}" class="{{ (Request::is('reports/p&l/itemwise')) ?'active':''}}"><i class="mdi mdi-content-duplicate"></i> Item Wise</a></li>
                                </ul>
                            </li>
                            @endif
                            @if(Sentinel::hasAccess('report-sale'))
                                <li><a href="{{url('reports/sales?start='.date('Y-m-01').'&end='.date('Y-m-t').'&customer=All')}}" class="{{ request()->is('reports/sales') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Sales Reports <sup class="newItem">New</sup></a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-sales-return'))
                                <li><a href="{{url('reports/sales-return?start='.date('Y-m-01').'&end='.date('Y-m-t').'&customer=All')}}" class="{{ request()->is('reports/sales-return') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Sales Returns <sup class="newItem">New</sup></a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-purchase'))
                                <li><a href="{{url('reports/purchase?start='.date('Y-m-01').'&end='.date('Y-m-t').'&manufacturer=All')}}" class="{{ request()->is('reports/purchase') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Purchase Reports</a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-purchase-return'))
                                <li><a href="{{url('reports/purchase-return?start='.date('Y-m-01').'&end='.date('Y-m-t').'&manufacturer=All')}}" class="{{ request()->is('reports/purchase-return') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Purchase Returns</a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-expense'))
                                <li><a href="{{url('reports/expense?start='.date('Y-m-01').'&end='.date('Y-m-t').'&category=All')}}" class="{{ request()->is('reports/expense') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Expense Reports <sup class="newItem">New</sup></a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-payments'))
                                <li><a href="{{url('reports/payment?start='.date('Y-m-01').'&end='.date('Y-m-t').'&manufacturer=All')}}" class="{{ request()->is('reports/payment') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Supplier Payments</a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-received'))
                                <li><a href="{{url('reports/received?start='.date('Y-m-01').'&end='.date('Y-m-t').'&customer=All')}}" class="{{ request()->is('reports/received') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Cash On Sales</a></li>
                            @endif
                            @if(Sentinel::hasAccess('report-cash-flow'))
                                <li><a href="{{url('reports/cash-flow?start='.date('Y-m-01').'&end='.date('Y-m-t').'&type=All')}}" class="{{ request()->is('reports/cash-flow') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Cash Flow</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('sale-management'))
                    <li class="{{ request()->is('sale/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('sale*')?'true':'false'}}"><i class="mdi mdi-scale-balance"></i><span class="hide-menu"> Sales</span></a>
                        <ul aria-expanded="{{ Request::is('sale*')?'true':'false'}}" class="collapse {{ Request::is('sale*')?'in':''}}">
                            {{-- @if(Sentinel::hasAccess('sale-create'))
                            <li><a href="{{url('sale/pos')}}" class="{{ request()->is('/sale/*') ? 'active' : '' }}"><i class="mdi mdi-barcode-scan"></i> POS</a></li>
                            @endif --}}
                            @if(Sentinel::hasAccess('sale-create'))
                            <li><a href="{{url('sale/create')}}" class="{{ request()->is('/sale/*') ? 'active' : '' }}"><i class="mdi mdi-scale"></i> New Sale</a></li>
                            @endif
                            {{-- @if(Sentinel::hasAccess('sale-index')) --}}
                            <li><a href="{{url('sale')}}" class="{{ request()->is('sale') || request()->is('sale/invoice/*') ? 'active' : '' }}"><i class="mdi mdi-chart-timeline"></i> Sales List</a></li>
                            {{-- @endif --}}
                            @if(Sentinel::hasAccess('saleReturn-index'))
                            <li><a href="{{url('sale/saleReturn')}}" class="{{ request()->is('sale/saleReturn/*') || request()->is('sale/return/*')  ? 'active' : '' }}"><i class="mdi mdi-keyboard-return"></i> Manage Returns</a></li>
                            @endif
                            @if(Sentinel::hasAccess('saleReturn-index'))
                            <li><a href="{{url('sale/voided')}}" class="{{ request()->is('/sale/voided/*') ? 'active' : '' }}"><i class="mdi mdi-delete-variant"></i> Voided List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('customer-index') || Sentinel::hasAccess('manufacturer-index'))
                    <li class="{{ request()->is('manufacturers/*') || request()->is('customer/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('vendor*')?'true':'false'}}"><i class="mdi mdi-account-multiple-outline"></i><span class="hide-menu">Vendors</span></a>
                        <ul aria-expanded="{{ Request::is('vendor*')?'true':'false'}}" class="collapse {{ Request::is('vendor*')?'in':''}}">
                            @if(Sentinel::hasAccess('customer-index'))
                                <li><a href="{{url('customer')}}" class="{{ request()->is('customer/*') ? 'active' : '' }}"><i class="fa fa-handshake-o" style="font-size:16px"></i> Customers</a></li>
                            @endif
                            @if(Sentinel::hasAccess('manufacturer-index'))
                                <li><a href="{{url('manufacturers/manufacturer')}}" class="{{ request()->is('manufacturers/*') ? 'active' : '' }}"><i class="icon-user"></i> Manufacturers</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('product-management'))
                    <li class="{{ request()->is('products/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('products*')?'true':'false'}}"><i class="fa fa-medkit" style="font-size:17px"></i><span class="hide-menu"> Manage Items</span></a>
                        <ul aria-expanded="{{ Request::is('products*')?'true':'false'}}" class="collapse {{ Request::is('products*')?'in':''}}">
                            @if(Sentinel::hasAccess('product-index'))
                                <li><a href="{{url('products/product')}}" class="{{ request()->is('products/product/*') ? 'active' : '' }}"><i class="mdi mdi-pill"></i> Manage Medicines</a></li>
                            @endif
                            @if(Sentinel::hasAccess('category-index'))
                                <li><a href="{{url('products/category')}}" class="{{ request()->is('products/category/*') ? 'active' : '' }}"><i class="mdi mdi-format-list-bulleted-type"></i> Manage Categories</a></li>
                            @endif
                            @if(Sentinel::hasAccess('type-index'))
                                <li><a href="{{url('products/type')}}" class="{{ request()->is('products/type/*') ? 'active' : '' }}"><i class="mdi mdi-format-list-bulleted-type"></i> Manage Types</a></li>
                            @endif
                            @if(Sentinel::hasAccess('unit-index'))
                                <li><a href="{{url('products/unit')}}" class="{{ request()->is('products/unit/*') ? 'active' : '' }}"><i class="mdi mdi-google-circles-extended"></i> Manage Units</a></li>
                            @endif
                            {{-- @if(Sentinel::hasAccess('tax-index'))
                                <li><a href="{{url('products/tax')}}" class="{{ request()->is('products/tax/*') ? 'active' : '' }}"><i class="mdi mdi-percent"></i> Manage Taxes</a></li></li>
                            @endif --}}
                            @if(Sentinel::hasAccess('product-export-import'))
                                <li><a href="{{url('products/export-import')}}" class="{{ request()->is('products/export-import/*') ? 'active' : '' }}"><i class="mdi mdi-repeat"></i> Export/Import</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('purchase-management'))
                    <li class="{{ request()->is('purchase/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('purchase*')?'true':'false'}}"><i class="mdi mdi-ambulance"></i><span class="hide-menu"> Purchases</span></a>
                        <ul aria-expanded="{{ Request::is('purchase*')?'true':'false'}}" class="collapse {{ Request::is('purchase*')?'in':''}}">
                            @if(Sentinel::hasAccess('purchase-create'))
                                @if(Sentinel::hasAccess('purchase-create'))
                                    <li><a href="{{url('purchase/create')}}" class="{{ request()->is('/purchase/*') ? 'active' : '' }}"><i class="mdi mdi-cart-plus"></i> New Purchase</a></li>
                                @endif
                                @if(Sentinel::hasAccess('purchase-index'))
                                    <li><a href="{{url('purchase')}}" class="{{ request()->is('purchase') || request()->is('purchase/invoice/*') ? 'active' : '' }}"><i class="mdi mdi-chart-timeline"></i> Purchase List</a></li>
                                @endif
                                @if(Sentinel::hasAccess('purchaseReturn-index'))
                                    <li><a href="{{url('purchase/purchaseReturn')}}" class="{{ request()->is('/purchase/purchaseReturn/*') || request()->is('purchase/return/*') ? 'active' : '' }}"><i class="mdi mdi-keyboard-return"></i> Manage Returns</a></li>
                                @endif
                                @if(Sentinel::hasAccess('purchase-index'))
                                    <li><a href="{{url('purchase/voided')}}" class="{{ request()->is('/purchase/voided/*') ? 'active' : '' }}"><i class="mdi mdi-delete-variant"></i> Voided List</a></li>
                                @endif
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('stock-management'))
                    <li class="{{ request()->is('stocks/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('stocks/*')?'true':'false'}}"><i class="mdi mdi-chart-pie"></i><span class="hide-menu">Stocks</span></a>
                        <ul aria-expanded="{{ Request::is('stocks/*')?'true':'false'}}" class="collapse {{ Request::is('stocks/*')?'in':''}}">
                            @if(Sentinel::hasAccess('stock-low'))
                                <li><a href="{{url('stocks/lowstock')}}" class="{{ request()->is('stocks/lowstock') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Low Stocks </a></li>
                            @endif
                            @if(Sentinel::hasAccess('stock-expiry'))
                                <li><a href="{{url('stocks/expiry?expiry=upcoming')}}" class="{{ request()->is('stocks/expiry') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Expiry Stock</a></li>
                            @endif
                            @if(Sentinel::hasAccess('stock-closing'))
                                <li><a href="{{url('stocks/closing')}}" class="{{ request()->is('stocks/closing') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Closing Stock</a></li>
                            @endif
                            @if(Sentinel::hasAccess('stock-batch'))
                                <li><a href="{{url('stocks/batch')}}" class="{{ request()->is('stocks/batch') ? 'active' : '' }}"><i class="mdi mdi-content-duplicate"></i> Batch Stock</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('account-management'))
                    <li class="{{ request()->is('accounts/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}"><i class="mdi mdi-cash-multiple"></i><span class="hide-menu">Accounts</span></a>
                        <ul aria-expanded="{{ Request::is('accounts/*')?'true':'false'}}" class="collapse {{ Request::is('accounts/*')?'in':''}}">
                            @if(Sentinel::hasAccess('bankaccount-create'))
                                @if(Sentinel::hasAccess('bankaccount-create'))
                                    <li><a href="{{url('accounts/transaction/makepayment')}}" class="{{ request()->is('accounts/transaction/makepayment') ? 'active' : '' }}"><i class="mdi mdi-cash-usd"></i> Supplier Payment</a></li>
                                @endif
                                @if(Sentinel::hasAccess('bankaccount-create'))
                                    <li><a href="{{url('accounts/transaction/receivepayment')}}" class="{{ request()->is('accounts/transaction/receivepayment') ? 'active' : '' }}"><i class="mdi mdi-cash-usd"></i> Due Collection</a></li>
                                @endif
                                @if(Sentinel::hasAccess('transaction-index'))
                                    <li><a href="{{url('accounts/transaction/?start='.date('Y-m-01').'&end='.date('Y-m-t').'&type=All')}}" class="{{ request()->is('accounts/transaction') ? 'active' : '' }}"><i class="mdi mdi-file-document"></i> See Statement</a></li>
                                @endif
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('expense-management'))
                    <li class="{{ request()->is('expense/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('bankaccount/*')?'true':'false'}}"><i class="mdi mdi-chart-scatterplot-hexbin"></i><span class="hide-menu">Expense</span></a>
                        <ul aria-expanded="{{ Request::is('expense/*')?'true':'false'}}" class="collapse {{ Request::is('expense/*')?'in':''}}">
                            @if(Sentinel::hasAccess('expense-index'))
                            <li><a href="{{url('expense/')}}" class="{{ request()->is('/expense/') ? 'active' : '' }}"><i class="mdi mdi-dns"></i> Manage Expenses</a></li>
                            @endif
                            @if(Sentinel::hasAccess('expense-create'))
                                <li><a href="{{url('expense/create')}}" class="{{ request()->is('/expense/create') ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> Add Expense</a></li>
                            @endif
                            @if(Sentinel::hasAccess('expenseCategory-index'))
                                <li class="{{ (Request::is('category/*'))?'active':''}}">
                                    <a class="has-arrow" href="#" aria-expanded="{{ (Request::is('expenses/category/*')) ?'true':'false'}}"><i class="mdi mdi-lan"></i> Categories</a>
                                    <ul aria-expanded="{{ (Request::is('category/*'))?'true':'false'}}" class="collapse {{ (Request::is('category/*') || Request::is('category/*'))?'in':''}}">
                                        @if(Sentinel::hasAccess('expenseCategory-index'))
                                            <li><a href="{{url('expenses/category/')}}" class="{{ request()->is('expenses/category/') ? 'active' : '' }}"><i class="mdi mdi-format-list-bulleted"></i> Manage Categories</a></li>
                                        @endif
                                        @if(Sentinel::hasAccess('expenseCategory-create'))
                                            <li><a href="{{url('expenses/category/create')}}" class="{{ request()->is('expenses/category/create') ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> New Category</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('tax-management'))
                    <li class="{{ request()->is('taxes*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('taxes*')?'true':'false'}}"><i class="mdi mdi-ticket-percent"></i><span class="hide-menu">Taxes</span></a>
                        <ul aria-expanded="{{ Request::is('taxes*')?'true':'false'}}" class="collapse {{ Request::is('taxes*')?'in':''}}">
                            @if(Sentinel::hasAccess('tax-index'))
                            <li><a href="{{url('taxes/')}}" class="{{ request()->is('taxes') ? 'active' : '' }}"><i class="mdi mdi-dns"></i> Tax List</a></li>
                            @endif
                            @if(Sentinel::hasAccess('tax-pay'))
                                <li><a href="{{url('taxes/payment')}}" class="{{ request()->is('taxes/payment') ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> Pay Tax</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Sentinel::hasAccess('bank-management'))
                    <li class="{{ request()->is('bankaccount/*') ? 'active' : '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('bankaccount/*')?'true':'false'}}"><i class="mdi mdi-bank"></i><span class="hide-menu">{{trans_choice('messages.bank_account',10)}}</span></a>
                        <ul aria-expanded="{{ Request::is('bankaccount/*')?'true':'false'}}" class="collapse {{ Request::is('bankaccount/*')?'in':''}}">
                            @if(Sentinel::hasAccess('bankaccount-create'))
                                <li><a href="{{url('bankaccount/create')}}" class="{{ request()->is('/bankaccount/*') ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> {{__('messages.new_bank_account')}}</a></li>
                            @endif
                            @if(Sentinel::hasAccess('bankaccount-create'))
                                <li><a href="{{url('bankaccount')}}" class="{{ request()->is('bankaccount') || request()->is('bankaccount/invoice/*') ? 'active' : '' }}"><i class="mdi mdi-view-list"></i> {{__('messages.manage_account')}} </a></li>
                            @endif
                            @if(Sentinel::hasAccess('bankTransaction-create'))
                                <li><a href="{{url('bankaccount/transaction/create')}}" class="{{ request()->is('bankaccount/transaction/create')  ? 'active' : '' }}"><i class="mdi mdi-open-in-new"></i> {{__('messages.make_transaction')}}</a></li>
                            @endif
                            @if(Sentinel::hasAccess('bankTransaction-index'))
                                <li><a href="{{url('bankaccount/transaction/')}}" class="{{ request()->is('bankaccount/transaction/') ? 'active' : '' }}"><i class="mdi mdi-file-document-box"></i> {{trans_choice('messages.bank_transaction',10)}}</a></li>
                            @endif
                        </ul>
                    </li>
                @endif 
                @if(Sentinel::hasAccess('user-management'))
                <hr class="hide-menu hr-borderd">
                    <li class="{{ Request::is('users/*')?'active':''}}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('users/*')?'true':'false'}}"><i class="mdi mdi-account-settings-variant"></i><span class="hide-menu">User Management</span></a>
                        <ul aria-expanded="{{ Request::is('users/*')?'true':'false'}}" class="collapse {{ Request::is('users/*')?'in':''}}">
                            @if(Sentinel::hasAccess('user-menu'))
                            <li class="{{ Request::is('users/*/edit') && !Request::is('users/role/*')?'active':''}}">
                                <a class="has-arrow" href="#" aria-expanded="{{ Request::is('users/*/edit') && !Request::is('users/role/*')?'true':'false'}}"><i class="mdi mdi-account-multiple"></i> Manage User</a>
                                <ul aria-expanded="{{ Request::is('users/*/edit') && !Request::is('users/role/*')?'true':'false'}}" class="collapse {{ Request::is('users/*/edit') && !Request::is('users/role/*')?'in':''}}">
                                    @if(Sentinel::hasAccess('user-index'))
                                    <li><a href="{{url('users')}}" class="{{ (Request::is('users/*/edit') && !Request::is('users/create')) && !Request::is('users/role/*')?'active':''}}"><i class="mdi mdi-library-books"></i> User List</a></li>
                                    @endif
                                    @if(Sentinel::hasAccess('user-add'))
                                    <li><a href="{{url('users/create')}}"><i class="mdi mdi-open-in-new"> </i> New User</a></li>
                                    @endif
                                    @if(Sentinel::hasAccess('activities'))
                                    <li><a href="{{url('users/activities')}}"><i class="mdi mdi-run-fast"></i> Users Activities</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            
                            @if(Sentinel::hasAccess('role-menu'))
                            <li class="{{ Request::is('users/role/*')?'active':''}}">
                                <a class="has-arrow" href="#" aria-expanded="{{ Request::is('users/role/*')?'true':'false'}}"><i class="mdi mdi-human-greeting"></i> Manage Roles</a>
                                <ul aria-expanded="false" class="collapse {{ Request::is('users/role/*')?'in':''}}">
                                    @if(Sentinel::hasAccess('role-index'))
                                    <li><a href="{{url('users/roles')}}" class="{{ (Request::is('users/role/*') && !Request::is('users/role/create'))?'active':''}}"><i class="mdi mdi-library-books"></i> Roles List</a></li>
                                    @endif
                                    @if(Sentinel::hasAccess('role-add'))
                                    <li>
                                        <a href="{{route('createRole')}}" class="{{ Request::is('createRole')?'active':''}}"> <i class="mdi mdi-open-in-new"> </i> Add New</a>
                                    </li>
                                    @endif

                                </ul>
                            </li>
                            @endif 

                            @if(Sentinel::hasAccess('permission-menu'))
                            <li class="{{ Request::is('users/permission/*')?'active':''}}">
                                <a class="has-arrow" href="#" aria-expanded="{{Request::is('users/permission/*')?'true':'false'}}}}"><i class="mdi mdi-key"></i> Permissions</a>
                                <ul aria-expanded="false" class="collapse {{Request::is('users/permission/*')?'in':''}}}}">
                                    @if(Sentinel::hasAccess('permission-index'))
                                    <li><a href="{{url('users/permissions')}}" class="{{ (Request::is('users/permission/*') && !Request::is('users/permission/create') ) ?'active':''}}"><i class="mdi mdi-library-books"></i> Permission List</a></li>
                                    @endif
                                    @if(Sentinel::hasAccess('permission-add'))
                                    <li>
                                        <a href="{{url('users/permission/create')}}" class="{{ Request::is('users/permission/create')?'active':''}}"> <i class="mdi mdi-open-in-new"> </i> Add New</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            @if(Sentinel::hasAccess('notifacation'))
                            <li>
                                <a href="{{url('users/notification')}}"><i class="mdi mdi-alarm-multiple"></i> Notifications</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif 
                @if(Pharma::isAdmin())
                    <li class="{{ Request::is('settings/*')?'active':''}}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('settings/*')?'true':'false'}}"><i class="fa fa-cogs" style="font-size:17px"></i><span class="hide-menu">Settings</span></a>
                        <ul aria-expanded="{{ (Request::is('settings/siteSetting/*') || Request::is('settings/siteSetting/*'))?'true':'false'}}" class="collapse {{ (Request::is('settings/siteSetting/*') || Request::is('settings/siteSetting/*'))?'in':''}}">
                            <li><a href="{{url('settings/system-setting/general')}}" class="{{ request()->is('settings/system-setting/general') ? 'active' : '' }}"><i class="mdi mdi-settings-box"></i> General Setting</a></li>
                            <li><a href="{{url('settings/system-setting/site')}}" class="{{ request()->is('settings/system-setting/site') ? 'active' : '' }}"><i class="mdi mdi-wrench"></i> System Setting</a></li>
                        </ul>                            
                    </li>

                    <li class="{{ Request::is('emailtemplate/*')?'active':''}}">
                       <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ (Request::is('emailtemplate/*') || Request::is('mailbox/*'))?'true':'false'}}"><i class="mdi mdi-email-variant"></i><span class="hide-menu"> Emails </span></a>
                        <ul aria-expanded="{{ (Request::is('emailtemplate/*') || Request::is('mailbox/*'))?'true':'false'}}" class="collapse {{ (Request::is('emailtemplate/*') || Request::is('mailbox/*'))?'in':''}}">
                            <li><a href="{{url('emailtemplate')}}" class="{{ request()->is('emailtemplate/*') ? 'active' : '' }}"><i class="mdi mdi-library-books"></i> Email Templates</a></li>
                            <li><a href="{{url('mailbox')}}" class="{{ request()->is('mailbox/*') ? 'active' : '' }}"><i class="mdi mdi-email-open-outline"></i> Mailbox</a></li>
                        </ul>                           
                    </li>
                    
                    {{-- <li class="{{ Request::is('*')?'active':''}}">
                        <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="{{ Request::is('settings/*')?'true':'false'}}"><i class="mdi mdi-settings"></i><span class="hide-menu">Settings</span></a>
                        <ul aria-expanded="{{ Request::is('settings/*')?'true':'false'}}" class="collapse {{ Request::is('settings/*')?'in':''}}">
                            <li class="{{ (Request::is('settings/emailtemplate/*') || Request::is('settings/mailbox/*'))?'active':''}}">
                                <a class="has-arrow" href="#" aria-expanded="{{ (Request::is('settings/emailtemplate/*') || Request::is('settings/mailbox/*'))?'true':'false'}}"><i class="mdi mdi-email-variant"></i> Emails</a>
                                <ul aria-expanded="{{ (Request::is('settings/emailtemplate/*') || Request::is('settings/mailbox/*'))?'true':'false'}}" class="collapse {{ (Request::is('settings/emailtemplate/*') || Request::is('settings/mailbox/*'))?'in':''}}">
                                    <li><a href="{{url('settings/emailtemplate')}}" class="{{ request()->is('settings/emailtemplate/*') ? 'active' : '' }}"><i class="mdi mdi-cards-variant"></i> Email Templates</a></li>
                                    <li><a href="{{url('settings/mailbox')}}" class="{{ request()->is('settings/mailbox/*') ? 'active' : '' }}"><i class="mdi mdi-email-open-outline"></i> Mailbox</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}
                @endif
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