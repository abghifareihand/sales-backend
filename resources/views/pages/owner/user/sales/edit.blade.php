@extends('layout.mainlayout')
@section('content')
    <div class="page-wrapper">
        <div class="content">

            <!-- Title & Add New Product Button -->
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Edit Akun Sales</h4>
                        <h6>Update user</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('owner.user.sales.index') }}" class="btn btn-added">
                        <i data-feather="arrow-left" class="me-2"></i> Back
                    </a>
                </div>
            </div>

            <form action="{{ route('owner.user.sales.update', $user->id) }}" method="POST">
                @csrf
                 @method('PUT')
                <div class="card">
                    <div class="card-body add-product pb-0">
                        <div class="accordion-card-one accordion" id="accordionExample">
                            <div class="accordion-item">
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Dari Cabang</label>
                                                <select name="branch_id" class="select @error('branch_id') is-invalid @enderror">
                                                    <option value="">Pilih Dari Cabang</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" {{ (old('branch_id', $user->branch_id) == $branch->id) ? 'selected' : '' }}>
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
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="name" class="form-control
                                                    @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Username</label>
                                                <input type="text" name="username" class="form-control
                                                    @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3 add-product">
                                                <label class="form-label">Password</label>
                                                <div class="pass-group">
                                                    <input type="password" name="password" class="form-control pass-input @error('password') is-invalid @enderror" value="">
                                                    <span class="fas toggle-password fa-eye-slash"></span>
                                                </div>
                                                <small class="text-muted">Kosongkan jika tidak diubah</small>
                                                @error('password')
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
                        <a href="{{ route('owner.user.sales.index') }}" class="btn btn-cancel me-2">Batal</a>
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
