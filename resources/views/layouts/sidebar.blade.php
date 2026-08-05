<style>
  .layout-menu-collapsed:not(.layout-menu-hover) .app-brand-logo img {
    width: 35px;
    object-fit: cover;
    object-position: left;
    transition: width 0.3s ease;
  }
  .app-brand-logo img {
    transition: width 0.3s ease;
    /* max-width is set inline, width auto will keep its native aspect ratio */
  }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="" class="app-brand-link">
      <span class="app-brand-logo demo" style="overflow: hidden;">
        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="BHC Logo" style="max-height: 45px;">
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block custom-toggle">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1"> 
    <!-- dashboard -->
    <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
      <a href="{{ route('home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Basic">Dashboard</div>
      </a>
    </li>
    <!-- Extended Pengaturan -->
    @canany(['users-list', 'role-list'])
    <li class="menu-item {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active open' : '' }}">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Extended UI">Settings</div>
      </a>
      <ul class="menu-sub">
        @can('users-list')
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
          <a href="{{ route('users.index') }}" class="menu-link">
            <div data-i18n="Perfect Scrollbar">User Management</div>
          </a>
        </li>
        @endcan
        @can('role-list')
        <li class="menu-item {{ request()->routeIs('roles.*') ? 'active open' : '' }}">
          <a href="{{ route('roles.index') }}" class="menu-link">
            <div data-i18n="Text Divider">Role Management</div>
          </a>
        </li>
        @endcan
      </ul>
    </li>
    @endcanany
    <!-- Master Data -->
    @canany(['division-list', 'complaint_type-list'])
    <li class="menu-item {{ request()->routeIs('divisions.*') || request()->routeIs('complaint_types.*') ? 'active open' : '' }}">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cylinder"></i>
        <div data-i18n="Extended UI">Master Data</div>
      </a>
      <ul class="menu-sub">
        @can('division-list')
        <li class="menu-item {{ request()->routeIs('divisions.*') ? 'active' : '' }}">
          <a href="{{ route('divisions.index') }}" class="menu-link">
            <div data-i18n="Perfect Scrollbar">Division</div>
          </a>
        </li>
        @endcan
        @can('complaint_type-list')
        <li class="menu-item {{ request()->routeIs('complaint_types.*') ? 'active' : '' }}">
          <a href="{{ route('complaint_types.index') }}" class="menu-link">
            <div data-i18n="Text Divider">Complaint Type</div>
          </a>
        </li>
        @endcan
      </ul>
    </li>
    @endcanany
    <!-- User interface -->
    <li class="menu-item">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-box"></i>
        <div data-i18n="User interface">User interface</div>
      </a>
    </li>
  </ul>
</aside>
