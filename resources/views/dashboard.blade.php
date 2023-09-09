@extends('base')

@section('title', 'Welcome ')

@section('content')
<section class="h-full m-5 rounded-lg bg-slate-200 dark:bg-neutral-700">
    <div class="p-2">
        <h1 class="text-2xl text-center font-bold">Appearance Logs</h1>

        <table id="appearance_log_table" style="text-align: center;">
            <thead>
                <tr>
                    <th style="text-align: center;">Serial Number</th>
                    <th style="text-align: center;">Fullname</th>
                    <th style="text-align: center;">Company</th>
                    <th style="text-align: center;">Inclusive Dates</th>
                    <th style="text-align: center;">Purpose</th>
                    <th style="text-align: center;">Date Issued</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</section>
@endsection

@section('custom_script')
<script>
    $(document).ready(function() {
        // Set datatable
        var table = $('#appearance_log_table').DataTable({
            processing: true,
            serverSide: true,

            ajax: {
                url: '{{ route('admin.appearanceLogs') }}',
            },
            columns: [
                { data: 'serial_number', searchable: false },
                { data: 'fullname' },
                { data: 'company', searchable: false },
                { data: 'formatted_date', searchable: false },
                { data: 'purpose', searchable: false },
                { data: 'date_issued', searchable: false },
                null,
            ],
            columnDefs: [
                {
                    data: 'id',
                    render: function(data, type, full, meta) {
                        return "<a href=\"admin/display/" + data + "\" target=\"_blank\" class=\"bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center\"><svg class=\"w-6 h-6 text-gray-800 dark:text-white\" aria-hidden=\"true\" xmlns=\"http://www.w3.org/2000/svg\" fill=\"currentColor\" viewBox=\"0 0 20 20\"><path d=\"M5 20h10a1 1 0 0 0 1-1v-5H4v5a1 1 0 0 0 1 1Z\"/><path d=\"M18 7H2a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2v-3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2Zm-1-2V2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3h14Z\"/></svg><span>Print</span></a>"
                    },
                    targets: -1
                }
            ]
        });
        // End of datatable 
    });
</script>
@endsection