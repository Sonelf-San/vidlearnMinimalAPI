@extends('admin.layouts.app')
@section('title', $category->name)


@section('content')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.news_categories.index') }}">Catégorie de référence</a></li>
                        <li class="breadcrumb-item active">{{ $category->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $category->name }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <section class="section">

        <div class="row">
            <div class="col-md-6 col-lg-10">
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{ route('admin.news_categories.update', $category->id) }}">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $category->name) }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Sauvegarder</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </section>


@endsection


@section('footer_script')
    <script>

    </script>
@endsection