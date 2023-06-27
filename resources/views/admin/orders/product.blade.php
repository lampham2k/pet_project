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
        </ul>
     </div>
    <div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">assignment</i>
        </div>
        <div class="card-content">
            <h4 class="card-title">{{ $title }}</h4>
            <div class="table-responsive" id="search_list">
                <table class="table" id="tableProduct">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="">Quantity</th>
                            <th class="">Price</th>
                            <th class="">size</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($orderProduct as $each )
                    <tr class="trTable">
                        <td class="text-center">
                            {{ $each->name }}
                        </td>
                        <td class="">
                            {{ $each->pivot->quantity }}
                        </td>
                        <td class="">
                            {{ $each->pivot->price }}
                        </td>
                        @foreach ($arrSize as $idProduct => $sizeName)
                            @if ($idProduct == $each->id)
                            <td class="">
                                {{ $sizeName }}
                            </td>
                            @endif
                        @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
