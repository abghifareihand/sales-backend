@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Tambah Stock Pusat</h4>
                        <h6>Create new stocks</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('pusat.stock.pusat.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('pusat.stock.pusat.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Produk</label>
                                                <select name="product_id" class="select">
                                                    <option value="">Pilih Produk</option>
                                                    @foreach($products as $product)
                                                        @php
                                                            $currentStock = $product->stocks
                                                                            ->where('branch_id', null)
                                                                            ->where('sales_id', null)
                                                                            ->first();
                                                        @endphp
                                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}
                                                            ({{ $product->provider }} | {{ $product->kuota }} | {{ $product->category }} | {{ $product->zona }})
                                                            @if($product->expired)
                                                                (Expired: {{ \Carbon\Carbon::parse($product->expired)->format('d/m/Y') }})
                                                            @endif
                                                            @if($currentStock)
                                                                (Stok: {{ $currentStock->quantity }})
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                 @error('product_id')
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
