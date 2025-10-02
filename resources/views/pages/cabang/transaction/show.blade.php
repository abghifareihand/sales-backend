@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Title & Add New Product Button -->
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Detail Transaksi Sales - {{ $transaction->sales->name }}</h4>
                    <h6>Detail sales transaction</h6>
                </div>
            </div>

            <div class="page-btn">
                    <a href="{{ route('cabang.transaction.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>Nama Sales</h4>
                                    <h6>{{ $transaction->sales->name }}</h6>
                                </li>
                                <li>
                                    <h4>Nama Owner</h4>
                                    <h6>{{ $transaction->outlet->name }}</h6>
                                </li>
                                <li>
                                    <h4>Nama Outlet</h4>
                                    <h6>{{ $transaction->outlet->name_outlet }}</h6>
                                </li>
                                <li>
                                    <h4>Alamat Outlet</h4>
                                    <h6>{{ $transaction->outlet->address_outlet }}</h6>
                                </li>
                                <li>
                                    <h4>Tanggal Transaksi</h4>
                                    <h6>{{ \Carbon\Carbon::parse($transaction->created_at)->locale('id')->translatedFormat('d F Y') }}</h6>
                                </li>
                                <li>
                                    <h4>Waktu Transaksi</h4>
                                    <h6>{{ $transaction->created_at->format('H:i') }}</h6>
                                </li>
                                {{-- <li>
                                    <h4>Total Penjualan</h4>
                                    <h6>
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        @php
                                            $approvedEdit = $transaction->edits()->where('status', 'approved')->latest()->first();
                                        @endphp
                                        @if($approvedEdit)
                                            <span class="text-danger">
                                                (Disetujui oleh {{ $approvedEdit->approvedBy->role }})
                                            </span>
                                        @endif
                                    </h6>
                                </li>
                                <li>
                                    <h4>Total Profit</h4>
                                    <h6>
                                        Rp {{ number_format($transaction->profit, 0, ',', '.') }}
                                        @php
                                            $approvedEdit = $transaction->edits()->where('status', 'approved')->latest()->first();
                                        @endphp
                                        @if($approvedEdit)
                                            <span class="text-danger">
                                                (Disetujui oleh {{ $approvedEdit->approvedBy->role }})
                                            </span>
                                        @endif
                                    </h6>
                                </li> --}}

                                <li>
                                    <h4>Total Penjualan</h4>
                                    <h6>
                                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                        @php
                                            $latestApprovedEdit = $transaction->edits->where('status', 'approved')->sortByDesc('created_at')->first();
                                        @endphp
                                        @if($latestApprovedEdit)
                                            <span class="text-primary">
                                                (Sebelumnya Rp {{ number_format($latestApprovedEdit->old_total, 0, ',', '.') }}, Disetujui oleh {{ $latestApprovedEdit->approvedBy->role }})
                                            </span>
                                        @endif
                                    </h6>
                                </li>
                                <li>
                                    <h4>Total Profit</h4>
                                    <h6>
                                        Rp {{ number_format($transaction->profit, 0, ',', '.') }}
                                        @php
                                            $latestApprovedEdit = $transaction->edits->where('status', 'approved')->sortByDesc('created_at')->first();
                                        @endphp
                                        @if($latestApprovedEdit)
                                            <span class="text-primary">
                                                (Sebelumnya Rp {{ number_format($latestApprovedEdit->old_profit, 0, ',', '.') }}, Disetujui oleh {{ $latestApprovedEdit->approvedBy->role }})
                                            </span>
                                        @endif
                                    </h6>
                                </li>
                                <li>
                                    <h4>Titik Lokasi Transaksi</h4>
                                    <h6>{{ $transaction->latitude }}, {{ $transaction->longitude }}</h6>
                                </li>
                                <li>
                                    <h4>Titik Lokasi Outlet</h4>
                                    <h6>{{ $transaction->outlet->latitude }}, {{ $transaction->outlet->longitude }}</h6>
                                </li>
                            </ul>
                            <!-- Embed Google Maps -->
                            <div style="margin-top: 15px;">
                                <iframe
                                    width="100%"
                                    height="300"
                                    style="border:0"
                                    loading="lazy"
                                    allowfullscreen
                                    referrerpolicy="no-referrer-when-downgrade"
                                    src="https://www.google.com/maps?q={{ $transaction->outlet->latitude }},{{ $transaction->outlet->longitude }}&hl=es;z=15&output=embed">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Detail Produk</h4>
                    <h6>Detail sales products</h6>
                </div>
            </div>
        </div>

        <!-- Sales list -->
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
                                <th>Nama Produk</th>
                                <th>Jumlah Terjual</th>
                                <th>Harga Modal (satuan)</th>
                                <th>Harga Jual (satuan)</th>
                                <th>Profit (satuan)</th>
                                <th>Total Penjualan</th>
                                <th>Total Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalProfit = 0;
                            @endphp
                            @foreach($transaction->items as $item)
                            @php
                                $profit = ($item->price - $item->cost_price) * $item->quantity;
                                $totalProfit += $profit;
                                $margin = $item->price - $item->cost_price;
                            @endphp
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->cost_price,0,',','.') }}</td>
                                <td>Rp {{ number_format($item->price,0,',','.') }}</td>
                                <td>Rp {{ number_format($margin,0,',','.') }}</td>
                                <td>Rp {{ number_format($item->price * $item->quantity,0,',','.') }}</td>
                                <td>Rp {{ number_format($profit,0,',','.') }}</td>
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
