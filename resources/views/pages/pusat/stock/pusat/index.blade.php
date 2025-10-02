@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Title & Add New Product Button -->
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Data Stock Pusat</h4>
                    <h6>Manage your stocks</h6>
                </div>
            </div>

            <div class="page-btn">
                <a href="{{ route('pusat.stock.pusat.create') }}" class="btn btn-added">
                    <i data-feather="plus-circle" class="me-2"></i> Tambah Stock
                </a>
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
                                <th>Produk</th>
                                <th>Provider</th>
                                <th>Kategori</th>
                                <th>Quantity</th>
                                <th>Zona</th>
                                <th>Kuota</th>
                                <th>Expired</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stocks as $stock)
                            <tr>
                                <td>{{ $stock->product->name }}</td>
                                <td>{{ $stock->product->provider }}</td>
                                <td>{{ $stock->product->category }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>{{ $stock->product->zona }}</td>
                                <td>{{ $stock->product->kuota }}</td>
                                <td>{{ \Carbon\Carbon::parse($stock->product->expired)->locale('id')->translatedFormat('d M Y') }}</td>
                                <td>Rp {{ number_format($stock->product->cost_price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($stock->product->selling_price, 0, ',', '.') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon p-2" href="{{ route('pusat.stock.pusat.edit', $stock->id) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a href="{{ route('pusat.stock.pusat.distribution.form', $stock->id) }}" class="btn btn-sm btn-primary d-flex align-items-center me-2 p-2">
                                            <i data-feather="corner-up-right" style="width:16px; height:16px; margin-right:4px;"></i>
                                            Kirim ke Cabang
                                        </a>
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
