@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Welcome -->
        <div class="welcome d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center welcome-text">
                <h3 class="d-flex align-items-center">
                    Halo {{ auth()->user()->name }}
                </h3>
            </div>
            <div class="d-flex align-items-center">
                {{-- <div class="position-relative daterange-wraper me-2">
                    <div class="input-groupicon calender-input">
                        <input type="text" class="form-control date-range bookingrange" placeholder="Select">
                    </div>
                    <i data-feather="calendar" class="feather-14"></i>
                </div>
                <button type="button" class="btn btn-white-outline d-none d-md-inline-block">
                    <i data-feather="rotate-ccw" class="feather-16"></i>
                </button> --}}
                <a href="#" class="d-none d-lg-inline-block" id="collapse-header"><i data-feather="chevron-up" class="feather-16"></i></a>
            </div>
        </div>

        <!-- Cards: Total Sales, Total Revenue, Total Profit, Total Asset -->
        <div class="row sales-cards">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card color-info bg-primary mb-4">
                    <img src="{{ URL::asset('/build/img/icons/total-sales.svg') }}" alt="img">
                    <h3 class="counters">{{ $totalProductsSold }}</h3>
                    <p>Total Produk Terjual</p>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card color-info bg-secondary mb-4">
                    <img src="{{ URL::asset('/build/img/icons/total-sales.svg') }}" alt="img">
                    <h3 class="counters">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card color-info bg-success mb-4">
                    <img src="{{ URL::asset('/build/img/icons/total-sales.svg') }}" alt="img">
                    <h3 class="counters">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                    <p>Total Profit</p>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card color-info bg-info mb-4">
                    <img src="{{ URL::asset('/build/img/icons/total-sales.svg') }}" alt="img">
                    <h3 class="counters">Rp {{ number_format($totalAsset, 0, ',', '.') }}</h3>
                    <p>Total Aset</p>
                </div>
            </div>
        </div>


        <!-- Best Seller & Recent Transactions -->
        <div class="row">
            <!-- Best Seller -->
            <div class="col-sm-12 col-md-12 col-xl-4 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Produk Terlaris</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Produk</th>
                                        <th>Total Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bestSellers as $index => $bs)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $bs->name }}</td>
                                        <td>{{ $bs->total_sold }}</td>
                                    </tr>
                                    @endforeach
                                    @if($bestSellers->isEmpty())
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data produk terlaris</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Recent Transactions -->
            <div class="col-sm-12 col-md-12 col-xl-8 d-flex">
                <div class="card flex-fill default-cover w-100 mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Transaksi Terkini</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Produk Detail</th>
                                        <th>Cabang / Sales</th>
                                        <th>Penjualan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $index => $tx)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @foreach($tx->items as $item)
                                                {{ $item->product->name }} (x{{ $item->quantity }})<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $tx->branch->name ?? 'Pusat' }} / {{ $tx->sales->name }}</td>

                                        <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($tx->created_at)->locale('id')->translatedFormat('d M Y') }}</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data transaksi terkini</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Sales -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="card flex-fill default-cover mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Top Sales</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Sales</th>
                                        <th>Asal Cabang</th>
                                        <th>Total Pendapatan</th>
                                        <th>Total Profit</th>
                                        <th>Jumlah Produk Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topSales as $sales)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sales->sales->name ?? '-' }}</td>
                                            <td>{{ $sales->branch->name ?? '-' }}</td>
                                            <td>Rp {{ number_format($sales->total_revenue, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($sales->total_profit, 0, ',', '.') }}</td>
                                            <td>{{ $sales->total_products }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data top sales</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Expired -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="card flex-fill default-cover mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Product Expired</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Provider</th>
                                        <th>Kategori</th>
                                        <th>Kuota</th>
                                        <th>Expired</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expiredProducts as $index => $product)
                                    @php
                                        $daysLeft = \Carbon\Carbon::now()->diffInDays($product->expired, false);

                                        if ($daysLeft < 0) {
                                            // Sudah kadaluarsa
                                            $badge = 'secondary';
                                        } elseif ($daysLeft <= 14) {
                                            // Kurang dari atau sama dengan 2 minggu
                                            $badge = 'danger';
                                        } elseif ($daysLeft <= 30) {
                                            // Kurang dari atau sama dengan 1 bulan
                                            $badge = 'warning';
                                        } else {
                                            // Aman
                                            $badge = 'success';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->provider }}</td>
                                        <td>{{ $product->category }}</td>
                                        <td>{{ $product->kuota }}</td>
                                        <td>
                                            <span class="badge bg-{{ $badge }}">
                                                {{ \Carbon\Carbon::parse($product->expired)->format('d-m-Y') }}
                                            </span>
                                        </td>
                                    </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data produk expired</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Stock Summary -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="card flex-fill default-cover mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Sisa Stock</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Pusat</th>
                                        <th>Cabang</th>
                                        <th>Sales</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockSummary as $index => $stock)
                                    <tr>
                                         <td>{{ $index + 1 }}</td>
                                        <td>{{ $stock['product'] }}</td>
                                        <td>{{ $stock['pusat'] }}</td>
                                        <td>{{ $stock['cabang'] }}</td>
                                        <td>{{ $stock['sales'] }}</td>
                                        <td>{{ $stock['total'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
