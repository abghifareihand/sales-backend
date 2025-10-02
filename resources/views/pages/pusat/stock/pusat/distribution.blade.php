@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Distribusi {{ $stock->product->name }} ke Cabang</h4>
                        <h6>Distribution stock</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('pusat.stock.pusat.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('pusat.stock.pusat.distribution') }}" method="POST">
                @csrf
                <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Produk</label>
                                                <input type="text" class="form-control" value="{{ $stock->product->name }} ({{ $stock->product->provider }} | {{ $stock->product->kuota }} | {{ $stock->product->category }} | {{ $stock->product->zona }})" readonly>
                                                <input type="hidden" name="product_id" value="{{ $stock->product_id }}">
                                                <small class="text-muted">Produk tidak bisa diubah karena stock sudah terdaftar</small>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Stok Pusat Saat Ini</label>
                                                <input type="text" class="form-control" value="{{ $stock->quantity }}" readonly>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Cabang</label>
                                                <select name="branch_id" class="select @error('branch_id') is-invalid @enderror">
                                                    <option value="">Pilih Cabang</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('branch_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Quantity</label>
                                                <input type="number" name="quantity" class="form-control
                                                    @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                                                @error('quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
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
                <div class="col-lg-12">
                    <div class="btn-addproduct mb-4">
                        <a href="{{ route('pusat.stock.pusat.index') }}" class="btn btn-cancel me-2">Batal</a>
                        <button type="submit" class="btn btn-submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
