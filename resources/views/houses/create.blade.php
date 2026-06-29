@extends('components.layouts.dashboard')
@section('title', 'Create Renter')
@section('content')

    <div class="pagetitle">
        <h1>Create Renter</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Create Renter</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('houses.store') }}" method="POST">
                            @csrf

                            <h6 class="text-muted text-uppercase small mb-3">Renter</h6>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-muted text-uppercase small mb-3">House &amp; Charges</h6>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">House / Unit <span class="text-danger">*</span></label>
                                    <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit') }}" placeholder="e.g. House A-12" required>
                                    @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Monthly Rent <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="rent_amount" class="form-control @error('rent_amount') is-invalid @enderror" value="{{ old('rent_amount') }}" min="0" step="0.01" required>
                                    </div>
                                    @error('rent_amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Water / WASA <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="water_amount" class="form-control @error('water_amount') is-invalid @enderror" value="{{ old('water_amount') }}" min="0" step="0.01" required>
                                    </div>
                                    @error('water_amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Security Deposit</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="security_deposit" class="form-control @error('security_deposit') is-invalid @enderror" value="{{ old('security_deposit', 0) }}" min="0" step="0.01">
                                    </div>
                                    @error('security_deposit') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Advance Money</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="advance_amount" class="form-control @error('advance_amount') is-invalid @enderror" value="{{ old('advance_amount', 0) }}" min="0" step="0.01">
                                    </div>
                                    @error('advance_amount') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-muted text-uppercase small mb-3">Utilities</h6>

                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Electric Meter Number</label>
                                    <input type="text" name="electric_meter_number" class="form-control" value="{{ old('electric_meter_number') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Electric Account Number</label>
                                    <input type="text" name="electric_account_number" class="form-control" value="{{ old('electric_account_number') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Gas Meter Number</label>
                                    <input type="text" name="gas_meter_number" class="form-control" value="{{ old('gas_meter_number') }}">
                                </div>
                            </div>

                            <hr>
                            <h6 class="text-muted text-uppercase small mb-3">Lease &amp; Status</h6>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Lease Start</label>
                                    <input type="date" name="lease_start" class="form-control @error('lease_start') is-invalid @enderror" value="{{ old('lease_start') }}">
                                    @error('lease_start') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Lease End</label>
                                    <input type="date" name="lease_end" class="form-control @error('lease_end') is-invalid @enderror" value="{{ old('lease_end') }}">
                                    @error('lease_end') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        @foreach (['active' => 'Active', 'pending' => 'Pending', 'expired' => 'Expired'] as $value => $label)
                                            <option value="{{ $value }}" @selected(old('status', 'active') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('houses.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Save Renter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

@endsection
