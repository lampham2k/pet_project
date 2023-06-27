@extends('layout.master')
@push('css')
<style>
    .panel-body {
        margin: -120px 0px;
        padding-top: 50px;
        padding-right: 500px;
        padding-left: 400px;
    }
    .card-testimonial {
        margin-bottom: 12px !important;
    }
    select {
        appearance: none;
        outline: 0;
        border: 0;
        box-shadow: none;
        flex: 1;
        padding: 0 1em;
        color: #fff;
        background-color: #2c3e50;
        background-image: none;
        cursor: pointer;
    }
    .selecT {
    position: relative;
    display: flex;
    width: 8em;
    height: 3em;
    border-radius: .25em;
    overflow: hidden;
    top: 10px;         
    left: 613px;
    }
    .selecT::after {
    content: '\25BC';
    position: absolute;
    top: 0;
    right: 0;
    padding: 1em;
    background-color: #34495e;
    transition: .25s all ease;
    pointer-events: none;
    }
    .selecT:hover::after {
    color: #f39c12;
    }
    .selectManufacturer {
    position: relative;
    display: flex;
    width: 8em;
    height: 3em;
    border-radius: .25em;
    overflow: hidden;
    top: -32px;         
    left: 732px;
    }
    .selectManufacturer::after {
    content: '\25BC';
    position: absolute;
    top: 0;
    right: 0;
    padding: 1em;
    background-color: #34495e;
    transition: .25s all ease;
    pointer-events: none;
    }
    .selectManufacturer:hover::after {
    color: #f39c12;
    }
</style>
@endpush
@section('content')
<div class="col-md-12">
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <a href="{{ route('admin.products.create') }}" class="btn">Add {{ $title }}</a>
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
        <form style="display: inline !important; ">
            <div class="selecT">
                <select name="type_id">
                    <option value="">All</option>
                    @foreach ($types as $key => $value)
                        <option value="{{ $key }}" @if ($key == $typeId)
                            selected
                        @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="selectManufacturer">
                <select name="manufacturer_id">
                    <option value="">All</option>
                    @foreach ($manufacturers as $each)
                        <option value="{{ $each->id }}" @if ($each->id == $manufacturerId)
                            selected
                        @endif>
                            {{ $each->name }}
                        </option>
                    @endforeach
                </select>
            </div>
                <input type="hidden" name="min_price" value="{{ $minPrice }}" id="input-min-price">
                <input type="hidden" name="max_price" value="{{ $maxPrice }}" id="input-max-price">
                <div class="panel-body panel-refine">
                     <span class="pull-left">
                        ₫<span id="span-min-price">
                           {{ $minPrice }}
                        </span>
                     </span>
                     <span class="pull-right">
                        ₫<span id="span-max-price">
                            {{ $maxPrice }}
                        </span>
                     </span>
                     <div class="clearfix"></div>
                     <div id="sliderRefine" class="slider slider-rose noUi-target noUi-ltr noUi-horizontal">
                     </div>
                </div>
            <button class="btn btn-info btnUnFiltered" style="left: 88% !important; display: flex !important; top: 54px !important; z-index: 100;">Unfiltered</button>
            <button class="btn btn-info" style="left: 70% !important; top: -34px !important;">Filter</button>
        </form>
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
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Manufacturer</th>
                            <th>Photo</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $each )
                        <tr class="trTable">
                            <td class="text-center">
                                {{ $each->id }} 
                            </td>
                            <td>
                                {{ $each->name }} 
                            </td>
                            <td>
                                {{ $each->price }} 
                            </td>
                            <td>
                                {{ $each->quantity }} 
                            </td>
                            <td>
                                {{ $each->type->name }} 
                            </td>
                            <td>
                                {{ optional($each->size)->size }} 
                            </td>
                            <td>
                                {{ $each->manufacturer->name }} 
                            </td>
                            <td>
                                <div class="card card-testimonial">
                                    <div class="card-avatar">
                                        <img src="{{ asset("storage/product_photo/".$each->photo) }}" style="height:20% !important;">
                                    </div>
                                </div>
                            </td>
                            <td class="td-actions text-right">
                                <a href="{{ route('admin.products.edit', $each->id) }}" rel="tooltip" class="btn btn-success" data-original-title="" title="">
                                    <i class="material-icons">edit</i>
                                </a>
                                <form class="formDelete" action="{{ route('admin.products.delete', $each->id) }}" method="POST" style="display: inline !important;">
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
            url:"{{ route('products.api.search') }}",
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

    const slider2 = document.getElementById('sliderRefine');
    const minPrice = parseInt($("#input-min-price").val());
    const maxPrice = parseInt($("#input-max-price").val());

    noUiSlider.create(slider2, {
        start: [minPrice, maxPrice],
        step: 50000,
        connect: true,
        range: {
            'min': [ {{ $configs['min_price'] }} ],
            'max': [ {{ $configs['max_price'] }} + 400000 ],
        }
    });
    
    let val;
    
    slider2.noUiSlider.on('update', function( values, handle ){
        val = Math.round(values[handle]);
        if (handle){
            $('#span-max-price').text(val);
            $('#input-max-price').val(val);
        } else {
            $('#span-min-price').text(val);
            $('#input-min-price').val(val);
        }
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