<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
      <h3 class="mb-0 fw-bold">
        @yield('title')
      </h3>
    </div>
    <!-- /Search -->

    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <!-- Place this tag where you want the button to render. -->
      <li class="nav-item lh-1 me-3">
        <a
          class="github-button"
          href=""
          data-icon="octicon-star"
          data-size="large"
          data-show-count="true"
          aria-label=""
          >
          </a>
      </li>

      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </div>
                <div class="flex-grow-1">
                   @auth
                        <span class="fw-medium d-block">{{ ucfirst(auth()->user()->name) }}</span>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    @endauth
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#settingsModal">
              <i class="bx bx-cog me-2"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider"></div>
          </li>
          <li>
            <a href="{{ route('logout') }}"
                class="dropdown-item"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
              
              <i class="bx bx-power-off me-2"></i>
              <span class="align-middle">{{ __('You are logged in!') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </li>
      <!--/ User -->
    </ul>
  </div>
</nav>

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="settingsModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="profile_username" class="form-label" style="text-transform: uppercase;">Username</label>
              <input type="text" id="profile_username" name="username" class="form-control" value="{{ auth()->user()->username }}" required>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="profile_name" class="form-label" style="text-transform: uppercase;">Fullname</label>
              <input type="text" id="profile_name" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="profile_level" class="form-label" style="text-transform: uppercase;">Level</label>
              <input type="text" id="profile_level" class="form-control" value="{{ auth()->user()->roles->first()->name ?? 'User' }}" disabled>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="profile_password" class="form-label" style="text-transform: uppercase;">Password (Leave empty if you don't want to change it)</label>
              <input type="password" id="profile_password" name="password" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="profile_confirm-password" class="form-label" style="text-transform: uppercase;">Confirm Password</label>
              <input type="password" id="profile_confirm-password" name="confirm-password" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="profile_keterangan" class="form-label" style="text-transform: uppercase;">Description</label>
              <input type="text" id="profile_keterangan" name="keterangan" class="form-control" value="{{ auth()->user()->keterangan }}">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
          <button type="submit" class="btn btn-primary" style="background-color: #ff9800; border-color: #ff9800;">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


