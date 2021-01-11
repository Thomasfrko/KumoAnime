@extends('layout')

@section('content')
<div id="app">
  <watch :numbers = "'{{$numbers}}'" :links = "'{{$links}}'" :name = "'{{$name}}'"></watch>
</div>
@endsection