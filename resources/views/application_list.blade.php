@extends('layouts.master')
@section('content')
@php($hideHeader = true)
@php($hideBreadcrumb = true)
<div class="container mt-4">
    <!DOCTYPE html>
<html>
<head>
    <title>Laravel Yajra DataTable Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <style>
        body {
            background: #f7f7fa;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
    </style>
</head>
<body>

<h2 class="text-center my-4">Forms List</h2>

<div class="container">
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <table class="table table-striped table-bordered" id="forms-table" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Applicant Name</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function () {
    $('#forms-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('forms.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'applicant_name', name: 'applicant_name' },
            { data: 'form_status', name: 'form_status' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>

</body>
</html>

@endsection
