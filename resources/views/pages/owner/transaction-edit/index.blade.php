@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Title & Add New Product Button -->
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Data Pengajuan Harga Transaksi</h4>
                    <h6>Manage transaction</h6>
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
                                <th>Asal Cabang</th>
                                <th>Nama Outlet</th>
                                <th>Total Awal</th>
                                <th>Profit Awal</th>
                                <th>Total Edit</th>
                                <th>Profit Edit</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->sales->name }}</td>
                                <td>{{ $transaction->sales->branch->name }}</td>
                                <td>{{ $transaction->outlet->name_outlet }}</td>
                                <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($transaction->profit, 0, ',', '.') }}</td>
                                @php
                                    $edit = $transaction->edits->last();
                                @endphp
                                {{-- Edit Total --}}
                                <td>
                                    @if($edit)
                                        Rp {{ number_format($edit->edit_total, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- Edit Profit --}}
                                <td>
                                    @if($edit)
                                        Rp {{ number_format($edit->edit_profit, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($edit)
                                        <span class="badge badge-{{ $edit->status == 'pending' ? 'warning' : ($edit->status == 'approved' ? 'success' : 'danger') }}">
                                            {{ ucfirst($edit->status) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        @if($edit && $edit->status == 'pending')
                                            <form action="{{ route('owner.transaction.approve.edit', $edit->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success d-flex align-items-center me-2 p-2">
                                                    Terima
                                                </button>
                                            </form>
                                            <form action="{{ route('owner.transaction.reject.edit', $edit->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center me-2 p-2">
                                                    Tolak
                                                </button>
                                            </form>
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
