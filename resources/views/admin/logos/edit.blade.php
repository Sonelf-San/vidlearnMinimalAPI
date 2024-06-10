@extends('admin.layouts.app')
@section('title', $logo->name)
@section('header_style')
    <link rel="stylesheet" href="{{url('assets')}}/css/croppie.css">
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.logos.index') }}">Logos</a></li>
                        <li class="breadcrumb-item active">{{ $logo->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Logos</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"
                  action="{{ route('admin.logos.update', $logo->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Titre <em>*</em></label>
                            <input type="text" name="name"
                                   value="{{ old('name', $logo->name) }}"
                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cover Image</label>
                            <input type="file" accept="image/*" name="image"
                                class="form-control @error('image') is-invalid @enderror">

                            <small class="d-block text-muted mt-1">Accepted format: .png, .jpg, .svg</small>
                            <img src="{{old('image', asset('storage/logos/' . $logo->image) )}}" style="width: 50px;" class="img-fluid mt-3"
                                     id="preview" alt="">
                            @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-info" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('footer_script')
<script src="{{url('assets')}}/js/croppie.js"></script>


<script type="text/javascript">
    $(document).ready(function () {

        var avatar = $('#preview');
        var image = document.getElementById('image');
        var input = $('#photo');
        var $modal = $('#modal');
        var cropper;

        $('[data-toggle="tooltip"]').tooltip();

        input.change(function (e) {
            var files = e.target.files;

            var done = function (url) {
                input.value = '';
                image.setAttribute("src", url);
                $modal.modal('show');
            };

            var reader;
            var file;
            var url;


            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 4/2,
                viewMode: 3,
                cropmove: function () {
                    var cropper = this.cropper;
                    var cropBoxData = cropper.getCropBoxData();
                    var aspectRatio = cropBoxData.width / cropBoxData.height;

                    if (aspectRatio < minAspectRatio) {
                        cropper.setCropBoxData({
                            width: cropBoxData.height * minAspectRatio
                        });
                    } else if (aspectRatio > maxAspectRatio) {
                        cropper.setCropBoxData({
                            width: cropBoxData.height * maxAspectRatio
                        });
                    }
                }
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        document.getElementById('crop').addEventListener('click', function () {
            var initialAvatarURL;
            var canvas;

            $modal.modal('hide');
            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: 600,
                    height: 300,
                });
                avatar.attr('src', canvas.toDataURL());
                canvas.toBlob(function (blob) {
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function () {
                        var base64data = reader.result;
                        $('#course_image').val(base64data)
                    }
                });
            }
        });

    });
</script>
@endsection