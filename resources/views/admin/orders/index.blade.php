@extends('layout.master')
@push('css')
<style>
    .card-testimonial {
        margin-bottom: 12px !important;
    }
</style>
@endpush
@section('content')
<div class="col-md-12">
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <div class="form-group form-search is-empty">
                    <input type="text" class="form-control" placeholder="Search anything about order" style="margin:25px !important;" name="search" id="search" onfocus="this.value=''">
                    <span class="material-input"></span>
                <span class="material-input"></span></div>
            </li>
        </ul>
     </div>
    <div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">assignment</i>
        </div>
        <div class="card-content">
            <h4 class="card-title">{{ $title }}</h4>
            <div class="table-responsive" id="search_list">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>User Name</th>
                            <th>Name Receiver</th>
                            <th>Phone Receiver</th>
                            <th>Address Receiver</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $each )
                        <tr class="trTable">
                            <td class="text-center">
                                <a href="{{ route('admin.orders.product', $each->id) }}">{{ $each->id }}</a> 
                            </td>
                            <td>
                                {{ $each->user->name }} 
                            </td>
                            <td>
                                {{ $each->name_receiver }} 
                            </td>
                            <td>
                                {{ $each->phone_receiver }} 
                            </td>
                            <td>
                                {{ $each->address_receiver }} 
                            </td>
                            <td>
                                @if ($each->status_name == 'CANCELED')
                                    <div class="text-danger">{{ $each->status_name }}</div>
                                @elseif ($each->status_name == 'COMPLETED')
                                    <div class="text-primary">{{ $each->status_name }}</div> 
                                @else
                                    <div class="text-success">{{ $each->status_name }}</div> 
                                @endif
                            </td>
                            <td>
                                {{ $each->total }} vnd 
                            </td>
                            <td class="td-actions text-right">
                                @if ($each->status == 0)
                                    <a href="{{ route('admin.orders.accept', $each->id) }}" rel="tooltip" class="btn btn-success a-accept-order" data-original-title="" title="">
                                        <i class="material-icons">check</i>
                                    </a>
                                    <a href="{{ route('admin.orders.cancel', $each->id) }}" rel="tooltip" class="btn btn-danger a-cancel-order" data-original-title="" title="">
                                        <i class="material-icons">cancel</i>
                                    </a>
                                @elseif ($each->status == 3)
                                    <a href="{{ route('admin.orders.accept', $each->id) }}" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                        <i class="material-icons">check</i>
                                    </a>
                                @elseif ($each->status == 5)
                                    <a href="" rel="tooltip" class="btn btn-primary a-accept-order" data-original-title="" title="">
                                        <i class="material-icons">done_all</i>
                                    </a>
                                @else
                                    <a href="{{ route('admin.orders.cancel', $each->id) }}" rel="tooltip" class="btn btn-danger a-cancel-order" data-original-title="" title="">
                                        <i class="material-icons">cancel</i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <ul class="pagination pagination-info" style="float:right !important;">
                    {{ $data->links() }}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<script>
    $(document).ready(function(){
        $(".a-accept-order").click(function(e) {

            e.preventDefault();

            var href = $(this).attr('href');

            $.ajax({
                url: href,
                type: "GET",
                contentType: false,
                processData: false, 
                success: function(data)
                {
                    window.location.reload();
                    swal({
                        title: 'Accept!',
                        text: 'this order has been accept.',
                        type: 'success',
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    })
                },
                error: function (response) {
                    // showNotification('top','right', 'delete manufacturer failed.', 'danger');
                },
            })
        });

        $(".a-cancel-order").click(function(e) {

            e.preventDefault();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, cancel it!',
                buttonsStyling: false
            }).then(function() {

                var href = $(".a-cancel-order").attr('href');

                $.ajax({
                    url: href,
                    type: "GET",
                    contentType: false,
                    processData: false, 
                    success: function(data)
                    {
                        window.location.reload();
                        swal({
                            title: 'Cancel!',
                            text: 'this order has been canceled.',
                            type: 'success',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        })
                    },
                    error: function (response) {
                        // showNotification('top','right', 'delete manufacturer failed.', 'danger');
                    },
                })
            })
        });

        $('#search').on('keyup',function(){

            var query= $(this).val();

            $.ajax({
                url:"{{ route('orders.api.search') }}",
                type:"GET",
                data:{'search':query},
                success:function(data){
                    $('#search_list').html(data);
                },
                error: function (response) {
                    window.location.reload();
                },
            });
        });

    });
</script>
@endpush