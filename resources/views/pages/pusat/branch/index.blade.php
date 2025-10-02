@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Title & Add New Product Button -->
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Data Cabang</h4>
                    <h6>Manage your branches</h6>
                </div>
            </div>

            <div class="page-btn">
                <a href="{{ route('pusat.branch.create') }}" class="btn btn-added">
                    <i data-feather="plus-circle" class="me-2"></i> Tambah Cabang
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
                                <th>Nama Cabang</th>
                                <th>Alamat Cabang</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                            <tr>
                                <td>{{ $branch->name }}</td>
                                <td>{{ $branch->address }}</td>
                                <td class="action-table-data">
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon p-2" href="{{ route('pusat.branch.show', $branch->id) }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="me-2 edit-icon p-2" href="{{ route('pusat.branch.edit', $branch->id) }}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="me-2 edit-icon p-2 text-danger" href="javascript:void(0);" onclick="document.getElementById('delete-form-{{ $branch->id }}').submit();">
                                            <i data-feather="trash-2"></i>
                                        </a>
                                        <!-- Form delete tetap disembunyikan -->
                                        <form id="delete-form-{{ $branch->id }}" action="" method="POST" style="display:none;">
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
