<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin_panel - @yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    {{-- <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/admin/plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" href="/admin/assets/app.css">

    <link href="/colorbox/css/colorbox.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.umd.js"></script>

    {{-- <script src="https://cdn.tiny.cloud/1/x3c3oo3f4sxle07iz09c9z1e1ib95dzq468pjgq0hgp9fik4/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> --}}
    {{-- <script>
      tinymce.init({
        selector: '.editor',
        plugins: [
          // Core editing features
          'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
          // Your account includes a free trial of TinyMCE premium features
          // Try the most popular premium features until Jan 3, 2025:
          'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
        ],
        height: 300,
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
          { value: 'First.Name', title: 'First Name' },
          { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        file_picker_callback: elFinderBrowser
      });

      function elFinderBrowser (callback, value, meta) {
          tinymce.activeEditor.windowManager.openUrl({
              title: 'File Manager',
              url: 'http://127.0.0.1:8000/elfinder/tinymce5',
              /**
               * On message will be triggered by the child window
               * 
               * @param dialogApi
               * @param details
               * @see https://www.tiny.cloud/docs/ui-components/urldialog/#configurationoptions
               */
              onMessage: function (dialogApi, details) {
                  if (details.mceAction === 'fileSelected') {
                      const file = details.data.file;
                      
                      // Make file info
                      const info = file.name;
                      
                      // Provide file and text for the link dialog
                      if (meta.filetype === 'file') {
                          callback(file.url, {text: info, title: info});
                      }
                      
                      // Provide image and alt text for the image dialog
                      if (meta.filetype === 'image') {
                          callback(file.url, {alt: info});
                      }
                      
                      // Provide alternative source and posted for the media dialog
                      if (meta.filetype === 'media') {
                          callback(file.url);
                      }
                      
                      dialogApi.close();
                  }
              }
          });
      }
    </script> --}}
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
          <img class="animation__shake" src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>
      
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item d-none d-sm-inline-block">
              <a href="{{ route('homeAdmin') }}" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <div class="dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="nav-link" style="color: red" href="/admin/logout"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </div>
            </li>
          </ul>
        </nav>
        <!-- /.navbar -->
      
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
          <!-- Brand Logo -->
          <a href="{{ route('homeAdmin') }}" class="brand-link">
            <img src="/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Admin Panel</span>
          </a>
      
          <!-- Sidebar -->
          <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="{{ route('homeAdmin') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Главная
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-align-left"></i>
                    <p>
                      Категории
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="{{ route('category.index') }}" class="nav-link">
                        <p>Все категории</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ route('category.create') }}" class="nav-link">
                        <p>Добавить категорию</p>
                      </a>
                    </li>
                  </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-newspaper"></i>
                      <p>
                        Продукты
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{ route('product.index') }}" class="nav-link">
                          <p>Все продукты</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('product.create') }}" class="nav-link">
                          <p>Добавить продукт</p>
                        </a>
                      </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-file"></i>
                      <p>
                        Страницы
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="{{ route('pageMainEdit') }}" class="nav-link">
                          <p>Главная</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('pageAboutEdit') }}" class="nav-link">
                          <p>About</p>
                        </a>
                      </li>
                    </ul>
                </li>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
          <!-- /.sidebar -->
        </aside>
      
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
      
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/admin/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    {{-- <script src="/admin/plugins/sparklines/sparkline.js"></script> --}}
    <!-- JQVMap -->
    {{-- <script src="/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
    <!-- jQuery Knob Chart -->
    <script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/admin/plugins/moment/moment.min.js"></script>
    <script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    {{-- <script src="/admin/plugins/summernote/summernote-bs4.min.js"></script> --}}
    <!-- overlayScrollbars -->
    <script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/admin/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="/admin/dist/js/pages/dashboard.js"></script> --}}
    
    <script>
      $(document).ready(function () {
        $(".nav-treeview .nav-link, .nav-link").each(function () {
            var location2 = window.location.protocol + '//' + window.location.host + window.location.pathname;
            var link = this.href;
            if(link == location2){
                $(this).addClass('active');
                $(this).parent().parent().parent().addClass('menu-is-opening menu-open');

            }
        });

        $('.delete-btn').click(function () {
            var res = confirm('Подтвердите действия');
            if(!res){
                return false;
            }
        });
      })
    </script>

    <script type="text/javascript" src="/colorbox/js/jquery.colorbox-min.js"></script>

    {{-- <script type="text/javascript" src="/admin/dist/js/jquery.colorbox-min.js"></script> --}}
    {{-- <script src="https://cdn.tiny.cloud/1/jxsqeq85qzdwuqqqruya91jqsrhqtxykhxtks6sn0t1kn69g/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script> --}}
    <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.js"></script>

    <script src="/admin/admin.js"></script>

    {{-- <script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script> --}}

    <script>
      const {
          ClassicEditor,
          Essentials,
          Bold,
          Italic,
          Font,
          Paragraph
      } = CKEDITOR;

      ClassicEditor
          .create( document.querySelector( '.editor' ), {
              licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NjYyNzUxOTksImp0aSI6IjJiYzFmZTM3LTE3ZTktNGNmOS04MGUyLWIzZjJkNDViODk1YiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCJdLCJ2YyI6IjFkNGQ5ZjgyIn0.lKSnKw-iZzWCJtYHtYGr3AXGgZeVPyUH__pfa4-WoAxttxCdKPyXq2qkwXyEKMFAw1a-K0lAHQNxV-9O7O5xAA',
              plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
              toolbar: [
                  'undo', 'redo', '|', 'bold', 'italic', '|',
                  'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
              ]
          } )
          .then( /* ... */ )
          .catch( () => {
            console.log('no ckeditor on this page');
          } );
    </script>
</body>
</html>
