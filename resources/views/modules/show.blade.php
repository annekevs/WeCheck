@extends('layouts/contentNavbarLayout')
@section('title', 'Module - Show')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/realtime-chart.js')
@endsection


@section('content')

<div class="card col-xl mb-5 d-flex flex-row align-items-center">
    <div class="card-body d-flex justify-content-between w-100">
        <div class="d-flex flex-column align-items-start">
            <h5 class="card-title mb-1">Module:</h5>
            <span class="text-primary">{{ $module->nom }}</span>
        </div>
        <div class="d-flex flex-column align-items-start ms-4">
            <h6 class="mb-1">Mesure:</h6>
            <span class="text-muted">{{ $module->type }}</span>
        </div>
        <div class="d-flex flex-column align-items-start ms-4">
            <h6 class="mb-1">Emplacement:</h6>
            <span class="text-primary">{{ $module->emplacement }}</span>
        </div>
    </div>
</div>

<div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2">
    <div class="row">
        <div class="col-3 mb-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-4">
                        <div class="card text-center p-3 shadow-sm border-0"
                            style="width: 80px; border-radius: 10px; background-color: transparent;">
                            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-25"
                                style="width: 50px; height: 50px;">
                                <i style="font-size: 24px; color: #11af4e;" class='bx bxs-file'></i>
                            </div>
                        </div>
                        <div><i class='bx bx-info-circle '></i></div>
                    </div>
                    <p class="mb-1">Valeur actuelle</p>
                    <h4 class="card-title mb-3" id="module-{{$module->id}}-valeur">
                        {{$module->donnees()->latest()->first()->valeur ?? 'N/A'}} {{$module->unite}}</h4>
                    {{-- <small class="text-danger fw-medium"><i class='bx bx-down-arrow-alt'></i> -14.82%</small> --}}
                </div>
            </div>
        </div>
        <div class="col-3 mb-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-4">
                        <div class="card text-center p-3 shadow-sm border-0"
                            style="width: 80px; border-radius: 10px; background-color: transparent;">
                            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-info bg-opacity-25"
                                style="width: 50px; height: 50px;">
                                <i style="font-size: 24px; color: #6c09ee;" class='bx bxs-hourglass'></i>
                            </div>
                        </div>
                        <div><i class='bx bx-info-circle '></i></div>
                    </div>
                    <p class="mb-1">En fonction depuis</p>
                    <h4 class="card-title mb-3" id="module-{{$module->id}}-duree">{{$module->getDuree()}}</h4>
                    {{-- <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +28.14%</small> --}}
                </div>
            </div>
        </div>
        <div class="col-3 mb-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-4">
                        <div class="card text-center p-3 shadow-sm border-0"
                            style="width: 80px; border-radius: 10px; background-color: transparent;">
                            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-25"
                                style="width: 50px; height: 50px;">
                                <i style="font-size: 24px; color: #ee7009;" class='bx bxs-pie-chart-alt-2'></i>
                            </div>
                        </div>
                        <div><i class='bx bx-info-circle '></i></div>
                    </div>
                    <p class="mb-1">Nombre de données</p>
                    <h4 class="card-title mb-3" id="module-{{$module->id}}-total_donnees">{{$module->getTotalDonnees()}}
                    </h4>
                    {{-- <small class="text-danger fw-medium"><i class='bx bx-down-arrow-alt'></i> -14.82%</small> --}}
                </div>
            </div>
        </div>
        <div class="col-3 mb-6">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between mb-4">
                        <div class="card text-center p-3 shadow-sm border-0"
                            style="width: 80px; border-radius: 10px; background-color: transparent;">
                            <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-secondary bg-opacity-25"
                                style="width: 50px; height: 50px;">
                                <i style="font-size: 24px; color: {{ ($module->en_panne == true) ? '#ee091c' : '#09ee3bbe'}}"
                                    class='bx bx-station'></i>
                            </div>
                        </div>
                        <div><i class='bx bx-info-circle '></i></div>
                    </div>
                    <p class="mb-1">Statut</p>
                    <h4 class="card-title mb-3">
                        <span id="module-{{$module->id}}-etat"
                            class="badge rounded-pill bg-label-{{ ($module->en_panne == true) ? 'danger' : 'success' }} me-1">
                            {{ $module->en_panne == true? "En panne" : "Actif" }}
                        </span>
                    </h4>
                    {{-- <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +28.14%</small> --}}
                </div>
            </div>
        </div>
        <div class="col-12 mb-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title mb-6 d-flex flex-row justify-content-between">
                        <h3 class="text-nowrap mb-1">Évolution des Données en Temps Réel</h3>
                        <div>
                            Dernier signal recu
                            <span class="badge bg-label-secondary text-primary">
                                <span id="module-{{$module->id}}-date_dernier_signal"></span>
                            </span>
                        </div>

                    </div>
                    <div id="module-container" data-module-id="{{ $module->id }}">
                        <canvas id="donneesChart"></canvas>
                    </div>
                    {{-- <div id="profileReportChart" class="col-xl"></div> --}}
                    {{-- <div id="incomeChart" class="col-xl"></div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Collapse pour Table des Données -->
    <div class="col-12 mb-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-6 d-flex flex-row justify-content-between" id="collapseHeader-donnees"
                    style="cursor: pointer;">
                    <h3 class="text-nowrap mb-1">Historique des données</h3>

                    <!-- Flèche de collapsible -->
                    <button class="btn btn-link p-0" type="button" id="toggleCollapse">
                        <i id="collapseArrow" class="bx bx-chevron-down bx-lg"></i>
                        <!-- Flèche vers le bas par défaut -->
                    </button>
                </div>
                <div class="collapse" id="moduleDonneesTable">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Valeur</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donnees as $donnee)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $donnee->valeur."". $module->unite}} </td>
                                    <td>{{ $donnee->date_mesure }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $donnees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collapse pour Historique des Modules -->
    <div class="col-12 mb-6">
        <div class="card">
            <div class="card-body">
                <!-- Card Title (entièrement cliquable) -->
                <div class="card-title mb-6 d-flex flex-row justify-content-between" id="collapseHeader-etats"
                    style="cursor: pointer;">
                    <h3 class="text-nowrap mb-1">Historique des Etats</h3>

                    <!-- Flèche de collapsible -->
                    <button class="btn btn-link p-0" type="button" id="toggleCollapse">
                        <i id="collapseArrow" class="bx bx-chevron-down bx-lg"></i>
                        <!-- Flèche vers le bas par défaut -->
                    </button>
                </div>

                <div class="collapse" id="moduleHistoryTable">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom du Module</th>
                                    <th scope="col">Date mise à jour</th>
                                    <th scope="col">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etats as $historique)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $module->nom }}</td>
                                    <td>{{ $historique->created_at }}</td>
                                    <td class={{$historique->etat == 'panne' ? "text-danger" : "text-success"}}>{{
                                        $historique->etat == 'panne' ? 'En panne' : 'Actif' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $etats->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    // Lorsque le titre est cliqué, toggler le collapse
    $('#collapseHeader-donnees').on('click', function() {
        var collapseElement = $('#moduleDonneesTable');
        var collapseArrow = $('#collapseArrow');
        
        // Si le collapse est ouvert, le fermer
        if (collapseElement.hasClass('show')) {
            collapseElement.removeClass('show');
            collapseArrow.removeClass('bx-chevron-up').addClass('bx-chevron-down');
        } else {
            collapseElement.addClass('show');
            collapseArrow.removeClass('bx-chevron-down').addClass('bx-chevron-up');
        }
    });

    $('#collapseHeader-etats').on('click', function() {
        var collapseElement = $('#moduleHistoryTable');
        var collapseArrow = $('#collapseArrow');
        
        // Si le collapse est ouvert, le fermer
        if (collapseElement.hasClass('show')) {
            collapseElement.removeClass('show');
            collapseArrow.removeClass('bx-chevron-up').addClass('bx-chevron-down');
        } else {
            collapseElement.addClass('show');
            collapseArrow.removeClass('bx-chevron-down').addClass('bx-chevron-up');
        }
    });
</script>

@endsection