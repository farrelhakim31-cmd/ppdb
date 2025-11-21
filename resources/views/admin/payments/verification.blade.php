@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Verifikasi Pembayaran</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>
                                @if($payment->student)
                                    {{ $payment->student->name }}
                                @elseif($payment->ppdbRegistration)
                                    {{ $payment->ppdbRegistration->name }}
                                    <small class="text-muted d-block">PPDB: {{ $payment->ppdbRegistration->registration_number }}</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                            <td>
                                @if($payment->payment_proof)
                                <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ ucfirst($payment->status) }}</span>
                            </td>
                            <td>
                                <form action="{{ route('payments.verify', $payment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                                </form>
                                <form action="{{ route('payments.verify', $payment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection