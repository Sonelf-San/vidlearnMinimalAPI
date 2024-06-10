@extends('admin.layouts.app')
@section('title', $new->name)

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">Actualités</a></li>
                        <li class="breadcrumb-item active">{{ $new->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Actualités</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold">
                        <i data-feather="layers"></i>
                        {{ $new->name }}</h4>
                    <hr>
                    <div class="read-more">
                        {!! $new->description !!}
                    </div>
                </div>
            </div>


        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('storage/news/' . $new->image) }}" class="img-fluid mb-3">
                    <h3 class="text-capitalize mb-2">{{ $new->name }}</h3>
                    <p class="mb-0">
                        <span class="fa fa-stopwatch"></span>
                        {{ $new->created_at->diffForHumans() }}
                    </p>
                    <p class="mb-0">
                        <span class="fa fa-list-alt"></span>
                        {{ $new->category ? $new->category->name : 'N/A' }}
                    </p>
                    <hr>
                    <a href="{{ route('admin.news.edit', $new->id) }}"
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
                                <form method="POST" action="{{ route('admin.news.destroy', $new->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Are you sure you want to delete this new ({{ $new->name }}) ?
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


    <div class="modal fade" id="addImages" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">Confirm Delete </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form method="POST" enctype="multipart/form-data"
                      action="{{ route('admin.news.add_images', $new->id) }}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Images <em>*</em></label>
                            <input type="file" accept="image/*" multiple name="images[]"
                                   class="form-control @error('images') is-invalid @enderror">
                            @error('images')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                </form>
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

            $(function () {
                @if(count($errors) > 0) $('#addImages').modal('show');
                @endif

                $('.remove-image').on('click', function ($e) {
                    $e.preventDefault();
                    var image_id = $(this).attr('data-id');
                    var delete_modal = $('#deleteImageModal');

                    delete_modal.find('form')
                        .attr('action', '{{ route('admin.new_images.delete', ['id' => 'CM']) }}'.replace('CM', image_id));
                    delete_modal.modal('show');
                });

                $('.new-img-slider').owlCarousel({
                    loop: false,
                    nav: true,
                    margin: 10,
                    dots: false,
                    responsive: {
                        0: {
                            items: 1.2
                        },
                        567: {
                            items: 2.2
                        },
                        768: {
                            items: 3.2
                        },
                        992: {
                            items: 4.2
                        }
                    }
                });

            });
        })
    </script>
@endsection