@extends('admin.layouts.app')
@section('title', "Catégorie d'actualité")


@section('content')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Catégorie d'actualité</li>
                    </ol>
                </div>
                <h4 class="page-title">Catégorie d'actualité</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <section class="section">

        <div class="row">
            <div class="col-md-7 col-lg-8">

                <div class="card card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Actualités</th>
                                <th class="no-ordering"></th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse ($new_categories as $new_category)
                                <tr>

                                    <td class="">{{ $new_category->name }}</td>
                                    <td>{{ $new_category->news()->count() }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.news_categories.edit', $new_category->id) }}"
                                               class="btn btn-sm btn-info"><span class="fa fa-edit"></span></a>
                                            <button class="btn btn-sm btn-danger delete-reference_category" data-toggle="modal"
                                                    data-target="#deleteModal"
                                                    data-url="{{ route('admin.news_categories.destroy', $new_category->id) }}"
                                                    data-id="{{ $new_category->id }}"><span class="fa fa-trash"></span></button>
                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr class="">
                                    <td colspan="3" class="text-center"> No Record Found</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>


                    </div>

                    <nav aria-label="...">
                        <div class="pagination-sm">
                            {{ $new_categories->links() }}
                        </div>
                    </nav>
                </div>

            </div>
            <div class="col-md-5 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4">Ajouter Un Nouveau Catégorie</h4>
                        <form method="post" action="{{ route('admin.news_categories.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">

                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-info">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade confirmation-modal" id="deleteModal" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id" value="">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Supprimer la catégorie ?
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold p" for="deleteText">Êtes-vous sûr?</label>
                            <div><p>Voulez-vous supprimer cette référence?</p></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">ANNULER</button>
                        <button type="submit" class="btn btn-danger">SUPPRIMER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')
    <script>
        $(document).ready(function () {
            // For A Delete Record Popup
            $('.delete-reference_category').click(function () {
                var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');

                $("#deleteForm", 'input').val(id);
                $("#deleteForm").attr("action", url);
            });
        });
        $(function () {
            $('#limit').on('change', function () {
                $(this).closest('form').submit();
            });
        });
    </script>
@endsection