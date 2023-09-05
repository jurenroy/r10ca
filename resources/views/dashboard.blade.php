@extends('base')

@section('title', 'Welcome ')

@section('content')
<section class="h-full m-5 rounded-lg bg-slate-200 dark:bg-neutral-700">
    <div class="py-2">
        <h1 class="text-2xl text-center font-bold">Appearance Logs</h1>

        <table id="appearance_log_table">
            <thead>
                <th>Serial Number</th>
                <th>Fullname</th>
                <th>Company</th>
                <th>Inclusive Dates</th>
                <th>Purpose</th>
                <th>Date Issued</th>
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
        $('#appearance_log_table').DataTable();
    });
</script>
@endsection