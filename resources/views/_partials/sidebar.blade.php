<ul class="sidebar-menu">

    @can('dashboard')
    <li class="menu">
        <a href="{!! url('/dashboard') !!}"><span class="icon">
            <i class="fa fa-hospital-o" ></i></span> <span class="text">Dashboard</span>
        </a>
    </li>
    @endcan


        @can('show-pharmacy-sales-menu')
            <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-h-square"></i></span>
                <span class="text">Sales Management </span><span class="arrow"></span>
            </a>
                <ul class=''>
                    <li><a href="{{ url('products/sales/create') }}">New Sales</a></li>
                    <li><a href="{{ url('products/sales') }}">All Sales</a></li>
                    {{--<li><a href="javascript:void(0);">Customer Opening Due</a></li>--}}
                    {{--<li><a href="javascript:void(0);">Sales Return</a></li>--}}
                </ul>
            </li>
        @endcan
        @can('show-pharmacy-purchase-menu')
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-h-square"></i></span>
                    <span class="text">Purchase Management </span><span class="arrow"></span>
                </a>
                <ul class=''>
                    <li><a href="{{ url('products/purchases/create') }}">Product Purchase</a></li>
                    <li><a href="{{ url('products/purchases') }}">All Purchase</a></li>
                    {{--                    <li><a href="{{ url('parties') }}">Party Information</a></li>--}}
                    {{--<li><a href="javascript:void(0);">Purchase Return</a></li>--}}
                </ul>
            </li>
        @endcan
        @can('show-pharmacy-menu')
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-h-square"></i></span>
                    <span class="text">Inventory Management </span><span class="arrow"></span>
                </a>
                <ul class=''>
                    @can('inventory-settings-create')
                        <li><a href="{{ url('products/create') }}">Create Product</a></li>
                    @endcan
                    @can('inventory-settings-list')
                        {{--<li><a href="{{ url('inventory-categories') }}">Product Categories</a></li>--}}
                        <li><a href="{{ url('categories') }}">Create Categories</a></li>
                        <li><a href="{{ url('products/codes') }}">Create Codes</a></li>
                        {{--<li><a href="{{ url('inventory-brands') }}">Create Manufacturer</a></li>--}}
                        <li><a href="{{ url('manufacturers') }}">Create Manufacturer</a></li>
                        <li><a href="{{ url('barcodes') }}">Create Barcodes</a></li>
{{--                        <li><a href="{{ url('inventory-units') }}">Unit Management</a></li>--}}
                    @endcan
                </ul>
            </li>
        @endcan

    {{--Account And Finance--}}
{{--    @can('show-voucher-menu')--}}
    <li class="submenu">
        <a href="javascript:void(0);">
            <span class="icon"><i class="fa fa-money"></i></span>
            <span class="text">Accounts & Finance</span><span class="arrow"></span>
        </a>

        <ul class=''>
            <li><a href="{{ url('accounts-dashboard') }}">Dashboard</a></li>
            @can('debit-voucher-create')
                <li><a href="{{ url('debit-vouchers/create') }}">Debit Voucher (Expense)</a></li>
            @endcan
            @can('credit-voucher-create')
                <li><a href="{{ url('credit-vouchers/create') }}">Credit Voucher (Income)</a></li>
            @endcan
            @can('advance-voucher-create')
            <li><a href="{{ url('advance-payment-vouchers/create') }}">Advance Payment Voucher</a></li>
            @endcan

            @can('installments-list')
            <li><a href="{{ url('installments') }}">Installments</a></li>
            @endcan

            <li class="submenu"><a href="javascript:void(0);">Petty Cash<span class="arrow"></span></a>
                <ul class=''>
                    @can('petty-cash-voucher-create')
                        <li><a href="{{ url('petty-cash-vouchers/create') }}">Petty Cash (Expense)</a></li>
                    @endcan
                    @can('petty-cash-deposit-create')
                        <li><a href="{{ url('petty-cash-deposits') }}">Petty Cash Deposit</a></li>
                    @endcan
                    <li><a href="{{ url('petty-cash-charts') }}">Petty Cash Charts</a></li>
                </ul>
            </li>


            @can('show-balance-transfer-menu')
                @can('balance-transfer-create')
                <li><a href="{{ url('balance-transfers/create') }}">Fund Management </a></li>
                @endcan
            @endcan
            @can('party-list')
            <li><a href="{{ url('parties') }}">Vendor / Supplier</a></li>
            @endcan

            @can('account-settings-list')
            <li class="submenu"><a href="javascript:void(0);">Accounts Configuration<span class="arrow"></span></a>
                <ul class=''>
                    <li><a href="{{ url('chart-of-accounts') }}">Chart of Accounts</a></li>
                    <li><a href="{{ url('payment-methods') }}">Set Payment Method</a></li>
                    <li><a href="{{ url('accounts') }}">Account Name</a></li>
                </ul>
            </li>
            @endcan
        </ul>
    </li>
    {{--Reports--}}
    @can('reports-show')
    <li class="submenu">
        <a href="javascript:void(0);">
            <span class="icon"><i class="fa fa-file-archive-o"></i></span>
            <span class="text">MIS Reports </span><span class="arrow"></span>
        </a>

        <ul class=''>
            <li class="submenu"><a href="javascript:void(0);">Accounts<span class="arrow"></span></a>
                <ul class=''>
                    <li><a href="{{ url('reports/accounts/income-expense') }}">Income-Expense</a></li>
                    <li><a href="{{ url('reports/accounts/petty-cash') }}">Petty Cash</a></li>
                    <li><a href="{{ url('reports/accounts/cash-collections') }}">Cash Collections</a></li>
                    <li><a href="{{ url('reports/accounts/daily-cash-receives') }}">Daily Cash Received</a></li>
                </ul>
            </li>
        </ul>
        @can('inventory-settings-list')
            <ul>
                <li class="submenu"><a href="javascript:void(0);">Pharmacy<span class="arrow"></span></a>
                    <ul class=''>
                        <li><a href="{{ url('reports/pharmacy/sales/product-wise') }}">Sales Report (Product Wise)
                            </a></li>
                        <li><a href="{{ url('/reports/pharmacy/sales/customer-wise') }}">Sales Report (Customer Wise)
                            </a></li>

                        <li><a href="{{ url('/reports/pharmacy/purchase/product-wise') }}">Purchase Report (Product
                                Wise)</a></li>
                        <li><a href="{{ url('/reports/pharmacy/inventory') }}">Inventory Report</a></li>
                        <li><a href="{{ url('reports/pharmacy/inventory/stock-alert') }}">Stock Alert Report</a></li>
                    </ul>
                </li>
            </ul>
        @endcaN

    </li>
    @endcan

    {{--CRM--}}
    @can('show-crm-menu')
        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
                <span class="text">CRM </span><span class="arrow"></span>
            </a>

            <ul class=''>
                @can('task-create')
                    <li class="submenu"><a href="{{url('tasks/create')}}">Create Task</a></li>
                @endcan
                @can('task-list')
                    <li class="submenu"><a href="{{url('tasks')}}">My Task</a></li>
                @endcan
            </ul>

            <ul class=''>
                {{--@can('show-sms-group-menu')--}}
                {{--<li class="submenu"><a href="javascript:void(0);">SMS Configuration<span class="arrow"></span></a>--}}
                {{--<ul class=''>--}}
                {{--@can('sms-group-list')--}}
                {{--<li><a href="{{ url('sms-group') }}">Group SMS</a></li>--}}
                {{--@endcan--}}
                {{--<li><a href="{{ url('manage-sms') }}">Send SMS</a></li>--}}
                {{--@can('sms-template-list')--}}
                {{--<li><a href="{{ url('sms-template') }}">SMS Template</a></li>--}}
                {{--@endcan--}}
                {{--</ul>--}}
                {{--</li>--}}
                {{--@endcan--}}

            </ul>
        </li>
    @endcan
    {{--Settings--}}
    <li class="submenu">
        <a href="javascript:void(0);">
            <span class="icon"><i class="fa fa-cogs"></i></span>
            <span class="text">Settings </span><span class="arrow"></span>
        </a>

        <ul class=''>
            @can('show-system-config-menu')
            <li class="submenu"><a href="javascript:void(0);">System Configuration<span class="arrow"></span></a>
                <ul class=''>
                    {{--@can('company-list')--}}
                    {{--<li><a href="{{ url('companies') }}">Company Configuration</a></li>--}}
                    {{--@endcan--}}
                    <li><a href="{{ url('system-configs') }}">Configs</a></li>
                    <li><a href="{{ url('clear-cache') }}">Cache Clear</a></li>
                    <li><a href="{{ url('others-info/login') }}">Home Description</a></li>
                </ul>
            </li>
            @endcan
            @can('show-user-menu')
            <li class="submenu"><a href="javascript:void(0);">Users<span class="arrow"></span></a>
                <ul class=''>
                    @can('user-list')
                    <li><a href="{{ url('users') }}">Users Setting</a></li>
                    @endcan
                    <li><a href="{{ url('roles') }}">User Permission</a></li>
                </ul>
            </li>
            @endcan
            @can('terms-condition-list')
            <li><a href="{{ url('terms-condition') }}">Terms & Conditions</a></li>
            @endcan
            {{--<li class="submenu"><a href="javascript:void(0);">CRM<span class="arrow"></span></a>--}}
                {{--<ul class=''>--}}
                    {{--<li><a href="{{ url('task-type') }}">Task Type</a></li>--}}
                {{--</ul>--}}
            {{--</li>--}}
        </ul>
    </li>




    {{--MY Profile--}}
    <li class="submenu">
        <a href="javascript:void(0);">
            <span class="icon"><i class="fa fa-user"></i></span>
            <span class="text">My Profile </span><span class="arrow"></span>
        </a>

        <ul class=''>
            <li class="submenu"><a href="{{url('profile')}}">My Profile</a></li>
        </ul>
    </li>
</ul>
