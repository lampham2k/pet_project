@extends('layout.master')
@push('css')
<style>
    .card-testimonial {
        margin-bottom: 12px !important;
    }
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>
@endpush
@section('content')
<div class="col-md-12">
    {{-- <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <a href="{{ route('admin.manufacturers.create') }}" class="btn">Add {{ $title }}</a>
            </li>
            <li>
                <div class="form-group form-search is-empty">
                    <input type="text" class="form-control" placeholder="Search anything" style="margin:25px !important;" name="search" id="search" onfocus="this.value=''">
                    <span class="material-input"></span>
                <span class="material-input"></span></div>
            </li>
        </ul>
     </div> --}}
    <div class="card">
        <div class="card-header card-header-icon" data-background-color="rose">
            <i class="material-icons">assignment</i>
        </div>
        <div class="card-content">
            <h4 class="card-title">Statistical</h4>
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: '{{ route('admin.chart.statistical') }}',
            dataType: 'json',
            // data: {days},
        })
        .done(function(response){

            const arr = Object.values(response[0]);

            const arrDetail = [];

            Object.values(response[1]).forEach((each) => {

                each.data = Object.values(each.data);

                arrDetail.push(each);
            })

            setTimeout(function() {getChart(arr,arrDetail)}, 1000);
        });
    });

    function getChart(arr, arrDetail) {
        Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: 'total number of products sold in the last 30 days'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total market share'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:f}</b> of total<br/>'
        },

        series: [
            {
                name: 'Products',
                colorByPoint: true,
                data: arr
            }
        ],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: arrDetail
        }
    });
}
</script>
@endpush