@extends('layout.master')
@push('css')
<style>
    .bootstrap-select>.dropdown-toggle {
        width: 20% !important;
    }
</style>
@section('content')
<div class="col-md-12">
    <a href="{{ URL::previous() }}" class="btn">Back</a>
    <div class="card">
        <form id="formCreateUser" method="post" action="{{ route('admin.users.store') }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="card-header card-header-text" data-background-color="rose">
                <h4 class="card-title">Form add {{ $table }}</h4>
            </div>
            <div class="card-content">
                <div class="row">
                    <label class="col-sm-2 label-on-left">Name</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="name">
                            <span class="help-block">A block of help text that breaks onto a new line.</span>
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Email</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="email" class="form-control" name="email">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Password</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="password">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose gender</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select name="gender" class="selectpicker">
                                <option value="1">
                                    Male
                                </option>
                                <option value="0">
                                    Female
                                </option>
                            </select>
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Phone number</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="tel" class="form-control" name="phone_number">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Address</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="address">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Birthday</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="date" class="form-control" name="birthday">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Description</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="description">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Avatar</label>
                    <div class="col-sm-10">
                        <label class="control-label"></label>
                        <input type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])" name="photo">
                        <img id="pic" style="width:50% !important;"/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose Customer Role</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select name="customer_role" class="selectpicker">
                                @foreach ($customerRole as $key => $value)
                                    <option value="{{ $value }}">
                                        {{ $key }}
                                    </option>
                                @endforeach
                            </select>
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose User Role</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select name="user_role" class="selectpicker">
                                @foreach ($userRole as $key => $value)
                                    <option value="{{ (int)$value }}">
                                        {{ $key }}
                                    </option>
                                @endforeach
                            </select>
                        <span class="material-input"></span></div>
                    </div>
                </div>
            </div>
                <button id="btn" class="btn btn-rose" style="float:right !important; margin: 15px !important;">Submit</button>
        </form>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready( function () {

        $("#formCreateUser").submit(function(e) {

            e.preventDefault();

            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: actionUrl,
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false, 
                success: function(data)
                {
                    showNotification('top','right', 'successfully added new user.', 'success');
                },
                error: function (response) {
                    showNotification('top','right', 'added new user failed.', 'danger');
                },
            });

        });
    });
</script>
@endpush

