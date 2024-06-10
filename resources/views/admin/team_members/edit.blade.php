@extends('admin.layouts.app')
@section('title', $members->name)

@section('content')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.team_members.index') }}">Your Students</a></li>
                        <li class="breadcrumb-item active">{{ $members->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Your Students</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <form action="{{ route('admin.team_members.update', $members->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">
                                        Name <em>*</em>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $members->name) }}"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">
                                        Email <em>*</em>
                                    </label>
                                    <input type="text" name="email" value="{{ old('email', $members->email) }}"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Position <em>*</em></label>
                                    <select type="text" name="position"
                                            class="form-control {{ $errors->has('position') ? ' is-invalid' : '' }}">
                                        <option value="{{ old('position', $members->position_id) }}">{{ optional($members->position)->name }}</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" {{ $position->id == old('$position') ? 'selected' : '' }}>{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('position')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="image">
                                        Image
                                    </label> <br>
                                    <img src="{{ $members->profileURL() }}" class="img-fluid" id="preview" alt="">
                                    <input type="file" onchange="previewImage(this)" name="image"
                                           class="form-control @error('image') is-invalid @enderror">

                                    <small class="d-block text-muted mt-1">Accepted format: .png, .jpg, .svg</small>

                                    @error('image')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="submit" class="btn btn-info">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



@endsection

@section('footer_script')


    <!-- image uploader -->
    <script src="{{ asset('admin_assets/assets/image_uploader_plugin/dist/image-uploader.min.js') }}"></script>
    <script>
        $(function () {
            $('.page-images').imageUploader({
                imagesInputName: 'filename',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 1
            });
        });
    </script>


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
