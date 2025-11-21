@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Tagihan</h2>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Tagihan</h5>
                    <p><strong>Siswa:</strong> {{ $bill->student->name }}</p>
                    <p><strong>Jumlah:</strong> Rp {{ number_format($bill->amount, 0, ',', '.') }}</p>
                    <p><strong>Jatuh Tempo:</strong> {{ $bill->due_date->format('d/m/Y') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $bill->status === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($bill->status) }}
                        </span>
                    </p>
                    <p><strong>Keterangan:</strong> {{ $bill->description }}</p>
                </div>
            </div>

            @if($bill->payments->count() > 0)
            <hr>
            <h5>Riwayat Pembayaran</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Verifikator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bill->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status === 'verified' ? 'success' : ($payment->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->verified_by ? $payment->verifiedBy->name : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <a href="{{ route('bills.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection