  <nav class="navbar navbar-expand-md navbar-light" style="background-color: #b4c7d6">
        <!-- Brand Logo -->
        <a href="/" class="brand-link p-0">
        <!-- <p>{{AppSettings::get('app_name')}}</p> -->
            <img class="f_logo" src="/storage/{{AppSettings::get('logo')}}" alt="LOGO JMD" title="LOGO JMD">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown notifications-menu">
                    <a href="#" class="nav-link notifications-menu" data-toggle="dropdown">
                        <i class="far fa-bell"></i>
                        @php($alertsCount = \Auth::user()->userAlerts()->where('read', false)->count())
                        @if($alertsCount > 0)
                            <span class="badge badge-warning navbar-badge">
                                {{ $alertsCount }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        @if(count($alerts = \Auth::user()->userAlerts()->withPivot('read')->limit(10)->orderBy('created_at', 'ASC')->get()->reverse()) > 0)
                            @foreach($alerts as $alert)
                                <div class="dropdown-item">
                                  <a href="@if($alert->file)
                                    @foreach($alert->file as $key => $media)
                                        {{ $media->getUrl() }}
                                    @endforeach
                                @endif " target="_blank" rel="noopener noreferrer" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 
                                    @if($alert->pivot->read === 0) <strong> @endif
                                      {{ $alert->alert_text }}
                                    @if($alert->pivot->read === 0) </strong> @endif
                              </a> 
                                </div>
                            @endforeach
                        @else
                            <div class="text-center">
                                {{ trans('global.no_alerts') }}
                            </div>
                        @endif
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false" v-pre>
                      <img src="/storage/avatars/{{ Auth::user()->avatar }}" style="width:32px; height:32px; top:10px; left:10px; border-radius:50%">
                       {{ Auth::user()->name }} <span class="caret"></span> 
                    </a>
                  
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a href="{{url('admin/profile')}}" class="dropdown-item">Profile</a>
                      
                    <a href="{{route('auth.change_password')}}" class="dropdown-item">Change Password</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                      </a>
                  
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </div>
                  </li>
            </ul>
        </div>
    </nav>
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e4e4e4">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav">
        @can('admin_dashboard')
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <span>{{ trans('global.dashboard') }}</span>
                </a>
            </li>
        @endcan
        @can('members')
            <li class="nav-item">
                @if(auth()->user()->name == 'admin')
                    <a href="{{ route("admin.members.index") }}" class="nav-link {{ request()->is('admin/members') || request()->is('admin/members/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.members.title') }}</span>
                    </a>
                @else
                    <a href="{{ route("admin.members.index") }}?country_id={{auth()->user()->country}}"
                        class="nav-link {{ request()->is('admin/members') || request()->is('admin/members/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.members.title') }}</span>
                    </a>
                @endif
            </li>
        @endcan
        @can('invoice_access')
            <li class="nav-item">
                <a href="{{ route("admin.invoices.index") }}"
                    class="nav-link {{ request()->is('admin/invoices') || request()->is('admin/invoices/*') ? 'active' : '' }}">
                    <span>{{ trans('cruds.invoices.title') }}</span>
                </a>
            </li>
        @endcan
        @can('medical_info')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>{{ trans('cruds.userManagement.medical_info') }}</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @can('hospitals_access')
                    <a href="{{ route("admin.hospitals.index") }}"
                        class="dropdown-item {{ request()->is('admin/hospitals') || request()->is('admin/hospitals/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.hospitals.title') }}</span>
                    </a>
                @endcan
                @can('doctors_access')
                    <a href="{{ route("admin.doctors.index") }}"
                        class="dropdown-item {{ request()->is('admin/doctors') || request()->is('admin/doctors/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.doctors.title') }}</span>
                    </a>
                @endcan
                @can('medicals_access')
                    <a href="{{ route("admin.medicals.index") }}"
                        class="dropdown-item {{ request()->is('admin/medicals') || request()->is('admin/medicals/*') ? 'active' : '' }}">
                        <span>Diagnosis</span>
                    </a>
                @endcan
                @can('department_access')
                    <a href="{{ route("admin.departments.index") }}"
                        class="dropdown-item {{ request()->is('admin/departments') || request()->is('admin/departments/*') ? 'active' : '' }}">
                        {{ trans('cruds.department.title') }}
                    </a>
                @endcan
            </div>
        </li>
        @endcan
        @can('insurance_info')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>{{ trans('cruds.userManagement.insurance_info') }}</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @can('assistance_access')
                    <a href="{{ route("admin.assistances.index") }}"
                        class="dropdown-item {{ request()->is('admin/assistances') || request()->is('admin/assistances/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.assistance.title') }}</span>
                    </a>
                @endcan
                @can('insurance_access')
                    <a href="{{ route("admin.insurances.index") }}"
                        class="dropdown-item {{ request()->is('admin/insurances') || request()->is('admin/insurances/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.insurance.title') }}</span>
                    </a>
                @endcan
                @can('membership_access')
                    <a href="{{ route("admin.memberships.index") }}"
                        class="dropdown-item {{ request()->is('admin/memberships') || request()->is('admin/memberships/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.membership.title') }}</span>
                    </a>
                @endcan
                @can('local_insurance_access')
                    <a href="{{ route("admin.local-insurances.index") }}"
                        class="dropdown-item {{ request()->is('admin/local-insurances') || request()->is('admin/local-insurances/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.localInsurance.title') }}</span>
                    </a>
                @endcan
                @can('invoice_description_access')
                    <a href="{{ route("admin.invoice_descriptions.index") }}"
                        class="dropdown-item {{ request()->is('admin/invoice_descriptions') || request()->is('admin/invoice_descriptions/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.invoice_description.title') }}</span>
                    </a>
                @endcan
            </div>
        </li>
        @endcan
        @can('insurance_info')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>Reports</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @can('report_access')
                    <a href="{{route('admin.profit_reports')}}"
                        class="dropdown-item {{ request()->is('admin/assistances') || request()->is('admin/assistances/*') ? 'active' : '' }}">
                        <span>Profit / Loss Reports</span>
                    </a>
                    <a href="{{route('admin.yearly_profit_reports')}}"
                        class="dropdown-item {{ request()->is('admin/yearly_profit_reports') || request()->is('admin/yearly_profit_reports/*') ? 'active' : '' }}">
                        <span>Yearly P/L Reports</span>
                    </a>
                @endcan
            </div>
        </li>
        @endcan
        @can('fileshare')
            <li class="nav-item">
                <a href="{{ url("admin/fileshare") }}"
                    class="nav-link {{ request()->is('admin/fileshare') || request()->is('admin/fileshare/*') ? 'active' : '' }}">
                    <span>{{ trans('cruds.fileshare.title') }}</span>
                </a>
            </li>
        @endcan
        @can('exchanges_access')
            <li class="nav-item">
                <a href="{{ route("admin.exchanges.index") }}"
                    class="nav-link {{ request()->is('admin/exchanges') || request()->is('admin/exchanges/*') ? 'active' : '' }}">
                    <span>{{ trans('cruds.exchange.title') }}</span>
                </a>
            </li>
        @endcan
        @can('user_alert_access')
            <li class="nav-item">
                <a href="{{ route("admin.user-alerts.index") }}"
                    class="nav-link {{ request()->is('admin/user-alerts') || request()->is('admin/user-alerts/*') ? 'active' : '' }}">
                    <span>{{ trans('cruds.userAlert.title') }}</span>
                </a>
            </li>
        @endcan
        @can('claimstemplate_access')
            <li class="nav-item">
                <a href="{{ route("admin.claimstemplates.index") }}"
                    class="nav-link {{ request()->is('admin/claimstemplates') || request()->is('admin/claimstemplates/*') ? 'active' : '' }}">
                    <span>{{ trans('cruds.claimstemplate.title') }}</span>
                </a>
            </li>
        @endcan
        @can('user_management_access')
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>{{ trans('cruds.userManagement.title') }}</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @can('permission_access')
                    <a href="{{ route("admin.permissions.index") }}"
                        class="dropdown-item {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.permission.title') }}</span>
                    </a>
                @endcan
                @can('role_access')
                    <a href="{{ route("admin.roles.index") }}"
                        class="dropdown-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.role.title') }}</span>
                    </a>
                @endcan
                @can('user_access')
                    <a href="{{ route("admin.users.index") }}"
                        class="dropdown-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <span>{{ trans('cruds.user.title') }}</span>
                    </a>
                @endcan
            </div>
        </li>
        @endcan
        @can('setting')
            <li class="nav-item">
                <a href="{{ url("settings") }}"
                    class="nav-link {{ request()->is('/settings') || request()->is('/settings/*') ? 'active' : '' }}">
                    <span>{{ trans('cruds.setting.title') }}</span>
                </a>
            </li>
        @endcan
      </ul>
    </div>
  </nav>