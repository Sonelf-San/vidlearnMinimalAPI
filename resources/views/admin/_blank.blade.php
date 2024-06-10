@extends('admin.layouts.app')
@section('title', 'Page Title')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Prev Page</a></li>
                        <li class="breadcrumb-item active">Page Title</li>
                    </ol>
                </div>
                <h4 class="page-title">Page Title</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


@endsection

@section('footer_script')
    <script></script>
@endsection