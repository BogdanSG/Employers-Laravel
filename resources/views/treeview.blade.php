@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/treeview.min.css') }}">
    <script src="{{ asset('js/shieldui-core.min.js') }}"></script>
    <script src="{{ asset('js/shieldui-treeview.min.js') }}"></script>
    <div style="padding: 1%">
        <div id="treeview"></div>
    </div>
    <script src="{{ asset('js/zero-main-margin.js') }}"></script>
    <script src="{{ asset('js/treeview.js') }}"></script>
@endsection
