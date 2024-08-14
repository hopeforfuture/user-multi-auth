<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Administrator Dashboard</title>
  <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ url('css/style.css') }}" rel="stylesheet">
  <script type="text/javascript" src="{{ url('js/jquery.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/jquery-ui.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('js/bootstrap.js') }}"></script>
</head>
<body>
  <div class="container">
    <div style="border:1px solid #000;text-align:right;padding:5px;margin-top:10px;">
      <div id="right-item" style="text-align:left;">
        <a href="{{ route('admin.customer.list') }}">All Customers</a> | <a href="{{ route('admin.lead.list') }}">All Leads</a> | <a href="{{ route('admin.dashboard') }}">Profile</a>
      </div>
      <div id="right-item" style="text-align:right;">
        Logged In As: <span style="font-weight: bold;">{{ $userdata['name'] }}</span> | <a href="{{ route('admin.logout') }}">Logout</a>
      </div>
    </div>
    @if(session()->has("message"))
      <div class="alert alert-{{session("message_type")}}">
        <p> {{session("message")}} </p>
      </div>
   @endif
    @yield('content')
  </div>
</body>
</html>

<script>
  $(function() {
    setTimeout(() => {
      $(".alert").hide('slow');
    }, 1000);
  });
</script>