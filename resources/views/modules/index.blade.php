@extends('layouts/contentNavbarLayout')
@section('title', 'Module - List')

@section('page-script')
@vite('resources/assets/js/dashboard.js')
@endsection

@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success" role="alert">
    {{ $message }}
</div>
@endif

{{-- <div class="d-flex px-5 align-items-center justify-content-between">
    <h4 class="p-6 mt-2"></h4>
    <a href="{{ route('modules.create') }}" class="btn btn-primary">
        <i class='bx bx-plus-circle me-1'></i> Nouveau Module
    </a>
</div> --}}


<!-- Hoverable Table rows -->


<div class="card order-3 order-md-2">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h4>Liste des modules</h4>
        <a href="{{ route('modules.create') }}" class="btn btn-primary">
            <i class='bx bx-plus-circle me-1'></i> Nouveau Module
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Valeur actuelle</th>
                    <th scope="col">Dernier Signal</th>
                    <th scope="col">Statut</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="modules-table-body">
                @forelse ($modules as $module)
                <tr id="module-{{ $module->id }}">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $module->nom }}</td>
                    <td>@if ($module->valeur)
                        {{$module->valeur->valeur." ".$module->unite}}
                        @else
                        "N/A"
                        @endif</td>
                    {{-- <td style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ Str::limit($module->emplacement, 30, '...') }}
                    </td> --}}
                    <td>{{ $module->date_ajout }}</td>
                    <td class="module-status">
                        <span class="badge rounded-pill bg-label-{{ $module->en_panne ? 'danger' : 'success' }}">
                            {{ $module->en_panne ? "En panne" : "Actif" }}
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('modules.show', $module->id) }}"
                                    data-module="{{$module}}">
                                    <i class="bx bx-show me-1 text-primary"></i> Afficher
                                </a>
                                {{-- <a class="dropdown-item" href="{{ route('modules.edit', $module->id) }}"
                                    data-module="{{$module}}">
                                    <i class="bx bx-edit-alt me-1 text-warning"></i> Modifier
                                </a>
                                <a class="dropdown-item delete-module" href="#" data-id="{{ $module->id }}"
                                    data-module="{{$module}}">
                                    <i class="bx bx-trash me-1 text-danger"></i> Supprimer
                                </a> --}}
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="6">
                    <span class="text-danger">
                        <strong>Aucun module trouvé !</strong>
                    </span>
                </td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<!--/ Hoverable Table rows -->
@endsection