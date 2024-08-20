@use(App\Events\ExcelExportEvent)
@php
    $count = 0;
    $status = ($param['count'] / 3 / $param['tab']) * 100;
    ExcelExportEvent::dispatch(
        $param['user']->id,
        $status,
        $param['export_name'],
        $param['export_path'],
        'ExcelExport',
    );
    $param['count'] += 1;
@endphp
<table class='table table-bordered table-striped  table-condensed mb-none' style="table-layout: auto">
    <thead>
        <tr>
            <th style="background-color: #c0c0c0; border: 1px solid #000000; text-left;"><b>User</b></th>
            <th style="background-color: #c0c0c0; border: 1px solid #000000; text-align: center;"><b>Name</b></th>
            <th style="background-color: #c0c0c0; border: 1px solid #000000; text-align: center;"><b>Path</b></th>
            <th style="background-color: #c0c0c0; border: 1px solid #000000; text-align: center;"><b>Created At</b></th>
            <th style="background-color: #c0c0c0; border: 1px solid #000000; text-align: center;"><b>Updated At</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($files as $file)
            @php
                if ($count * 2 == $param['max']) {
                    $status = ($param['count'] / 3 / $param['tab']) * 100;
                    ExcelExportEvent::dispatch($param['user']->id, $status, $file->name, $file->path, 'ExcelExport');
                    $param['count'] += 1;
                }
                $count += 1;
            @endphp
            <tr>
                <th style="background-color: #c0c0c0; border: 1px solid #000000; text-left; ">
                    <b>{{ $file->user_name }}</b>
                </th>
                <td
                    style="background-color: #ffffff; border: 1px solid #000000;word-break: break-all; text-align: center">
                    {{ $file->name }}</td>
                <td
                    style="background-color: #ffffff; border: 1px solid #000000;word-break: break-all; text-align: center">
                    {{ $file->path }}</td>
                <td
                    style="background-color: #ffffff; border: 1px solid #000000;word-break: break-all; text-align: center">
                    {{ $file->created_at }}</td>
                <td
                    style="background-color: #ffffff; border: 1px solid #000000;word-break: break-all; text-align: center">
                    {{ $file->updated_at }}</td>
            </tr>
            @if ($count == $param['max'])
                @break
            @endif
    @endforeach
    @php
        $status = ($param['count'] / 3 / $param['tab']) * 100;
        $param['count'] += 1;
        ExcelExportEvent::dispatch(
            $param['user']->id,
            $status,
            $param['export_name'],
            $param['export_path'],
            'ExcelExport',
        );
    @endphp
    </tbody>
</table>
