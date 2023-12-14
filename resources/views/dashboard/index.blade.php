@extends('layouts.main')
@section('title', 'Dahsboard')
@push('style')
    <style>
        table>thead>tr>th {
            background-color: yellow !important;
        }
    </style>
@endpush
@section('content')
    <h1 class="mb-3">Dashboard</h1>
    <div class="mb-3">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#table">Table</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#grafik">Grafik</a>
            </li>
            <li class="nav-item">
                <a class=" nav-link  btn-success " href="{{ route('export.excel') }}">
                    <iconify-icon icon="vscode-icons:file-type-excel"></iconify-icon>
                    Download Excel Profit/Loss
                </a>
            </li>
        </ul>
    </div>


    <!-- Tab panes -->
    <div class="tab-content">
        <div id="table" class="container tab-pane active"><br>
            <h3>Table Profit / Loss</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center align-middle">Category</th>
                        @foreach ($finalData as $key => $data)
                            <th>{{ $key }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($finalData as $item)
                            <th>Amount</th>
                        @endforeach
                    </tr>
                </thead>

                @foreach ($categories as $index => $category)
                    <tr>
                        <td class="{{ $categoryColors[$index] }}">{{ $category }}</td>
                        @foreach ($finalData as $data)
                            <td class="{{ $categoryColors[$index] }}" style="background-color: red">
                                {{ $data[$category] }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
        <div id="grafik" class="container tab-pane fade border "><br>
            <h3>Grafik Profit / Loss</h3>
            {!! $chart->container() !!}
        </div>
    </div>

@endsection
@push('script')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endpush
