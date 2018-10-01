@extends('layouts.layout')

@section('content')
    <div class="center-margin">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="{{$ImgPath}}" alt="" width="420">
            @if(Auth::check())
                <div class="custom-file col-lg-6 col-md-9">
                    <input id="employeeImage" type="file" class="custom-file-input" accept="image/x-png,image/gif,image/jpeg">
                    <label class="custom-file-label">File</label>
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
                            <input disabled value="{{$Employee->FirstName}}" type="text" class="form-control" placeholder="Ivan">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Last name</label>
                            <input disabled value="{{$Employee->LastName}}" type="text" class="form-control" placeholder="Ivanov">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Sur name</label>
                            <input disabled value="{{$Employee->SurName}}" type="text" class="form-control" placeholder="Ivanovich">
                        </div>
                    </div>

                    @if(Auth::check())
                        <div class="row">
                            <div class="col-md-8 mb-6">
                                <label>Chief</label>
                                <div style="background-color: #e9ecef;" class="form-control">{{$Employee->chief->FirstName}} {{$Employee->chief->LastName}} {{$Employee->chief->SurName}}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>ChiefID</label>
                                <input disabled value="{{$Employee->chief->EmployeeID}}" type="number" min="1" class="form-control" placeholder="">
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label>Position</label>
                            <div style="background-color: #e9ecef; text-align: center;" class="form-control">{{$Employee->position->Position}}</div>
                        </div>
                    </div>

                    @if(Auth::check())
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-8 mb-6">
                                <label>Employment Date</label>
                                <input disabled type="datetime-local" value="{{$EmploymentDate}}" class="form-control" placeholder="">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Salary</label>
                                <input disabled value="{{$Employee->Salary}}" type="number" min="{{$MinSalaryValue}}" max="{{$MaxSalaryValue}}" step="1000" class="form-control" placeholder="100000">
                            </div>
                        </div>

                        <div class="row" style="margin-top: 10px; margin-bottom: 30px">
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-lg btn-block">Edit</button>
                            </div>
                            <div class="col-md-4">
                                <button disabled class="btn btn-warning btn-lg btn-block">Update</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-danger btn-lg btn-block">Delete</button>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>
@endsection
