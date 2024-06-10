@extends('admin.layouts.app')
@section('title', 'Partners')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">Partenaires</a></li>
                        <li class="breadcrumb-item active">Télécharger</li>
                    </ol>
                </div>
                <h4 class="page-title">Télécharger le Partenaire</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"
                  action="{{ route('admin.partners.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Titre <em>*</em></label>
                            <input type="text" name="name"
                                   value="{{ old('name') }}"
                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class = "row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description <em>*</em></label>
                            <textarea class="form-control tiny-textarea {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    rows="5"
                                    name="description">{{ old('description') }}</textarea>

                            @error('description')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Lien</label>
                            <input type="text" name="link"
                                   value="{{ old('link') }}"
                                   class="form-control {{ $errors->has('link') ? ' is-invalid' : '' }}">
                            @error('link')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                         <label> Date de début <em>*</em></label>
                         <input type="date" name="start_date"
                           value="{{ old('start_date') }}"
                           class="form-control {{ $errors->has('start_date') ? ' is-invalid' : '' }}">
                            @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                         <label>Date de fin <em>*</em></label>
                         <input type="date" name="end_date"
                           value="{{ old('end_date') }}"
                           class="form-control {{ $errors->has('end_date') ? ' is-invalid' : '' }}">
                            @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="text-right">
                    <button class="btn btn-info" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer_script')
    <script></script>
@endsection