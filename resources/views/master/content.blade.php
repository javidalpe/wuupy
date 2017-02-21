@include('master.tabbar')
<div id="content" class="ui container">
  @include('master.alerts')
  @yield('content')
  <div style="text-align:center; margin-top:40px" class="ui grey">
      <small>Copyright Wuupy 2017</small>
  </div>
</div>
