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
                <a href="{{ route('admin.discounts.create') }}" class="btn">Add {{ $title }}</a>
            </li>
            <li>
                <div class="form-group form-search is-empty">
                    <input type="text" class="form-control" placeholder="Search anything" style="margin:25px !important;" name="search" id="search" onfocus="this.value=''">
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
                            <th>Name</th>
                            <th>Money reduced</th>
                            <th>Percent reduction</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $each )
                        <tr class="trTable">
                            <td class="text-center">
                                <a href="{{ route('admin.discounts.product', $each->id) }}">{{ $each->id }}</a> 
                            </td>
                            <td>
                                {{ $each->name }} 
                            </td>
                            <td>
                                {{ $each->money_reduced }} 
                            </td>
                            <td>
                                {{ $each->percent_reduction }} 
                            </td>
                            <td>
                                {{ $each->start_date }} 
                            </td>
                            <td>
                                {{ $each->end_date }} 
                            </td>
                            <td class="td-actions text-right">
                                <a href="{{ route('admin.manufacturers.edit', $each->id) }}" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                </a>
                                <form class="formDelete" action="{{ route('admin.manufacturers.delete', $each->id) }}" method="POST" style="display: inline !important;">
                                    <button rel="tooltip" class="btnDelete btn btn-danger" data-original-title="" title="">
                                        <i class="material-icons">close</i>
                                    </button>
                                </form>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('#search').on('keyup',function(){
            var query= $(this).val();
            $.ajax({
            url:"{{ route('manufacturers.api.search') }}",
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
    $(document).on('click', '.btnDelete', function() {

        let form = $(this).parents('form');

        form.submit(function(e) {
            e.preventDefault();

            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {
                form.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: form.attr('action'),
                    type: "DELETE",
                    data: form.serialize(),
                    contentType: false,
                    processData: false, 
                    success: function(data)
                    {
                        window.location.reload();
                        swal({
                            title: 'Deleted!',
                            text: 'this manufactuer has been deleted.',
                            type: 'success',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        })
                    },
                    error: function (response) {
                        showNotification('top','right', 'delete manufacturer failed.', 'danger');
                    },
                })
            })
        });   
    });
</script>
@endpush