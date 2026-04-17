@props(['headers' => [], 'rows' => [], 'striped' => false])

<div class="table-responsive card p-0">
    <table class="data-table">
        @if(count($headers) > 0)
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
