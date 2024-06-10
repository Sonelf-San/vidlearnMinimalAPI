@extends('admin.layouts.app')
@section('title', $partner->name)

@section('header-style')
    <style>
        .remove-image {
            color: #ff0000;
            border: solid 1px #ff0000;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            padding: 3px;
            height: 18px;
            width: 18px;
            float: right;
            margin-bottom: 3px;
        }

        .remove-image:hover {
            color: #ff0000;
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.partners.index') }}">Partenaires</a></li>
                        <li class="breadcrumb-item active">{{ $partner->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Partenaire</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('storage/partners/' . $partner->image) }}" alt = "Image..." class="img-fluid mb-3">
                    <h3 class="text-capitalize mb-0">{{ $partner->name }}</h3>
                    <p class="mb-0"><span class="fa fa-stopwatch"></span> {{ $partner->created_at->diffForHumans() }}
                    </p>
                    <p class="mb-0">
                    <span class="">Visit: <a href = "{{$partner->link}}">{{$partner->name}}</a></span>
                    </p>
                    <hr>
                    <a href="{{ route('admin.partners.edit', $partner->id) }}"
                       class="btn btn-info btn-sm btn-block mb-2">Edit</a>
                    <button data-target="#deleteModal" data-toggle="modal"
                            class="btn btn-danger btn-sm btn-block mb-2">Delete
                    </button>

                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterLabel">Confirm Delete </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form method="POST" action="{{ route('admin.partners.destroy', $partner->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Are you sure you want to delete this activity ({{ $partner->name }}) ?
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
                </div>
            </div>
        </div>
        




        </div>
    </div>


    <div class="modal fade" id="addImages" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">Confirm Delete </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>



            </div>
        </div>
    </div>

    <div id="deleteImageModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">Confirm Delete </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    @method('delete')

                    <div class="modal-body  @error('image') has-error @enderror">
                        <p>Are you sure you want to delete this image? This action is irreversible!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('footer_script')
    <script>
        $(function () {
            new Readmore('.read-more', {
                lessLink: '<a href="#">moins</a>',
                moreLink: '<a href="#">voir plus</a>',
                collapsedHeight: 190
            });
        })
    </script>
@endsection