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
    <!-- Master Data -->
    @canany(['question-list'])
    <li class="menu-item {{ request()->routeIs('questions.*') ? 'active open' : '' }}">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cylinder"></i>
        <div data-i18n="Master Data">Master Data</div>
      </a>
      <ul class="menu-sub">
        @can('question-list')
        <li class="menu-item {{ request()->routeIs('questions.*') ? 'active' : '' }}">
          <a href="{{ route('questions.index') }}" class="menu-link">
            <div data-i18n="Questions">Questions (Soal)</div>
          </a>
        </li>
        @endcan
      </ul>
    </li>
    @endcanany

    <!-- History -->
    @canany(['players-list', 'game_session-list'])
    <li class="menu-item {{ request()->routeIs('players.*') || request()->routeIs('game_sessions.*') ? 'active open' : '' }}">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-history"></i>
        <div data-i18n="History">History</div>
      </a>
      <ul class="menu-sub">
        @can('players-list')
        <li class="menu-item {{ request()->routeIs('players.*') ? 'active' : '' }}">
          <a href="{{ route('players.index') }}" class="menu-link">
            <div data-i18n="Players">Players</div>
          </a>
        </li>
        @endcan
        @can('game_session-list')
        <li class="menu-item {{ request()->routeIs('game_sessions.*') ? 'active' : '' }}">
          <a href="{{ route('game_sessions.index') }}" class="menu-link">
            <div data-i18n="Game Sessions">Game Sessions</div>
          </a>
        </li>
        @endcan
      </ul>
    </li>
    @endcanany

    <!-- Settings -->
    @canany(['users-list', 'role-list', 'session-list'])
    <li class="menu-item {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('sessions.*') ? 'active open' : '' }}">
      <a href="javascript:void(0)" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Settings">Settings</div>
      </a>
      <ul class="menu-sub">
        @can('users-list')
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
          <a href="{{ route('users.index') }}" class="menu-link">
            <div data-i18n="User Management">User Management</div>
          </a>
        </li>
        @endcan
        @can('role-list')
        <li class="menu-item {{ request()->routeIs('roles.*') ? 'active open' : '' }}">
          <a href="{{ route('roles.index') }}" class="menu-link">
            <div data-i18n="Role Management">Role Management</div>
          </a>
        </li>
        @endcan
        @can('session-list')
        <li class="menu-item {{ request()->routeIs('sessions.*') ? 'active open' : '' }}">
          <a href="{{ route('sessions.index') }}" class="menu-link">
            <div data-i18n="Sessions Management">Sessions Management</div>
          </a>
        </li>
        @endcan
      </ul>
    </li>
    @endcanany
  </ul>
</aside>
