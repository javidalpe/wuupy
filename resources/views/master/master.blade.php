<!DOCTYPE html>
<html>
  <head>
    @include('master.metas')
    <title>{{ config('app.name') }}</title>
    @include('master.header')
  </head>
  <body style="background-color:#f5f5f5;">
    @include('master.content')
    @include('master.scripts')
  </body>
</html>
