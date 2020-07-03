<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link card">
    <!-- <p>{{AppSettings::get('app_name')}}</p> -->
     <img class="f_logo" src="/storage/{{AppSettings::get('logo')}}" alt="LOGO JMD" title="LOGO JMD" bgcolor="#fff">
    </a>
    <!-- Sidebar -->
    <div class="sidebar myautoscroll">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @can('admin_dashboard')
                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" class="nav-link">
                        <p>
                            <i class="fas fa-fw fa-tachometer-alt">
                
                            </i>
                            <span>{{ trans('global.dashboard') }}</span>
                        </p>
                    </a>
                </li>
                @endcan
                @can('members')
                <li class="nav-item">
                    @if(auth()->user()->name == 'admin')
                        <a href="{{ route("admin.members.index") }}"
                            class="nav-link {{ request()->is('admin/members') || request()->is('admin/members/*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <p>
                                <span>{{ trans('cruds.members.title') }}</span>
                            </p>
                        </a>
                    @else
                        <a href="{{ route("admin.members.index") }}?country_id={{auth()->user()->country}}"
                            class="nav-link {{ request()->is('admin/members') || request()->is('admin/members/*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <p>
                                <span>{{ trans('cruds.members.title') }}</span>
                            </p>
                        </a>
                    @endif
                </li>
                @endcan
                @can('invoice_access')
                <li class="nav-item">
                    <a href="{{ route("admin.invoices.index") }}"
                        class="nav-link {{ request()->is('admin/invoices') || request()->is('admin/invoices/*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <p>
                            <span>{{ trans('cruds.invoices.title') }}</span>
                        </p>
                    </a>
                </li>
                @endcan
               
                
                @can('medical_info')
                <li
                    class="nav-item has-treeview {{ request()->is('admin/hospitals*') ? 'menu-open' : '' }} {{ request()->is('admin/doctors*') ? 'menu-open' : '' }} {{ request()->is('admin/medicals*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-file-medical"></i>
                        <p>
                            <span>{{ trans('cruds.userManagement.medical_info') }}</span>
                            <i class="right fa fa-fw fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('hospitals_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.hospitals.index") }}"
                                class="nav-link {{ request()->is('admin/hospitals') || request()->is('admin/hospitals/*') ? 'active' : '' }}">
                                <i class="fas fa-hospital"></i>
                                <p>
                                    <span>{{ trans('cruds.hospitals.title') }}</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                
                        @can('doctors_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.doctors.index") }}"
                                class="nav-link {{ request()->is('admin/doctors') || request()->is('admin/doctors/*') ? 'active' : '' }}">
                                <i class="fas fa-user-md"></i>
                                <p>
                                    <span>{{ trans('cruds.doctors.title') }}</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                
                        @can('medicals_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.medicals.index") }}"
                                class="nav-link {{ request()->is('admin/medicals') || request()->is('admin/medicals/*') ? 'active' : '' }}">
                                <i class="fas fa-briefcase-medical"></i>
                                <p>
                                    <span>Diagnosis</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('department_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.departments.index") }}" class="nav-link {{ request()->is('admin/departments') || request()->is('admin/departments/*') ? 'active' : '' }}">
                                <i class=" fas fa-hospital"></i>
                                <p>
                                    {{ trans('cruds.department.title') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                    </ul>
                </li>
                @endcan
                @can('insurance_info')
                <li
                    class="nav-item has-treeview {{ request()->is('admin/assistances*') ? 'menu-open' : '' }} {{ request()->is('admin/insurances*') ? 'menu-open' : '' }} {{ request()->is('admin/user-insurances*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-briefcase"></i>
                        <p>
                            <span>{{ trans('cruds.userManagement.insurance_info') }}</span>
                            <i class="right fa fa-fw fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('assistance_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.assistances.index") }}"
                                class="nav-link {{ request()->is('admin/assistances') || request()->is('admin/assistances/*') ? 'active' : '' }}">
                                <i class="fas fa-hands-helping"></i>
                                <p>
                                    <span>{{ trans('cruds.assistance.title') }}</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('insurance_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.insurances.index") }}"
                                class="nav-link {{ request()->is('admin/insurances') || request()->is('admin/insurances/*') ? 'active' : '' }}">
                                <i class="fas fa-building"></i>
                                <p>
                                    <span>{{ trans('cruds.insurance.title') }}</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route("admin.memberships.index") }}"
                                class="nav-link {{ request()->is('admin/memberships') || request()->is('admin/memberships/*') ? 'active' : '' }}">
                                <i class="fas fa-hands-helping"></i>
                                <p>
                                    <span>{{ trans('cruds.membership.title') }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.local-insurances.index") }}"
                                class="nav-link {{ request()->is('admin/local-insurances') || request()->is('admin/local-insurances/*') ? 'active' : '' }}">
                                <i class="fas fa-building"></i>
                                <p>
                                    <span>{{ trans('cruds.localInsurance.title') }}</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route("admin.invoice_descriptions.index") }}"
                                class="nav-link {{ request()->is('admin/invoice_descriptions') || request()->is('admin/invoice_descriptions/*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt"></i>
                                <p>
                                    <span>{{ trans('cruds.invoice_description.title') }}</span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
                @can('insurance_info')
                <li
                    class="nav-item has-treeview {{ request()->is('admin/profit_reports*') ? 'menu-open' : '' }} {{ request()->is('admin/yearly_profit_reports*') ? 'menu-open' : '' }} {{ request()->is('admin/user-insurances*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fas fa-file-export"></i>
                        <p>
                            <span>Reports</span>
                            <i class="right fa fa-fw fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('report_access')
                        <li class="nav-item">
                            <a href="{{route('admin.profit_reports')}}"class="nav-link {{ request()->is('admin/profit_reports') || request()->is('admin/profit_reports/*') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice"></i>
                                <p>
                                    <span>Profit / Loss Reports</span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.yearly_profit_reports').'?desk_id=1'}}" class="nav-link {{ request()->is('admin/yearly_profit_reports') || request()->is('admin/yearly_profit_reports/*') ? 'active' : '' }}">
                                <i class="fas fa-file-invoice"></i>
                                <p>
                                    <span>Yearly P/L Reports</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                
                @can('fileshare')
                <li class="nav-item">
                    <a href="{{ url("admin/fileshare") }}"
                        class="nav-link {{ request()->is('admin/fileshare') || request()->is('admin/fileshare/*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <p>
                            <span>{{ trans('cruds.fileshare.title') }}</span>
                        </p>
                    </a>
                </li>
                @endcan
                {{-- @can('news_access')
                <li class="nav-item">
                    <a href="{{ route("admin.news.index") }}"
                        class="nav-link {{ request()->is('admin/news') || request()->is('admin/news/*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i>
                        <p>
                            <span>{{ trans('cruds.news.title') }}</span>
                        </p>
                    </a>
                </li>
                @endcan --}}

                @can('exchanges_access')
                <li class="nav-item">
                    <a href="{{ route("admin.exchanges.index") }}"
                        class="nav-link {{ request()->is('admin/exchanges') || request()->is('admin/exchanges/*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i>
                        <p>
                            <span>{{ trans('cruds.exchange.title') }}</span>
                        </p>
                    </a>
                </li>
                @endcan
                @can('user_alert_access')
                <li class="nav-item">
                <a href="{{ route("admin.user-alerts.index") }}" class="nav-link " class="{{ request()->is('admin/user-alerts') || request()->is('admin/user-alerts/*') ? 'active' : '' }} nav-item">
                   <i class="fa-fw fas fa-bell"></i>
                   <p><span>{{ trans('cruds.userAlert.title') }}</span></p>
                        
                </a>
                </li>
            @endcan
            {{-- @can('messages_access')
             @php($unread = \App\QaTopic::unreadCount())
             <li class="nav-item">
                <a class="nav-link " href="{{ route("admin.messenger.index") }}" class="{{ request()->is('admin/messenger') || request()->is('admin/messenger/*') ? 'active' : '' }}">
                   <i class="fa-fw fa fa-envelope"></i>
                     <p>
                        <span>{{ trans('global.messages') }}</span>
                        @if($unread > 0)
                            <strong>( {{ $unread }} )</strong>
                        @endif
                       </p> 
                    </a>
                </li>
               @endcan --}}
               

                @can('claimstemplate_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.claimstemplates.index") }}" class="nav-link {{ request()->is('admin/claimstemplates') || request()->is('admin/claimstemplates/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-cogs">

                            </i>
                            <p>
                                <span>{{ trans('cruds.claimstemplate.title') }}</span>
                            </p>
                        </a>
                @endcan
                @can('user_management_access')
                <li
                    class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }}">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users">
                
                        </i>
                        <p>
                            <span>{{ trans('cruds.userManagement.title') }}</span>
                            <i class="right fa fa-fw fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('permission_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.permissions.index") }}"
                                class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt">
                
                                </i>
                                <p>
                                    <span>{{ trans('cruds.permission.title') }}</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('role_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.roles.index") }}"
                                class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase"></i>
                                <p>
                                    <span>{{ trans('cruds.role.title') }}</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                        @can('user_access')
                        <li class="nav-item">
                            <a href="{{ route("admin.users.index") }}"
                                class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-user">
                
                                </i>
                                <p>
                                    <span>{{ trans('cruds.user.title') }}</span>
                                </p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
               
                
                @can('setting')
                <li class="nav-item">
                     <a href="{{ url("settings") }}"
                         class="nav-link {{ request()->is('/settings') || request()->is('/settings/*') ? 'active' : '' }}">
                         <i class="fas fa-cogs"></i>
                         <p>
                             <span>{{ trans('cruds.setting.title') }}</span>
                         </p>
                     </a>
                 </li> 
                 @endcan
                  <li class="nav-item">
                    <a href="{{ route('auth.change_password') }}" class="nav-link">
                        <i class="fas fa-fw fa-key">
                        </i>
                        <p>
                            <span>Change password</span>
                        </p>
                        
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt">

                            </i>
                            <span>{{ trans('global.logout') }}</span>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>