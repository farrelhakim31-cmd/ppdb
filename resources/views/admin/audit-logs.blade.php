@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Audit Log</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Model</th>
                            <th>ID</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $log->user->name ?? 'System' }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ str_replace('_', ' ', $log->action) }}</span>
                            </td>
                            <td>{{ class_basename($log->model_type) }}</td>
                            <td>{{ $log->model_id }}</td>
                            <td>{{ $log->ip_address }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection