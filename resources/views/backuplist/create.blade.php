@extends('layouts.index')
@section('content')
<div class="container">
    <h1 class="mb-4">Database Backup & Restore</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5>Create Backup</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('backup') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Database Backup (GZipped)
                </button>
                <small class="text-muted d-block mt-2">This will create a compressed backup of your database.</small>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Restore Backup</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('restore') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="sql_file" class="form-label">Select Backup File</label>
                    <input type="file" name="sql_file" id="sql_file" class="form-control" required>
                    <div class="form-text">Accepted formats: .sql or .sql.gz (compressed)</div>
                </div>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-upload"></i> Restore Database
                </button>
                <div class="alert alert-warning mt-3">
                    <strong>Warning:</strong> This will overwrite your current database. Make sure you have a backup.
                </div>
            </form>
        </div>
    </div>
</div>
@endsection