@extends('layout.master')
@push('css')
<style>
    .card-testimonial {
        margin-bottom: 12px !important;
    }
</style>
@endpush
@section('content')
<div class="col-md-4">
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <a href="{{ URL::previous() }}" class="btn btn-warning">Back</a>
            </li>
            <li>
                <a class="btn" href="#" data-toggle="modal" data-target="#modalDiscountProduct">Add products</a>
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
            <h4 class="card-title">{{ $dataDiscount->name }}</h4>
            <div class="table-responsive" id="search_list">
                <table class="table" id="tableProduct">
                    <thead>
                        <tr>
                            <th class="text-left">Name</th>
                            <th class="text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dataDiscount->product as $each )
                        <tr class="trTable">
                            <td class="text-left">
                                {{ $each->name }}
                            </td>
                            <td class="td-actions text-left">
                                <form class="formDelete" action="{{ route('admin.discounts.product_delete', ['productId' => $each->pivot->product_id, 'discountId' => $dataDiscount->id]) }}" method="POST" style="display: inline !important;">
                                    <button rel="tooltip" class="btnDelete btn btn-danger" data-original-title="" title="">
                                        <i class="material-icons">close</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- <ul class="pagination pagination-info" style="float:right !important;">
                    {{ $dataDiscount->links() }}
                </ul> --}}
            </div>
        </div>
    </div>
</div>
  <!-- Modal -->
  <div class="modal fade" id="modalDiscountProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> --}}
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.discounts.products') }}" id="formAddProductToDiscountCode" method="POST">
            @csrf
            <input type="hidden" value="{{ $dataDiscount->id }}" name="discount_id">
            <div class="row">
                <label class="col-sm-2 label-on-left">Choose product to discount code</label>
                <div class="col-sm-10">
                        <label class="control-label"></label>
                        <select multiple name="product_id[]" id="select-product" style="width: 150px !important;">
                        </select>
                    <span class="material-input"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" >add</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    var url         = "{{ route('discounts.api.products') }}";
    let select      = $("#select-product");
    let placeholder = "Select product to discount code";
    let tag         = true;

    select2WithApi(select, url, placeholder, tag);
    $(document).ready(function(){
        // var table = $('#tableProduct').DataTable();

        $("#formAddProductToDiscountCode").submit(function(e) {

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
                $("#modalDiscountProduct").modal("hide");
                showNotification('top','right', 'successfully added new products to discount code.', 'success');
                setTimeout(function(){
                    location.reload(); 
                }, 5000);
            },
            error: function (response) {
                showNotification('top','right', 'added new products to discount code failed.', 'danger');
            },
        });
    });

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
                            text: 'this product has been deleted.',
                            type: 'success',
                            confirmButtonClass: "btn btn-success",
                            buttonsStyling: false
                        })
                    },
                    error: function (response) {
                        showNotification('top','right', 'delete product failed.', 'danger');
                    },
                })
            })
        });   
    });
</script>
@endpush