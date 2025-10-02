@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Tambah Produk</h4>
                        <h6>Create new product</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('owner.product.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('owner.product.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <!-- Baris 1 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Nama Produk</label>
                                                    <input type="text" name="name" class="form-control
                                                        @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Provider</label>
                                                    <input type="text" name="provider" class="form-control
                                                        @error('provider') is-invalid @enderror" value="{{ old('provider') }}">
                                                    @error('provider')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 2 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Kategori</label>
                                                    <input type="text" name="category" class="form-control
                                                        @error('category') is-invalid @enderror" value="{{ old('category') }}">
                                                    @error('category')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Zona</label>
                                                    <input type="text" name="zona" class="form-control
                                                        @error('zona') is-invalid @enderror" value="{{ old('zona') }}">
                                                    @error('zona')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 3: Deskripsi full width -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-blocks summer-description-box transfer mb-3">
                                                    <label>Deskripsi</label>
                                                    <textarea name="description" class="form-control
                                                        @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 4 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Kuota</label>
                                                    <input type="text" name="kuota" class="form-control
                                                        @error('kuota') is-invalid @enderror" value="{{ old('kuota') }}">
                                                    @error('kuota')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="input-blocks">
                                                    <label>Expired</label>
                                                    <div class="input-groupicon calender-input">
                                                        <i data-feather="calendar" class="info-img"></i>
                                                        <input type="text"
                                                            name="expired"
                                                            class="datetimepicker form-control @error('expired') is-invalid @enderror"
                                                            placeholder="Pilih Tanggal"
                                                            value="{{ old('expired') }}">
                                                    </div>
                                                    @error('expired')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 5 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Harga Modal</label>
                                                    <input type="number" name="cost_price" class="form-control
                                                        @error('cost_price') is-invalid @enderror" value="{{ old('cost_price') }}">
                                                    @error('cost_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Harga Jual</label>
                                                    <input type="number" name="selling_price" class="form-control
                                                        @error('selling_price') is-invalid @enderror" value="{{ old('selling_price') }}">
                                                    @error('selling_price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

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
