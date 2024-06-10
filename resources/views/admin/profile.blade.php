@extends('admin.layouts.app')
@section('title', 'Profil')

@section('header-style')
    <style>
        .team-img-preview {
            height: 42px;
            width: 42px;
            overflow: hidden;
            border-radius: 50%;
            background-color: #fff;
            border: solid 2px #ddd;
            margin-right: 10px;
        }
    </style>
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profil</li>
                    </ol>
                </div>
                <h4 class="page-title">Profil</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Détails du compte</h5>
                    <form method="post" enctype="multipart/form-data" action="{{ route('admin.profile.edit') }}">
                        @csrf

                        <div class="form-group">
                            <label>Nom <em>*</em></label>
                            <input type="text"
                                name="name" value="{{ old('name', $user->name) }}"
                                class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                placeholder="Nom" required="">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="{{ $user->email }}"
                                   class="form-control"
                                   placeholder="Email" readonly>
                        </div>
                        <div class="form-group">
                            <label>Bureau <em>*</em></label>
                            <input type="text"
                                name="office" value="{{ old('office', $user->office) }}"
                                class="form-control {{ $errors->has('office') ? ' is-invalid' : '' }}"
                                placeholder="Bureau" required="">

                            @if ($errors->has('office'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('office') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="image"> Image </label>
                            <div class="row align-items-end">
                                <div class="col-3">
                                    <img src="{{old('image', \Auth('admin')->user()->profileURL())}}"
                                    class="img-fluid img-thumbnail" id="preview" alt="">
                                </div>
                            <div class="col-9">
                                <input type="file" accept="image/*" onchange="previewImage(this)" name="image"
                                    class="form-control @error('image') is-invalid @enderror">
                                <small class="d-block text-muted">Required dimesion: 306x444</small>
                                <small class="d-block text-muted mt-1">Accepted format: .png, .jpg, .svg</small>

                                @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <label>Description <em>*</em></label>
                            <textarea class="form-control tiny-textarea {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    rows="5"
                                    name="description">{{ old('description', $user->description) }}</textarea>

                            @error('description')
                            <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                        
                    </div>

                        <div class="form-group text-right">
                            <button class="btn btn-primary" type="submit">Mise à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">Changer le mot de passe</h5>

                    <form method="post" action="{{ route('admin.profile.password') }}">
                        @csrf

                        <div class="form-group">
                            <label>Mot de passe actuel <em>*</em></label>
                            <input type="password"
                                   class="form-control {{ $errors->has('current_password') ? "is-invalid" : "" }}"
                                   name="current_password">

                            @if ($errors->has('current_password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('current_password') }}
                                </div>
                            @endif
                        </div>

                        <!-- New Password -->
                        <div class="form-group">
                            <label>{{ __('Nouveau mot de passe') }}</label>
                            <input type="password"
                                   class="form-control {{ $errors->has('password') ? "is-invalid" : "" }}"
                                   name="password">

                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <!-- Retype New Password -->
                        <div class="form-group">

                            <label>{{ __('Re-taper le nouveau mot de passe') }}</label>

                            <input type="password" class="form-control"
                                   name="password_confirmation">

                        </div>

                        <div class="form-group text-right">
                            <button class="btn btn-primary" type="submit">Changer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_script')
    <script>
                function previewImage(input) {
            var file = input.files[0];
            var imagefile = file.type;
            var match = ["image/jpeg", "image/jpg", "image/png"];
            if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                $("#preview").attr('src', 'images/default.png');
                input.setAttribute("value", "");
                // $("#message").append("<p class='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg and png Images type allowed</span>");
            } else {
                var reader = new FileReader();
                reader.onload = function (e) {
                    //  $("#message").empty();
                    $('#preview').attr("src", e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection