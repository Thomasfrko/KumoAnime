@extends('layout')

@section('content')
<div id="app">
  <list-links :links ="'{{$links}}'"></list-links>
</div>
@endsection