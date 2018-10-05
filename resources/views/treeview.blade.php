@extends('layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/treeview.min.css') }}">
    <script src="{{ asset('js/shieldui-core.min.js') }}"></script>
    <script src="{{ asset('js/shieldui-treeview.min.js') }}"></script>
    <div style="padding: 1%">
        @if(Auth::check())
            <label>Drag And Drop : </label>
            <button type="button" id="DragAndDropButton" class="btn"></button>
            <form id="SendFrom" method="POST" action="{{route('change-chief')}}" class="hiden-elem">
                @csrf
                <br>
                <label id="Employee"></label>
                <label>To</label>
                <label id="Chief"></label>
                <input type="hidden" id="EmployeeID" name="EmployeeID">
                <input type="hidden" id="ChiefID" name="ChiefID">
                <input type="submit" value="Сonfirm" class="btn btn-primary">
            </form>
        @endif
        <div id="treeview"></div>
        @if($success)
            <div class="alert alert-success" role="alert">{{$success}}</div>
        @endif

        @if($error)
            <div class="alert alert-danger" role="alert">{{$error}}</div>
        @endif
    </div>
    <script src="{{ asset('js/zero-main-margin.js') }}"></script>
    <script src="{{ asset('js/treeview.js') }}"></script>
@endsection
