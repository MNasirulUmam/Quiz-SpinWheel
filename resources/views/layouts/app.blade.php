<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>BHC</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css?v=2') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css?v=2') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Page CSS -->
    <style>
      @media (min-width: 1200px) {
        .layout-menu-collapsed .layout-menu { width: 5.25rem !important; }
        .layout-menu-collapsed .layout-page { padding-left: 5.25rem !important; }
        .layout-menu-collapsed .layout-menu:hover { width: 16.25rem !important; }
        
        .layout-menu-collapsed .app-brand-text,
        .layout-menu-collapsed .menu-sub,
        .layout-menu-collapsed .menu-item .menu-link > div:not(.badge) { display: none !important; }
        
        .layout-menu-collapsed .layout-menu:hover .app-brand-text,
        .layout-menu-collapsed .layout-menu:hover .menu-sub,
        .layout-menu-collapsed .layout-menu:hover .menu-item .menu-link > div:not(.badge) { display: block !important; }
        
        .layout-menu-collapsed .menu-toggle::after { display: none !important; }
        .layout-menu-collapsed .layout-menu:hover .menu-toggle::after { display: block !important; }
        
        .layout-menu-collapsed .menu-item .menu-link .menu-icon {
          margin-left: -2rem !important;
          width: 5.25rem !important;
          text-align: center !important;
          margin-right: 0 !important;
          display: block !important;
        }
        .layout-menu-collapsed .layout-menu:hover .menu-item .menu-link .menu-icon {
          margin-left: 0 !important;
          width: 1.5rem !important;
          margin-right: 0.5rem !important;
        }
        
        .layout-menu-collapsed .app-brand { padding-left: 0 !important; justify-content: center !important; }
        .layout-menu-collapsed .layout-menu:hover .app-brand { padding-left: 1.5rem !important; justify-content: flex-start !important; }
        
        @media (min-width: 1200px) {
            .layout-menu .app-brand .layout-menu-toggle {
                display: block !important;
                opacity: 1 !important;
            }
        }
      }
    </style>

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        @include('layouts.sidebar')
        
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          @include('layouts.header')
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4> -->
              
              @yield('content')
              <!-- Basic Layout -->
              
            </div>
            <!-- / Content -->

            <!-- Footer -->
            @include('layouts.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}?v={{ time() }}"></script>

    <!-- Custom Toggle JS -->
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.querySelector('.custom-toggle');
        const html = document.documentElement;
        
        if(toggleBtn) {
          // Prevent main.js from throwing error if toggleCollapsed is missing in free version
          if(window.Helpers && !window.Helpers.toggleCollapsed) {
            window.Helpers.toggleCollapsed = function() {};
          }

          toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle the class on html
            html.classList.toggle('layout-menu-collapsed');
            
            // Change the icon
            const icon = toggleBtn.querySelector('i');
            if(html.classList.contains('layout-menu-collapsed')) {
              icon.classList.remove('bx-chevron-left');
              icon.classList.add('bx-chevron-right');
            } else {
              icon.classList.remove('bx-chevron-right');
              icon.classList.add('bx-chevron-left');
            }
          });
          
          // Initial check for icon state based on current class
          const icon = toggleBtn.querySelector('i');
          if(html.classList.contains('layout-menu-collapsed')) {
            icon.classList.remove('bx-chevron-left');
            icon.classList.add('bx-chevron-right');
          }
        }
      });
    </script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      @if(session('success'))
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: '{{ session('success') }}',
          timer: 3000,
          showConfirmButton: false
        });
      @endif
      
      @if(session('error'))
        Swal.fire({
          icon: 'error',
          title: 'Gagal!',
          text: '{{ session('error') }}',
        });
      @endif
    </script>
    @yield('script')
    @stack('scripts')
  </body>
</html>
