@extends('layouts/contentNavbarLayout')
@section('title', 'Modules - List')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/donnees-modules.js')
@endsection

@section('content')
<div class="row">
    <div class="card order-3 order-md-2">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4>Historique des donnees</h4>

        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Nom du Module</th>
                        <th scope="col">Valeur actuelle</th>
                        <th scope="col">Date mise à jour</th>
                        <th scope="col">Statut</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="donnee-modules-table-body">
                    @forelse ($donnees as $donnee)
                    <tr id="donnee-module-{{ $donnee->id }}">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $donnee->module->nom }}</td>
                        <td>{{ $donnee->valeur." ".$donnee->module->unite }}</td>
                        <td>{{ $donnee->created_at }}</td>
                        <td class="donnee-module-status">
                            <span
                                class="badge rounded-pill bg-label-{{ $donnee->module->en_panne == true ? 'danger' : 'success' }}">
                                {{ $donnee->module->en_panne == true ? "En panne" : "Actif" }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <td colspan="6">
                        <span class="text-danger">
                            <strong>Aucune donnée trouvé !</strong>
                        </span>
                    </td>
                    @endforelse
                </tbody>
            </table>
            {{ $donnees->links() }}
        </div>
    </div>

</div>
@endsection