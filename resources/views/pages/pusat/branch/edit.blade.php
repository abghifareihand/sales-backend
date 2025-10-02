@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Edit Cabang</h4>
                        <h6>Update branch</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('pusat.branch.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('pusat.branch.update', $branch->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <!-- Baris 1 -->
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Nama Cabang</label>
                                                <input type="text" name="name" class="form-control
                                                    @error('name') is-invalid @enderror" value="{{ old('name', $branch->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Alamat Cabang</label>
                                                <input type="text" name="address" class="form-control
                                                    @error('address') is-invalid @enderror" value="{{ old('address', $branch->address) }}">
                                                @error('address')
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
                        <a href="{{ route('pusat.branch.index') }}" class="btn btn-cancel me-2">Batal</a>
                        <button type="submit" class="btn btn-submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
