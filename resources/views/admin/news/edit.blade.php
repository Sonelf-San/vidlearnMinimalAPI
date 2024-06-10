@extends('admin.layouts.app')
@section('title', $new->name)

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">Références</a></li>
                        <li class="breadcrumb-item active">{{ $new->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Références</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"
                  action="{{ route('admin.news.update', $new->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Name <em>*</em></label>
                            <input type="text" name="name"
                                   value="{{ old('name', $new->name) }}"
                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Catégorie </label>
                            <select name="category"
                                    class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    <option @if($category->id == old('category', $new->category_id)) selected @endif
                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            @error('category')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <label>Description <em>*</em></label>
                    <textarea class="form-control tiny-textarea {{ $errors->has('description') ? ' is-invalid' : '' }}"
                              rows="5"
                              name="description">{{ old('description', $new->description) }}</textarea>

                    @error('description')
                    <span class="text-danger"> {{ $message }} </span>
                    @enderror
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cover Image</label>
                            <input type="file" accept="image/*" name="image"
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
                    <button class="btn btn-info" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('footer_script')
    <script></script>
@endsection