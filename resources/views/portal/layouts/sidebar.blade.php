<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('assets/admin_lte/dist/img/avatar6.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ session()->get('user_username') }}</p>
                <a href="#">Role: {{ session()->get('user_role') }}</a>
            </div>
        </div>


        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            @if(session()->get('user_role') == 'user')
                <li class="treeview {{ ($is_active == 'create_schedule' || $is_active=='schedule_history' ||$is_active == 'purchase_history' || $is_active == 'schedule_report' || $is_active == 'purchase_pack') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-opencart text-aqua"></i> <span>OBD</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $is_active == 'purchase_pack' ? 'active' : '' }}"><a href="{{ route('pack.purchase') }}"><i class="fa fa-shopping-bag"></i> Buy Packs</a></li>
                        <li class="{{ $is_active == 'purchase_history' ? 'active' : '' }}"><a href="{{ route('pack.history') }}"><i class="fa fa-history"></i> OBD pack purchase History</a></li>
                        <li class="{{ $is_active == 'create_schedule' ? 'active' : '' }}"><a href="{{ route('schedule.create') }}"><i class="fa fa-calculator"></i>Schedule OBD</a></li>
                        <li class="{{ $is_active == 'schedule_history' ? 'active' : '' }}"><a href="{{ route('schedule.history') }}"><i class="fa fa-calendar-check-o"></i>Schedule History</a></li>
                        <li class="{{ $is_active == 'schedule_report' ? 'active' : '' }}"><a href="{{ route('schedule.report') }}"><i class="fa fa-database"></i>OBD Report</a></li>
                    </ul>
                </li>

                <li class="treeview {{ ($is_active == 'create_sms_schedule' || $is_active == 'sms_schedule_list' || $is_active == 'purchase_sms' || $is_active == 'sms_purchase_history' ) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-telegram text-aqua"></i> <span>Push SMS</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $is_active == 'purchase_sms' ? 'active' : '' }}"><a href="{{ route('sms.purchase') }}"><i class="fa fa-cart-plus"></i> Buy Push SMS Package</a></li>
                        <li class="{{ $is_active == 'sms_purchase_history' ? 'active' : '' }}"><a href="{{ route('sms.purchase.history') }}"><i class="fa fa-life-saver text-aqua"></i> <span>Push SMS Pack Purchase History</span></a></li>
                        <li class="{{ $is_active == 'create_sms_schedule' ? 'active' : '' }}"><a href="{{ route('sms.schedule.create') }}"><i class="fa fa-credit-card text-aqua"></i> <span>Push SMS Schedule</span></a></li>
                        <li class="{{ $is_active == 'sms_schedule_list' ? 'active' : '' }}"><a href="{{ route('sms.schedule.list.user') }}"><i class="fa fa-line-chart text-aqua"></i> <span>Push SMS Schedule History</span></a></li>
                    </ul>
                </li>
                <li class="treeview {{ ($is_active == 'create_web_api_schedule' || $is_active == 'web_api_schedule_list' || $is_active == 'purchase_web_api' || $is_active== 'web_api_purchase_history' ) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-apple text-aqua"></i> <span>Web API</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $is_active == 'purchase_web_api' ? 'active' : '' }}"><a href="{{ route('web.api.purchase') }}"><i class="fa fa-cart-arrow-down"></i> Buy Web API Package</a></li>
                        <li class="{{ $is_active == 'web_api_purchase_history' ? 'active' : '' }}"><a href="{{ route('web.api.purchase.history') }}"><i class="fa fa-hand-paper-o text-aqua"></i> <span>Web API Purchase History</span></a></li>
                        <li class="{{ $is_active == 'create_web_api_schedule' ? 'active' : '' }}"><a href="{{ route('web.api.schedule.create') }}"><i class="fa fa-stack-exchange text-aqua"></i> <span>Schedule  Web API</span></a></li>
                        <li class="{{ $is_active == 'web_api_schedule_list' ? 'active' : '' }}"><a href="{{ route('web.api.schedule.list.user') }}"><i class="fa fa-deaf text-aqua"></i> <span>Schedule Web API History</span></a></li>
                    </ul>
                </li>

            <li class="treeview {{ ($is_active == 'ticket_create' || $is_active == 'ticket_list_self') ? 'active' : '' }}">
                <a href="#">
                <i class="fa fa-ticket text-aqua"></i> <span>Issue A Ticket</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                <li class="{{ $is_active == 'ticket_create' ? 'active' : '' }}"><a href="{{ route('ticket.create') }}"><i class="fa fa-plus text-aqua"></i> <span>Create Ticket</span></a></li>
                <li class="{{ $is_active == 'ticket_list_self' ? 'active' : '' }}"><a href="{{ route('ticket.list.self') }}"><i class="fa fa-list text-aqua"></i> <span>My Tickets</span></a></li>
                </ul>
            </li>
            <li class="{{ $is_active == 'faq' ? 'active' : '' }}"><a href="{{ route('faq') }}"><i class="fa fa-question-circle text-aqua"></i> <span>FAQ</span></a></li>
            @endif
            @if(session()->get('user_role') == 'admin')
                <li class="treeview {{ ($is_active == 'clip_list' || $is_active == 'pack_create' ||  $is_active == 'pack_list'  || $is_active == 'schedule_list' || $is_active == 'clip_create' || $is_active == 'clip_edit') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-music text-aqua"></i> <span>OBD</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $is_active == 'schedule_list' ? 'active' : '' }}"><a href="{{ route('schedule.list') }}"><i class="fa fa-neuter"></i> Schedule List </a></li>
                        <li class="{{ $is_active == 'clip_create' ? 'active' : '' }}"><a href="{{ route('clip.create') }}"><i class="fa fa-star-o"></i> Create OBD Clip</a></li>
                        <li class="{{ $is_active == 'clip_list' ? 'active' : '' }}"><a href="{{ route('clip.list') }}"><i class="fa fa-stack-exchange"></i> OBD Clip List</a></li>
                        <li class="{{ $is_active == 'pack_create' ? 'active' : '' }}"><a href="{{ route('pack.create') }}"><i class="fa fa-bug"></i> Create OBD pack</a></li>
                        <li class="{{ $is_active == 'pack_list' ? 'active' : '' }}"><a href="{{ route('pack.list') }}"><i class="fa fa-recycle"></i> OBD pack List</a></li>
                    </ul>
                </li>
            <li class="{{ $is_active == 'ticket_list' || $is_active == 'ticket_edit' ? 'active' : '' }}"><a href="{{ route('ticket.list') }}"><i class="fa fa-ticket text-aqua"></i> <span>Ticket List</span></a></li>
            <li class="{{ $is_active == 'user_list' ? 'active' : '' }}"><a href="{{ route('user.list') }}"><i class="fa fa-users text-aqua"></i> <span>User List</span></a></li>
            <li class="treeview {{ ($is_active == 'category_list' || $is_active == 'category_create' || $is_active == 'category_edit') ? 'active' : '' }}">
                <a href="#">
                <i class="fa fa-th-large text-aqua"></i> <span>Category</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                <li class="{{ $is_active == 'category_create' ? 'active' : '' }}"><a href="{{ route('category.create') }}"><i class="fa fa-tags"></i> Create Category</a></li>
                <li class="{{ $is_active == 'category_list' ? 'active' : '' }}"><a href="{{ route('category.list') }}"><i class="fa fa-stack-exchange"></i> Category List</a></li>
                </ul>
            </li>

                <li class="treeview {{ ($is_active == 'sms_text_list' || $is_active == 'sms_text_create' || $is_active == 'sms_text_edit' || $is_active== 'sms_schedule_list' || $is_active=='sms_create' || $is_active=='sms_list' || $is_active=='sms_edit' ) ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-whatsapp text-aqua"></i> <span>Push SMS</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $is_active == 'sms_schedule_list' ? 'active' : '' }}"><a href="{{ route('sms.schedule.list') }}"><i class="fa fa-calendar text-aqua"></i> <span> SMS Schedule List</span></a></li>
                        <li class="{{ $is_active == 'sms_create' ? 'active' : '' }}"><a href="{{ route('portal.sms.create') }}"><i class="fa fa-star-half-empty"></i> Create SMS Package</a></li>
                        <li class="{{ $is_active == 'sms_list' ? 'active' : '' }}"><a href="{{ route('portal.sms.list') }}"><i class="fa fa-hacker-news"></i> SMS Package List</a></li>
                        <li class="{{ $is_active == 'sms.text_create' ? 'active' : '' }}"><a href="{{ route('sms.text.create') }}"><i class="fa fa-battery-full"></i> Create SMS Text</a></li>
                        <li class="{{ $is_active == 'sms.text_list' ? 'active' : '' }}"><a href="{{ route('sms.text.list') }}"><i class="fa fa-wechat"></i> SMS Text List</a></li>
                    </ul>
                </li>

                <li class="treeview {{ ($is_active == 'web_api_list' || $is_active == 'web_api_create' || $is_active == 'web_api_edit' || $is_active== 'web_api_schedule_list') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-bullhorn text-aqua"></i> <span>Web API Package</span>
                        <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ $is_active == 'web_api_schedule_list' ? 'active' : '' }}"><a href="{{ route('web.api.schedule.list') }}"><i class="fa fa-calendar-check-o"></i>Web API Schedule List</a></li>
                        <li class="{{ $is_active == 'web_api_create' ? 'active' : '' }}"><a href="{{ route('web.api.create') }}"><i class="fa fa-star"></i> Create Web API pack</a></li>
                        <li class="{{ $is_active == 'web_api_list' ? 'active' : '' }}"><a href="{{ route('web.api.list') }}"><i class="fa fa-bar-chart"></i> Web API pack List</a></li>
                    </ul>
                </li>

            <li class="treeview {{ ($is_active == 'admin_list' || $is_active == 'admin_create' || $is_active == 'admin_edit') ? 'active' : '' }}">
                <a href="#">
                <i class="fa fa-user text-aqua"></i> <span>Admin</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                <li class="{{ $is_active == 'admin_create' ? 'active' : '' }}"><a href="{{ route('admin.create') }}"><i class="fa fa-circle-o"></i> Create Admin User</a></li>
                <li class="{{ $is_active == 'admin_list' ? 'active' : '' }}"><a href="{{ route('admin.list') }}"><i class="fa fa-circle-o"></i> Admin User List</a></li>
                </ul>
            </li>
            @endif
        </ul>


    </section>
    <!-- /.sidebar -->
</aside>
