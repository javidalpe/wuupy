@include('master.tabbar')
<div id="content" class="ui container">
  @include('master.alerts')
  @yield('content')
  @include('master.footer')
</div>
