@extends('admin.layouts.app')
@section('title', 'Settings')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Settings</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings') }}" method="POST">
        @csrf

        <div class="card card-body mb-3">
            <h4>Contact Information</h4>
            <p class="text-muted">This info will be displayed on the web site.</p>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Email <em>*</em></label>
                        <input type="email" value="{{ old('contact_email', $settings['contact_email']) }}"
                               class="form-control @error('contact_email') is-invalid @enderror"
                               name="contact_email">
                        @error('contact_email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Phone <em>*</em> </label>
                        <input type="text" value="{{ old('contact_phone', $settings['contact_phone']) }}"
                               class="form-control @error('contact_phone') is-invalid @enderror"
                               name="contact_phone">
                        @error('contact_phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Poste <em>*</em></label>
                        <input type="text" value="{{ old('post', $settings['post']) }}"
                               class="form-control @error('post') is-invalid @enderror"
                               name="post">
                        @error('post')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Zip Code <em>*</em></label>
                        <input type="text" value="{{ old('zip_code', $settings['zip_code']) }}"
                               class="form-control @error('zip_code') is-invalid @enderror"
                               name="zip_code">
                        @error('zip_code')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Address <em>*</em></label>
                        <input type="text" value="{{ old('address', $settings['address']) }}"
                               class="form-control @error('address') is-invalid @enderror"
                               name="address">
                        <small class="d-block text-muted">This email will be used to notify about events on the site.</small>
                        @error('address')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Local <em>*</em></label>
                        <input type="text" value="{{ old('local', $settings['local']) }}"
                               class="form-control @error('local') is-invalid @enderror"
                               name="local">
                        <small class="d-block text-muted">This email will be used to notify about events on the site.</small>
                        @error('local')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>



        <div class="text-right mb-4">
            <button type="submit" class="btn btn-info">Save Changes</button>
        </div>
    </form>
@endsection

@section('footer_script')
    <script></script>
@endsection