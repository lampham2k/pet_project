@extends('layout.master')
@section('content')
<div class="col-md-12">
    <a href="{{ URL::previous() }}" class="btn">Back</a>
    <div class="card">
        <form id="formDiscount" method="post" action="{{ route('admin.discounts.store') }}" class="form-horizontal" enctype="multipart/form-data">
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
                    <label class="col-sm-2 label-on-left">Money reduced</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="tel" class="form-control" name="money_reduced">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Percent reduction</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="tel" class="form-control" name="percent_reduction">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">Start date</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="date" class="form-control" name="start_date">
                        <span class="material-input"></span></div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 label-on-left">End_date</label>
                    <div class="col-sm-10">
                        <div class="form-group label-floating is-empty">
                            <label class="control-label"></label>
                            <input type="date" class="form-control" name="end_date">
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

        $("#formDiscount").submit(function(e) {

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
                    showNotification('top','right', 'successfully added new discount.', 'success');
                },
                error: function (response) {
                    showNotification('top','right', 'added new discount failed.', 'danger');
                },
            });

        });
    });
</script>
@endpush

