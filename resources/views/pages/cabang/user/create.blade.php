@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Tambah Akun Sales</h4>
                        <h6>Create new user</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('cabang.user.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('cabang.user.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="name" class="form-control
                                                    @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Username</label>
                                                <input type="text" name="username" class="form-control
                                                    @error('username') is-invalid @enderror" value="{{ old('username') }}">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Password</label>
                                                <div class="pass-group">
                                                    <input type="password" name="password" class="form-control pass-input @error('password') is-invalid @enderror" value="{{ old('password') }}">
                                                    <span class="fas toggle-password fa-eye-slash"></span>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Cabang</label>
                                                <input type="text" class="form-control"
                                                    value="{{ Auth::user()->branch->name }}" readonly>
                                                <small class="text-muted">Cabang ini otomatis terhubung dengan akun sales</small>
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
                        <a href="{{ route('cabang.user.index') }}" class="btn btn-cancel me-2">Batal</a>
                        <button type="submit" class="btn btn-submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleIcons = document.querySelectorAll(".toggle-password");
        toggleIcons.forEach(function(icon) {
            icon.addEventListener("click", function() {
                const input = this.parentElement.querySelector(".pass-input");
                if (input.type === "password") {
                    input.type = "text";
                    this.classList.remove("fa-eye-slash");
                    this.classList.add("fa-eye");
                } else {
                    input.type = "password";
                    this.classList.remove("fa-eye");
                    this.classList.add("fa-eye-slash");
                }
            });
        });
    });
</script>
@endpush
