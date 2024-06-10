@extends('admin.layouts.app')
@section('title', $user->name)

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('admin.administrator.index') }}">Lecturer Account</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ $user->name }}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">
                <img src="{{ $user->profileURL() }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                <h4 class="mb-0">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <hr>
                <div class="text-left mt-3">
                    <p class="text-muted mb-2 font-13">
                        <strong>Full Name :</strong> <span class="ml-2">{{ $user->name }}</span>
                    </p>
                    <p class="text-muted mb-2 font-13">
                        <strong>Position :</strong><span class="ml-2">{{ $user->position ? $user->position->name : 'N/A' }}</span>
                    </p>

                    <p class="text-muted mb-2 font-13">
                        <strong>Email :</strong> <span class="ml-2 ">{{ $user->email }}</span></p>

                    <p class="text-muted mb-1 font-13">
                        <strong>Address 1 :</strong> <span class="ml-2">{{ $user->address_1 ?: 'N/A' }}</span></p>
                    <p class="text-muted mb-1 font-13">
                        <strong>Address 2 :</strong> <span class="ml-2">{{ $user->address_2 ?: 'N/A' }}</span></p>
                </div>
                <hr>
                <form  action="{{route('admin.administrator.destroy',($user->id))}}" method="POST">
                    @method('DELETE')
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-xs btn-block  waves-effect mb-2 waves-light">
                        Delete <span class="fa fa-trash"></span>
                    </button>
                </form>

            </div> <!-- end card-box -->

        </div> <!-- end col-->

    </div>

@endsection

@section('footer_script')
    <script></script>
@endsection
