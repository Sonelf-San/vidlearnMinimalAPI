@extends('admin.layouts.app')
@section('title', 'Gallery')

@section('header-style')
    <style>
        .gallery-img-preview {
            height: 42px;
            width: 42px;
            overflow: hidden;
            background-color: #fff;
            border: solid 1px #ddd;
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
                        <li class="breadcrumb-item active">Projets</li>
                    </ol>
                </div>
                <h4 class="page-title">Projets</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="card card-body">
        <div class="text-right mb-3">
            <a href="{{ route('admin.galleries.create') }}"
               class="btn btn-info mb-3">
                <i class="fa fa-user-plus"></i> New galleries
            </a>
        </div>
        <div class="table-responsive position-relative">

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="sort">
                @forelse($galleries as $gallery)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="gallery-img-preview">
                                    <img class="img-fluid"
                                    src="{{ asset('storage/galleries/' . $gallery->image) }}" alt="">
                                </div>
                                <span>{{ $gallery->name }}</span>
                            </div>
                        </td>
                        <td>{{ $gallery->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.galleries.show', $gallery->id) }}"
                                   class="btn btn-sm btn-info"><span class="fa fa-eye"></span></a>
                                <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                                   class="btn btn-sm btn-secondary"><span class="fa fa-edit"></span></a>
                                <button type="button" class="btn btn-danger btn-sm"
                                        data-toggle="modal"
                                        data-target="#deleteModal{{ $gallery->id }}"><span class="fa fa-trash"></span>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="deleteModal{{ $gallery->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterLabel">Confirm Delete </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form method="POST" action="{{ route('admin.galleries.destroy', $gallery->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Are you sure you want to delete this gallery ({{ $gallery->name }}) ?
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            NO
                                        </button>
                                        <button type="submit" class="btn btn-danger">YES</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No records found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $galleries->links() }}
        </div>
    </div>


@endsection

@section('footer_script')
    <script></script>
@endsection