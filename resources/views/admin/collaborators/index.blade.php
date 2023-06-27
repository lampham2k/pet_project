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
                <a href="{{ route('admin.collaborators.create') }}" class="btn">Add {{ $title }}</a>
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
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Information</th>
                            <th>Role</th>
                            <th>F0-ID</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $each )
                        <tr class="trTable" onclick="myFunction(this)">
                            <td class="text-center">
                                <a href="{{ route('admin.collaborators.marketing', $each->id) }}">{{ $each->id }}</a> 
                            </td>
                            <td>
                                <div class="card card-testimonial">
                                    <div class="card-avatar">
                                        <img src="{{ asset('storage/collaborator_avatar/'.$each->photo) }}" style="height:20% !important;" alt="avatar_user">
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $each->name }} 
                            </td>
                            <td>
                                {{ $each->email }} 
                            </td>
                            <td>
                                {{ $each->gender }} 
                            </td>
                            <td class="detailInfor">
                                Tel: {{ $each->phone_number }}
                            </td>
                            <td>
                                {{ $each->role }} 
                            </td>
                            <td>
                                {{ $each->f0_id_name }} 
                            </td>
                            <td class="td-actions text-right">
                                <a href="{{ route('admin.collaborators.edit', $each->id) }}" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                </a>
                                <form class="formDelete" action="{{ route('admin.collaborators.delete', $each->id) }}" style="display: inline !important;">
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

        $(".btnUnFiltered").click(function(e) {
            e.preventDefault();
            var url = document.URL;
            url = url.split('?')[0];  
            window.location.href = url;
        });

        $('#search').on('keyup',function(){
            var query= $(this).val();
            $.ajax({
            url:"{{ route('users.api.search') }}",
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
    $(document).on('click', '.detailInfor', function() {

        let parent  = $(this).parents(".trTable");
        let id      = parent.find('.text-center').text();
        id          = parseInt(id);
        var url     = '{{ route("collaborators.api.inforCollaboratorDetail", ":id") }}';
        url         = url.replace(':id', id);

        $.ajax({
            url: url,
            contentType: false,
            processData: false, 
            dataType: "json",
            success: function(data)
            {
                swal({
                    title: data.data.name + ' is personal information',
                    buttonsStyling: false,
                    confirmButtonText: 'Close',
                    confirmButtonClass: "btn btn-success",
                    html: '<b>Tel: </b> ' + data.data.phone_number + '</br>' +
                    '<b>Address: </b> ' + data.data.address + '</br>' +
                    '<b>Birthday: </b> ' + data.data.birthday + '</br>' +
                    '<b>Description: </b> ' + data.data.description + '</br>',
                }).catch(swal.noop)
            },
            error: function (response) {
            },
        })
    });
    function myFunction(x) {
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
                        document.getElementById("myTable").deleteRow(x.rowIndex);
                        swal({
                            title: 'Deleted!',
                            text: 'this collaborator has been deleted.',
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
    }
</script>
@endpush