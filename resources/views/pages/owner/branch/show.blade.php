@extends('layout.mainlayout')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <!-- Title & Add New Product Button -->
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Detail Cabang</h4>
                    <h6>Detail your branches</h6>
                </div>
            </div>

            <div class="page-btn">
                    <a href="{{ route('owner.branch.index') }}" class="btn btn-added">
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
                                    <h4>Nama Cabang</h4>
                                    <h6>{{ $branch->name }}</h6>
                                </li>
                                <li>
                                    <h4>Alamat Cabang</h4>
                                    <h6>{{ $branch->address }}</h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Sales Cabang</h4>
                    <h6>Detail your sales</h6>
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
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role }}</td>
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
