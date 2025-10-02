@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Perubahan Total Harga Transaksi</h4>
                        <h6>Update total price</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('cabang.transaction.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('cabang.transaction.update', $transaction->id) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Total Harga Transaksi</label>
                                                <input type="text" class="form-control"
                                                    value="Rp {{ number_format($transaction->total, 0, ',', '.') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Input Perubahan Harga</label>
                                                <input type="number" name="edit_total" class="form-control
                                                    @error('edit_total') is-invalid @enderror" value="{{ old('edit_total') }}">
                                                @error('edit_total')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Alasan Perubahan Harga</label>
                                                <input type="text" name="edit_reason" class="form-control
                                                    @error('edit_reason') is-invalid @enderror" value="{{ old('edit_reason') }}">
                                                @error('edit_reason')
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
                        <a href="{{ route('cabang.transaction.index') }}" class="btn btn-cancel me-2">Batal</a>
                        <button type="submit" class="btn btn-submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
