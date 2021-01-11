@extends('layout')

@section('content')
<div id="app">
  <settings :content= "'{{$content}}'"></settings>
</div>
@endsection