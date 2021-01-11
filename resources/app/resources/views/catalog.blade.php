@extends('layout')

@section('content')
<div id="app">
  <categories></categories>
  <catalog-anime :title ="'{{$title}}'" :source = "'{{$source}}'" :tags = "'{{$tags}}'"></catalog-anime>
</div>
@endsection