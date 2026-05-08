@extends('layouts.app')

@section('content')
    {{-- <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Administrasi Platform | AI Evaluation Log</h3>
        <a href="{{ route('queue.create') }}" class="btn btn-success">+ Tambah Antrean</a>
    </div> --}}

    {{-- FILTER --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-2">
            <input type="text" name="keyword" class="form-control" placeholder="Cari ID/Nama/Siswa"
                value="{{ request('keyword') }}">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="finish" {{ request('status') == 'finish' ? 'selected' : '' }}>Finish</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}"
                placeholder="From Date">
        </div>
        <div class="col-md-2">
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}"
                placeholder="To Date">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('queue.logs') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <p><strong>Total: {{ $total }} log(s)</strong></p>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>AI Answer</th>
                    <th>Status</th>
                    <th>Error Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->queue->student_id ?? '-' }}</td>
                        <td>{{ $log->queue->student_name ?? '-' }}</td>
                        <td>{{ $log->queue->question ?? '-' }}</td>
                        <td>{!! $log->queue->student_answer ?? '-' !!}</td>
                        <td>{{ $log->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }} WIB</td>
                        <td>{{ $log->updated_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') }} WIB</td>
                        <td>
                            @if ($log->status == 'finish')
                                <strong>Score:</strong> {{ $log->score }} / 100<br>
                                <strong>Feedback:</strong> {{ $log->feedback }}<br>
                                <strong>Confidence:</strong> {{ $log->confidence }}%
                            @else
                                {{ $log->ai_response ?? '-' }}
                            @endif
                        </td>
                        <td>
                            @if ($log->status == 'finish')
                                <span class="badge bg-success">Completed</span>
                            @elseif($log->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </td>
                        <td>{{ $log->error_message ?? '-' }}</td>
                        <td>
                            @if ($log->status == 'failed')
                                <a href="{{ route('queue.logs.retry', $log->id) }}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Retry antrean ini?')">Retry</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Tidak ada data log</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $logs->links() }}
@endsection
