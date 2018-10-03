@extends('layouts.layout')

@section('content')

    <form id="updateForm" method="POST" action="{{route('update-employee')}}" enctype="multipart/form-data">@csrf</form>
    <form id="deleteForm" method="POST" action="{{route('delete-employee')}}">@csrf</form>

    <div class="center-margin">

        <input form="updateForm" type="hidden" name="id" value="{{$Employee->EmployeeID}}">
        <input form="deleteForm" type="hidden" name="id" value="{{$Employee->EmployeeID}}">

        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="{{$ImgPath}}" alt="" width="420">
            @if(Auth::check())
                <div id="FileImput" class="hiden-elem custom-file col-lg-6 col-md-9">
                    <input form="updateForm" id="employeeImage" type="file" name="image" class="custom-file-input" accept="image/x-png,image/gif,image/jpeg">
                    <label form="updateForm" id="employeeImageLabel" class="custom-file-label">Choose file</label>
                </div>
            @endif
        </div>

        <div class="row" style="margin-bottom: 80px;">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Employee Info</h4>
                <div class="needs-validation">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>First name</label>
                            <input form="updateForm" disabled value="{{$Employee->FirstName}}" id="FirstName" name="FirstName" type="text" class="form-control" placeholder="Ivan">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Last name</label>
                            <input form="updateForm" disabled value="{{$Employee->LastName}}" id="LastName" name="LastName" type="text" class="form-control" placeholder="Ivanov">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Sur name</label>
                            <input form="updateForm" disabled value="{{$Employee->SurName}}" id="SurName" name="SurName" type="text" class="form-control" placeholder="Ivanovich">
                        </div>
                    </div>

                    @if(Auth::check())
                        <div class="row">
                            <div class="col-md-8 mb-6">
                                <label>Chief</label>
                                <div style="background-color: #e9ecef;" id="Chief" class="form-control">{{$Employee->chief ? $Employee->chief->FirstName : ''}} {{$Employee->chief ? $Employee->chief->LastName : ''}} {{$Employee->chief ? $Employee->chief->SurName : ''}}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>ChiefID</label>
                                <input form="updateForm" disabled value="{{$Employee->chief ? $Employee->chief->EmployeeID : ''}}" id="ChiefID" name="ChiefID" type="number" min="1" class="form-control" placeholder="">
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label>Position</label>
                            <div style="background-color: #e9ecef; text-align: center;" id="Position" class="form-control">{{$Employee->position->Position}}</div>
                        </div>
                    </div>

                    @if(Auth::check())
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-8 mb-6">
                                <label>Employment Date</label>
                                <input form="updateForm" disabled type="datetime-local" value="{{$EmploymentDate}}" id="EmploymentDate" name="EmploymentDate" class="form-control" placeholder="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Salary</label>
                                <input form="updateForm" disabled value="{{$Employee->Salary}}" type="number" min="{{$MinSalaryValue}}" max="{{$MaxSalaryValue}}" id="Salary" name="Salary" class="form-control" placeholder="100000">
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px; margin-bottom: 30px">
                            <div class="col-md-4">
                                <div id="Edit" class="btn btn-primary btn-lg btn-block">Edit</div>
                            </div>
                            <div class="col-md-4">
                                <input form="updateForm" type="submit" disabled class="btn btn-warning btn-lg btn-block" id="Update" value="Update">
                            </div>
                            <div class="col-md-4">
                                <input form="deleteForm" type="submit" id="Delete" class="btn btn-danger btn-lg btn-block" value="Delete">
                            </div>
                        </div>
                    @endif

                    @if($success)
                        <div class="alert alert-success" role="alert">{{$success}}</div>
                    @endif

                    @if($error)
                        <div class="alert alert-danger" role="alert">{{$error}}</div>
                    @endif

                </div>
            </div>
        </div>

    </div>
    <script src="{{ asset('js/single-employee.js') }}"></script>
@endsection
