@extends('layouts.layout')

@section('content')
    <div style="margin-left: 10px; margin-bottom: 70px;">
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Settings</h4>
                <div>

                    <div class="row">
                        <div class="col-md-1 mb-3">
                            <label>Limit: </label>
                            <select id="LimitSelect" class="form-control">
                                @foreach ($limit as $l)
                                    <option value="{{$l}}">{{$l}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Order By</label>
                            <select id="SortSelect" class="form-control">
                                @foreach ($sort as $s)
                                    <option value="{{$s}}">{{$s}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label>Sort</label>
                            <select id="SortTypeSelect" class="form-control">
                                <option value="Asc">Asc</option>
                                <option value="Desc">Desc</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label>Serch By</label>
                            <select id="SearchSelect" class="form-control">
                                @foreach ($search as $sItem)
                                    <option value="{{$sItem}}">{{$sItem}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Search</label>
                            <input id="DataInput" type="text" class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-md-2">
                            <button id="PrevButton" class="btn btn-primary btn-lg btn-block">Prev</button>
                        </div>
                        <div class="col-md-2">
                            <button id="NextButton" class="btn btn-primary btn-lg btn-block">Next</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <table class="table table-hover table-bordered">
            <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Photo</th>
                <th scope="col">FirstName</th>
                <th scope="col">LastName</th>
                <th scope="col">SurName</th>
                <th scope="col">Position</th>
                <th scope="col">Has Chief</th>
                <th scope="col">Salary</th>
                <th scope="col">Employment Date</th>
            </tr>
            </thead>
            <tbody id="table">

            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/zero-main-margin.js') }}"></script>
    <script src="{{ asset('js/list.js') }}"></script>

@endsection