@php
use App\Events\ExcelExportEvent;
$count_page = 0;
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
        @foreach ($param['files'] as $file)
            @php
                if($count_page == $param['increments']){
                    $param['count'] += $param['increments'];
                    $status = (($param['count'] / $param["total"]) / $param["tab"]) * 100 * $param['current_tab'];
                    ExcelExportEvent::dispatch($param["user"]->id, $status,  $file->name, $file->path, 'ExcelExport');
                    $count_page = 0;
                }else {
                    $count_page += 1;
                }
            @endphp
            <tr>
                <th style="background-color: #c0c0c0; border: 1px solid #000000; text-left; ">
                    <b>{{ $file->user_name }}</b></th>
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
            @if($param['count']==$param["total"]) 
                @break
            @endif
    @endforeach
</tbody>
</table>
