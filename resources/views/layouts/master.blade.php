<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title','My AdminLTE')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    @include('partial.style')
   
  </head>
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">


    @if (!isset($hideHeader) || !$hideHeader)
    @include('partial.header')
    @endif

     @include('partial.sidebar')

      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
            @if (!isset($hideBreadcrumb) || !$hideBreadcrumb)
            @include('partial.breadcrumb')
            @endif
         
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
         @yield('content')
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>

      @include('partial.footer')

    </div>

    @include('partial.script')

  </body>
</html>
