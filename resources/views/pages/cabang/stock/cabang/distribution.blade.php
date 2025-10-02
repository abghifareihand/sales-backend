@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Distribusi {{ $stock->product->name }} ke Sales</h4>
                        <h6>Distribution stock</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('cabang.stock.cabang.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('cabang.stock.cabang.distribution') }}" method="POST">
                @csrf
                <input type="hidden" name="stock_id" value="{{ $stock->id }}">
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
                                                    <label class="form-label">Asal Cabang</label>
                                                    <input type="text" class="form-control" value="{{ $stock->branch->name }}" readonly>
                                                    <small class="text-muted">Cabang tidak bisa diubah karena cabang sudah terdaftar</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Produk</label>
                                                    <input type="text" class="form-control" value="{{ $stock->product->name }} ({{ $stock->product->provider }} | {{ $stock->product->kuota }} | {{ $stock->product->category }} | {{ $stock->product->zona }})" readonly>
                                                    <input type="hidden" name="product_id" value="{{ $stock->product_id }}">
                                                    <small class="text-muted">Produk tidak bisa diubah karena stock sudah terdaftar</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 2 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Stok Cabang Saat Ini</label>
                                                    <input type="text" class="form-control" value="{{ $stock->quantity }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Pilih Sales</label>
                                                    <select name="sales_id" class="select @error('sales_id') is-invalid @enderror">
                                                        <option value="">Pilih Sales</option>
                                                        @foreach($sales as $s)
                                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('sales_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Baris 3 -->
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Quantity</label>
                                                    <input type="number" name="quantity" class="form-control
                                                        @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                                                    @error('quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-6 col-12">
                                                <div class="mb-3 add-product">
                                                    <label class="form-label">Catatan</label>
                                                    <input type="text" name="notes" class="form-control
                                                        @error('notes') is-invalid @enderror" value="{{ old('notes') }}">
                                                    @error('notes')
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
                        <a href="{{ route('cabang.stock.cabang.index') }}" class="btn btn-cancel me-2">Batal</a>
                        <button type="submit" class="btn btn-submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
