@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Title & Add New Product Button -->
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Data Transaksi Sales - {{ Auth::user()->branch->name }}</h4>
                    <h6>Manage sales transaction</h6>
                </div>
            </div>

        </div>


        <!-- Product list -->
        <div class="card table-list-card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a href="javascript:void(0);" class="btn btn-searchset">
                                <i data-feather="search" class="feather-search"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive product-list">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>Nama Sales</th>
                                <th>Nama Outlet</th>
                                <th>Total</th>
                                <th>Profit</th>
                                <th>Tanggal</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->sales->name }}</td>
                                <td>{{ $transaction->outlet->name_outlet }}</td>
                                <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaction->profit, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>

                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon p-2" href="{{ route('cabang.transaction.show', $transaction->id) }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <!-- Tombol Ajukan hanya muncul jika belum ada pengajuan -->
                                        @php
                                            $hasEdit = $transaction->edits->isNotEmpty();
                                        @endphp
                                        @if (!$hasEdit)
                                            <a href="{{ route('cabang.transaction.edit', $transaction->id) }}" class="btn btn-sm btn-primary d-flex align-items-center me-2 p-2">
                                                <i data-feather="corner-up-right" style="width:16px; height:16px;"></i>
                                                Ajukan Harga
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // DataTables
    $('.datanew').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });
});
</script>
@endpush
