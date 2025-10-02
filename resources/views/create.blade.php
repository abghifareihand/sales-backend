@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Back Product Button -->
            <div class="page-header">
                <div class="add-item d-flex align-items-center justify-content-between">
                    <div class="page-title">
                        <h4>New Product</h4>
                        <h6>Create new product</h6>
                    </div>

                    <ul class="table-top-head d-flex align-items-center mb-0">
                        <li class="ms-2">
                            <div class="page-btn">
                                <a href="{{ route('owner.product.index') }}" class="btn btn-secondary">
                                    <i data-feather="arrow-left" class="me-2"></i>Back
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- /add -->
            <form action="add-product">
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {{-- <!-- Baris 1 -->
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Nama Produk</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Provider</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Kategori</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 2 -->
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Zona</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Kuota</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Deskripsi</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 3 -->
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="input-blocks">
                                                    <label>Expired</label>
                                                    <div class="input-groupicon calender-input">
                                                        <i data-feather="calendar" class="info-img"></i>
                                                        <input type="text" class="datetimepicker" placeholder="Pilih Tanggal">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Harga Modal</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Harga Jual</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div> --}}

                                        <!-- Baris 1 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Nama Produk</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Provider</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 2 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Kategori</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Zona</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 3: Deskripsi full width -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-blocks summer-description-box transfer mb-3">
                                                    <label>Deskripsi</label>
                                                    <textarea class="form-control h-100" rows="5"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 4 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Kuota</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="input-blocks">
                                                    <label>Expired</label>
                                                    <div class="input-groupicon calender-input">
                                                        <i data-feather="calendar" class="info-img"></i>
                                                        <input type="text" class="datetimepicker" placeholder="Pilih Tanggal">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 5 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Harga Modal</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Harga Jual</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Dropdown -->
                                        {{-- <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Store</label>
                                                    <select class="select">
                                                        <option>Choose</option>
                                                        <option>Thomas</option>
                                                        <option>Rasmussen</option>
                                                        <option>Fred John</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Category</label>
                                                    <select class="select">
                                                        <option>Choose</option>
                                                        <option>Electronics</option>
                                                        <option>Clothing</option>
                                                        <option>Voucher</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> --}}


                                        <!-- Deskripsi Penuh -->
                                        {{-- <div class="col-lg-12">
                                            <div class="input-blocks summer-description-box transfer mb-3">
                                                <label>Description</label>
                                                <textarea class="form-control h-100" rows="5"></textarea>
                                                <p class="mt-1">Maximum 60 Characters</p>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="btn-addproduct mb-4">
                        <a href="{{ route('owner.product.index') }}" class="btn btn-cancel me-2">Batal</a>
                        <button type="submit" class="btn btn-submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
