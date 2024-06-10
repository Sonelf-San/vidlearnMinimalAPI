@extends('admin.layouts.app')
@section('title', $article->title)

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Article</a></li>
                        <li class="breadcrumb-item active">{{ $article->title }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Courses</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data"
                  action="{{ route('admin.articles.update', $article->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Titre <em>*</em></label>
                            <input type="text" name="title"
                                value="{{ old('title', $article->title) }}"
                                class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category <em>*</em></label>
                                <select type="text" name="category"
                                        class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}">
                                    <option value="{{ old('category', $article->category_id) }}">{{ $article->category->name }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == old('$category') ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo <em></em></label>
                                <select type="text" name="logo"
                                        class="form-control {{ $errors->has('logo') ? ' is-invalid' : '' }}">
                                    <option value="{{ old('logo', $article->logo_id) }}">{{ $article->logo->name }}</option>
                                    @foreach($logos as $logo)
                                        <option value="{{ $logo->id }}" {{ $logo->id == old('$logo') ? 'selected' : '' }}>{{ $logo->name }}</option>
                                    @endforeach
                                </select>
                                @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description <em>*</em></label>
                            <textarea class="form-control tiny-textarea {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    rows="5"
                                    name="description">{{ old('description', $article->description) }}</textarea>

                            @error('description')
                            <span class="text-danger"> {{ $message }} </span>
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
