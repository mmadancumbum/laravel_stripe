@extends('layouts.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">{{ __('Dashboard') }}</div>
<div class="card-body">
@if (session('status'))
<div class="alert alert-success" role="alert">
{{ session('status') }}
</div>
@endif
{{ __('You are logged in!') }} <br><br>
<h3>Products</h3>
<a href="{{route('goToPayment', ['search list', 25])}}"><button>In Recommended Search List for $25</button></a> &nbsp;
<a href="{{route('goToPayment', ['update information', 10])}}"><button>Update Information for $10</button></a>
</div>
</div>
</div>
</div>
</div>
@endsection