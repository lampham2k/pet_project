@extends('layout.master')
@section('content')
<div class="col-md-12">
    <a href="{{ URL::previous() }}" class="btn">Back</a>
    <div class="card">
        <form id="formEditProduct" method="POST" action="{{ route('admin.products.update', $data->id) }}" class="form-horizontal" enctype="multipart/form-data">
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
                    <label class="col-sm-2 label-on-left">Price (VND)</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="number" class="form-control" name="price" step="0.01" value="{{ $data->price }}">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Quantity</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="number" class="form-control" name="quantity" value="{{ $data->quantity }}">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose type</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select name="type_id" class="selectpicker">
                                @foreach ($types as $key => $value)
                                    <option value="{{ $key }}" @if ($key == $data->type_id)
                                        selected
                                    @endif>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Choose manufacturer</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <select name="manufacturer_id" class="selectpicker">
                                @foreach ($manufacturers as $each)
                                    <option value="{{ $each->id }}" @if ($each->id == $data->manufacturer_id)
                                        selected
                                    @endif>
                                        {{ $each->name }}
                                    </option>
                                @endforeach
                            </select>
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Photo</label>
                    <div class="col-sm-10">
                        <label class="control-label"></label>
                        <input type="file" oninput="pic.src=window.URL.createObjectURL(this.files[0])" name="photo">
                        <img id="pic" style="width:50% !important;" src="{{ asset('storage/product_photo/'.$data->photo) }}"/>
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

        $("#formEditProduct").submit(function(e) {

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
                    showNotification('top','right', 'successfully updated manufacturer.', 'success');
                },
                error: function (response) {
                    showNotification('top','right', 'updated manufacturer failed.', 'danger');
                },
            });

        });
    });
</script>
@endpush

