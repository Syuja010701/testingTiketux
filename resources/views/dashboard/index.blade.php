@extends('layouts.main')
@section('title','Dahsboard')
@push('style')
    <style>
        table > thead > tr > th{
            background-color: yellow !important;
        }
    </style>
@endpush
@section('content')
<h1 class="mb-3">Halaman Dashboard</h1>
    <a class=" btn btn-xl  btn-success " href="{{ route('export.excel') }}">
        <iconify-icon icon="vscode-icons:file-type-excel"></iconify-icon>
        Download Excel Profit/Loss
    </a>
<div class="row align-items-center" style="height: 60vh">

    <div class="col-md-6 p-6 bg-white rounded mb-3">
        {!! $chart->container() !!}
    </div>
    <div class="col-md-6 p-6 bg-white rounded mb-3">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center align-middle">Category</th>
                    @foreach($finalData as $key => $data)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($finalData as $item)
                        <th>Amount</th>
                    @endforeach
                </tr>
            </thead>

            @foreach($categories as $index => $category)
                <tr>
                    <td class="{{ $categoryColors[$index] }}">{{ $category }}</td>
                    @foreach($finalData as $data)
                        <td class="{{ $categoryColors[$index] }}" style="background-color: red">{{ $data[$category] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>
</div>

@endsection
@push('script')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endpush
