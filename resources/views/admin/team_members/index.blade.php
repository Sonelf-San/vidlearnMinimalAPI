@extends('admin.layouts.app')
@section('title', 'Team Members')

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
                        <li class="breadcrumb-item active">Your Students</li>
                    </ol>
                </div>
                <h4 class="page-title">Your Students</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="card card-body">
    <div class="filter">
                <div class="d-flex justify-content-between mb-3">
                    <div class="d-flex">
                        <button class="btn btn-info btn-sm btn-rounded waves-effect mr-2"
                                title="Filtrer les résultats" type="button" data-toggle="collapse"
                                data-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
                            <i class="mdi mdi-filter"></i>
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-info px-2 btn-sm" id="resultCount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> {{ $search['limit'] ?: 20 }} <i class=" ml-2 fa fa-angle-down"></i></button>
                            <div class="dropdown-menu w-25" aria-labelledby="resultCount">
                                <a class="dropdown-item" href="{{ route('admin.team_members.index', ['q'=>$search['q'], 'limit' => 10]) }}">10</a>
                                <a class="dropdown-item" href="{{ route('admin.team_members.index', ['q'=>$search['q'], 'limit' => 20]) }}">20</a>
                                <a class="dropdown-item" href="{{ route('admin.team_members.index', ['q'=>$search['q'], 'limit' => 50]) }}">50</a>
                                <a class="dropdown-item" href="{{ route('admin.team_members.index', ['q'=>$search['q'], 'limit' => 100]) }}">100</a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-nowrap align-items-center">
                        <small class="mx-2">page {{ $members->currentPage() }} of {{ $members->total() }} results</small>
                        <a class="btn btn-info text-white btn-sm" data-toggle="modal" data-target="#newTeamMemberModal">
                            <i class="fa fa-user-plus"></i> Add a student
                        </a>
                    </div>
                 </div>

                <div class="collapse {{ $search['q'] ? 'show' : ''}}" id="collapseFilter">
                    <form action="{{ route('admin.team_members.index') }}">
                        <input type="hidden" name="limit" value="{{ $search['limit'] }}">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" name="q" value="{{ $search['q'] }}" class="form-control form-control-sm"
                                       placeholder="Entrez l'email' de l'utilisateur...">
                            </div>
                            <div class="col-md-2 text-right d-flex align-items-end justify-content-end mt-3 mt-md-0">
                                <button class="btn btn-info btn-sm" type="submit">Filtrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        <div class="table-responsive position-relative">
            <div class="ajax-loader">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <table class="table table-centered table-striped">
                    <thead>
                    <tr role="row">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th class="text-center">Status</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($members as $member)
                        <tr role="row">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                            <div class="d-flex align-items-center">
                                    <div class="team-img-preview">
                                        <img class="img-fluid"
                                            src="{{ $member->profileURL() }}" alt="images...">
                                    </div>
                                    <a href="{{ route('admin.administrator.show', $member->id) }}"

                                       class="text-body font-weight-semibold">{{ $member->name }}</a>
                                </div>
                            </td>
                            <td>
                                {{ $member->email ?: 'N/A' }}
                            </td>
                            <td>
                                {{ optional($member->position)->name }}
                            </td>
                            <td class = "text-center">
                                @if($member->status === 'active')
                                    <span class="badge badge-success">Active | Encadrement en cours</span>
                                @else
                                <span class="badge badge-warning">Inactive | Encadrement Terminé</span>
                                @endif
                            </td>
                            <td class="sorting_1">{{ date('j M Y,', strtotime($member->created_at)) }}
                                <small class="text-muted">{{ date(' g:i A', strtotime($member->created_at)) }}</small>
                            </td>

                            <td>
                                <div class="btn-group">
                                    @if($member->status == 'active')
                                    <a href="{{ route('admin.team_members.status_update', $member->id) }}" class="btn btn-sm btn-warning mr-1">{{'Disable'}}</a>
                                    @else
                                    <a href="{{ route('admin.team_members.status_update', $member->id) }}" class="btn btn-sm btn-success mr-1">{{'Enable'}}</a>
                                    @endif
                                    <a href="{{ route('admin.team_members.edit', $member->id) }}"
                                    class="btn btn-sm btn-info mr-1"><span class="fa fa-edit"></span></a>

                                    <button type="button" class="btn btn-danger btn-sm"
                                            data-toggle="modal"
                                            data-target="#deleteModal{{ $member->id }}"><span class="fa fa-trash"></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $member->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterLabel">Confirm Delete </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form method="POST" action="{{ route('admin.team_members.destroy', $member->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                Are you sure you want to delete this member ({{ $member->email }}) ?
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
                            <td colspan="7" class="text-center">No Student Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
        </div>
        {{ $members->appends(['q'=>$search['q'], 'limit' =>$search['limit']])->links()}}
    </div>

    <div class="modal fade" id="newTeamMemberModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data"
                          action="{{ route('admin.team_members.store') }}">
                        @csrf

                <div class = "row">
                    <div class = "col">
                        <div class="form-group">
                            <label>Name <em>*</em></label>
                            <input type="text" name="name"
                                   value="{{ old('name') }}"
                                   class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class = "col">
                        <div class="form-group">
                            <label>Email <em>*</em></label>
                            <input type="text" name="email"
                                   value="{{ old('email') }}"
                                   class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>
            <div class = "row">
                <div class="col">
                    <div class="form-group">
                        <label for="image"> Image </label>
                        <div class="row align-items-end">
                            <div class="col-3">
                                <img src="{{ asset('assets/images/no_user.png') }}"
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
                    </div>
                    <div class="form-group col">
                    <input type = 'hidden' value = "{{$positions = \App\Models\Position::orderBy('created_at', 'DESC')->get()}}"/>
                        <label>Position <em>*</em></label>
                        <select type="text" name="position"
                                class="form-control {{ $errors->has('position') ? ' is-invalid' : '' }}">
                            <option value="">- Select Position -</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ $position->id == old('$position') ? 'selected' : '' }}>{{ $position->name }}</option>
                            @endforeach
                        </select>
                        @error('position')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
                <hr>


                        <div class="d-flex justify-content-between">
                            <button class="btn" data-dismiss="modal">Close</button>
                            <button class="btn btn-info" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')
    <script>
        $(function () {
            @if(count($errors) > 0)
            $('#newTeamMemberModal').modal('show');
            @endif
        });

        sortable('.sort')[0].addEventListener('sortupdate', function (e) {
            var el = $(e.detail.item);
            var loader = $('.ajax-loader');

            loader.show();
            $.ajax({
                method: 'POST',
                data: {
                    'id': el.attr('data-id'),
                    'rank': e.detail.destination.index + 1,
                    '_token': '{{ csrf_token() }}'
                },
                url: '{{ route('admin.team_members.rank_update') }}',
                success: function (data) {
                    loader.hide();
                },
                error: function () {
                    loader.hide();
                    alert('An unexpected error occurred.');
                }
            })
        });

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
