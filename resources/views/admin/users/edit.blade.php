@extends('layout.master')
@push('css')
<style>
    .bootstrap-select>.dropdown-toggle {
        width: 20% !important;
    }
    .select2-container {
        top: 18px; 
        left: -3px;
    }
</style>
@endpush
@section('content')
<div class="col-md-12">
    <a href="{{ URL::previous() }}" class="btn">Back</a>
    <div class="card">
        <form id="formEditUser" method="post" action="{{ route('admin.users.update', $data->id) }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-header card-header-text" data-background-color="rose">
                <h4 class="card-title">Form edit {{ $table }}</h4>
            </div>
            <div class="card-content">
                <div class="row">
                    <label class="col-sm-2 label-on-left">Name</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                            <span class="help-block">A block of help text that breaks onto a new line.</span>
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Email</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="email" value="{{ $data->email }}">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose gender</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select name="gender" class="selectpicker">
                                <option value="1" @if ($data->gender === 1)
                                    selected
                                @endif>
                                    Male
                                </option>
                                <option value="0" @if ($data->gender === 0)
                                    selected
                                @endif>
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
                            <input type="tel" class="form-control" name="phone_number" value="{{ $data->phone_number }}">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Address</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="address" value="{{ $data->address }}">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Birthday</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="date" class="form-control" name="birthday" value="{{ $data->date_format }}">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Description</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="text" class="form-control" name="description" value="{{ $data->description }}">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Avatar</label>
                    <div class="col-sm-10">
                        <label class="control-label"></label>
                        <input type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])" name="photo">
                        <img id="pic" style="width:50% !important;" src="{{ asset('storage/user_avatar/'.$data->photo) }}"/>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose Customer Role</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select name="customer_role" class="selectpicker">
                                @foreach ($customerRole as $key => $value)
                                    <option value="{{ $value }}" @if ($value == $data->customer_role)
                                        selected
                                    @endif>
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
                                    <option value="{{ (int)$value }}" @if ($value == $data->user_role)
                                        selected
                                    @endif>
                                        {{ $key }}
                                    </option>
                                @endforeach
                            </select>
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose Collaborator</label>
                    <div class="col-sm-10">
                            <label class="control-label"></label>
                            <select name="collaborator_id" id="select-collaborator" style="width: 150px !important;">
                            </select>
                        <span class="material-input"></span>
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

        var url     = "{{ route('collaborators.api.index') }}";
        let id      = "{{ $data->collaborator_id }}";
        let name    = "{{ optional($data->collaborator)->name }}";
        let select  = $("#select-collaborator");
        let placeholder = "Select a collaborator";

        selectF0Id(select, url, placeholder, id, name);

        $("#formEditUser").submit(function(e) {

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
                    showNotification('top','right', 'successfully updated user.', 'success');
                },
                error: function (response) {
                    showNotification('top','right', 'updated user failed.', 'danger');
                },
            });
        });
    });
</script>
@endpush

