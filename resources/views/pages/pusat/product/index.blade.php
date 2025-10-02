@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Title & Add New Product Button -->
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Data Produk</h4>
                    <h6>Manage your products</h6>
                </div>
            </div>

            <div class="page-btn">
                <a href="{{ route('pusat.product.create') }}" class="btn btn-added">
                    <i data-feather="plus-circle" class="me-2"></i> Tambah Produk
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
                                <th>Nama</th>
                                <th>Provider</th>
                                <th>Kategori</th>
                                <th>Zona</th>
                                <th>Kuota</th>
                                <th>Expired</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->provider }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->zona }}</td>
                                <td>{{ $product->kuota }}</td>
                                {{-- <td>{{ \Carbon\Carbon::parse($product->expired)->format('d M Y') }}</td> --}}
                                <td>{{ \Carbon\Carbon::parse($product->expired)->locale('id')->translatedFormat('d M Y') }}</td>
                                <td>Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon p-2" href="{{ route('pusat.product.show', $product->id) }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="me-2 edit-icon p-2" href="{{ route('pusat.product.edit', $product->id) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="me-2 edit-icon p-2 text-danger" href="javascript:void(0);" onclick="document.getElementById('delete-form-{{ $product->id }}').submit();">
                                            <i data-feather="trash-2"></i>
                                        </a>
                                        <!-- Form delete tetap disembunyikan -->
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('pusat.product.destroy', $product->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
