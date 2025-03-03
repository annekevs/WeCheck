@extends('layouts/contentNavbarLayout')
@section('title', 'Historique - Etat')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection


@section('content')
<div class="row">
    <div class="card order-3 order-md-2">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4>Historique des etats</h4>

        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Nom du Module</th>
                        <th scope="col">Durée</th>
                        <th scope="col">Date mise à jour</th>
                        <th scope="col">Statut</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="etat-modules-table-body">
                    @forelse ($etatModules as $historique)
                    <tr id="etat-module-{{ $historique->id }}">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $historique->module->nom }}</td>
                        <td>{{ $historique->module->getDuree() }}</td>
                        <td>{{ $historique->created_at }}</td>
                        <td class="etat-module-status">
                            <span
                                class="badge rounded-pill bg-label-{{ $historique->etat == 'panne' ? 'danger' : 'success' }}">
                                {{ $historique->etat == 'panne' ? "En panne" : "Actif" }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <td colspan="6">
                        <span class="text-danger">
                            <strong>Aucun historique trouvé !</strong>
                        </span>
                    </td>
                    @endforelse
                </tbody>
            </table>
            {{ $etatModules->links() }}
        </div>
    </div>

</div>
@endsection