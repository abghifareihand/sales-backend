<?php $page = 'product-details'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <!-- Title & Back Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Product Details</h4>
                        <h6>Full details of a produc</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('pusat.product.index') }}" class="btn btn-added">
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
                                        <h4>Product</h4>
                                        <h6>{{ $product->name }}</h6>
                                    </li>
                                    <li>
                                        <h4>Provider</h4>
                                        <h6>{{ $product->provider }}</h6>
                                    </li>
                                    <li>
                                        <h4>Kategori</h4>
                                        <h6>{{ $product->category }}</h6>
                                    </li>
                                    <li>
                                        <h4>Zona</h4>
                                        <h6>{{ $product->zona }}</h6>
                                    </li>
                                    <li>
                                        <h4>Deskripsi</h4>
                                        <h6>{{ $product->description }}</h6>
                                    </li>
                                    <li>
                                        <h4>Kuota</h4>
                                        <h6>{{ $product->kuota }}</h6>
                                    </li>
                                    <li>
                                        <h4>Expired</h4>
                                        <h6>{{ \Carbon\Carbon::parse($product->expired)->translatedFormat('l, d F Y') }}</h6>
                                    </li>
                                    <li>
                                        <h4>Harga Modal</h4>
                                        <h6>Rp {{ number_format($product->cost_price, 0, ',', '.') }}</h6>
                                    </li>
                                    <li>
                                        <h4>Harga Jual</h4>
                                        <h6>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</h6>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
