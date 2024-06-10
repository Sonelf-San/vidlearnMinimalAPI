@extends('admin.layouts.app')
@section('title', 'Pages')

@section('header-style')
    <style>
        .product-img-preview {
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
                        <li class="breadcrumb-item active">Pages</li>
                    </ol>
                </div>
                <h4 class="page-title">Pages</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="card card-body">
       
        <div class="table-responsive position-relative">

            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="sort">
                @forelse($pages as $page)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <span>{{ $page->name }}</span>
                            </div>
                        </td>
                        <td>{{ Str::limit(strip_tags($page->content), 100) }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.pages.edit', $page->id) }}"
                                   class="btn btn-sm btn-secondary"><span class="fa fa-edit"></span></a>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="deleteModal{{ $page->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterLabel">Confirm Delete </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form method="POST" action="{{ route('admin.pages.destroy', $page->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Are you sure you want to delete this product ({{ $page->title }}) ?
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
            {{ $pages->links() }}
        </div>
    </div>


@endsection

@section('footer_script')
    <script></script>
@endsection