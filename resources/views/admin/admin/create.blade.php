@extends('admin.layouts.app')
@section('title', 'Ajouter un administrateur')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Lecturer</li>
                    </ol>
                </div>
                <h4 class="page-title">Add a Lecturer</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-xl-12">
            <div class="card-box">
                <div class="px-4">
                    <h4 class="page-title my-2">Enter Lecturer details</h4>
                    <form method="post" action="{{route('admin.administrator.store')}}">
                        @csrf
                       <div class="row">
                           <div class="form-group col-sm-4">
                               <label for="firstname">Lecturer Name<em>*</em></label>
                               <input class="form-control @error('name') is-invalid @enderror" type="text" value="{{old('name')}}" name="name" placeholder="Lecturer Name">
                               @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                               @enderror
                           </div>
                           <div class="form-group col-sm-4">
                               <label>Email<em>*</em></label>
                               <input class="form-control @error('email') is-invalid @enderror" type="email" value="{{old('email')}}" name="email" placeholder="Lecturer Email address">
                               @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                               @enderror
                           </div>
                           <div class="form-group col-sm-4">
                                <label>Position <em></em></label>
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

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center mb-3">
                                    <a href="{{route('admin.administrator.index')}}" type="button" class="btn w-sm btn-light waves-effect">Annuler</a>
                                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </form>
                </div>
            </div> <!-- end card-box-->
        </div>
    </div>


@endsection
