<table class="table table-bordered" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th rowspan="2" class="text-center align-middle" style="background-color: #ffff00">Category</th>
            @foreach($finalData as $key => $data)
                <th style="background-color: #ffff00">{{ $key }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($finalData as $item)
                <th style="background-color: #ffff00">Amount</th>
            @endforeach
        </tr>
    </thead>

    @foreach($categories as $index => $category)
        <tr>
            <td class="{{ $categoryColors[$index] }}" style="background-color: {{ $categoryColors[$index] }}" >{{ $category }}</td>
            @foreach($finalData as $data)
                <td class="{{ $categoryColors[$index] }}" style="background-color: {{ $categoryColors[$index] }}">{{ $data[$category] }}</td>
            @endforeach
        </tr>
    @endforeach
</table>