@extends('layouts/contentNavbarLayout')
@section('title', 'Dashboard - Modules')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')
<div class="row">
  <div class="col-xxl-8 mb-6 order-0">
    <div class="card">
      <div class="d-flex align-items-start row">
        <div class="col-sm-7">
          <div class="card-body">
            <h4 class="card-title text-primary mb-3">Bienvenue Admin! 🎉</h4>
            <p class="mb-6">Grâce à WeCheck, surveiller en temps réel la disponibilité de tous les modules IoT.</p>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-6">
            <img src="{{asset('assets/img/illustrations/man-with-laptop.png')}}" height="175" class="scaleX-n1-rtl"
              alt="View Badge User">
          </div>
        </div>
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
                <div
                  class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-25"
                  style="width: 50px; height: 50px;">
                  <i style="font-size: 24px; color: #11af4e;" class='bx bx-windows'></i>
                </div>
              </div>
              <div><i class='bx bx-info-circle '></i></div>
            </div>
            <p class="mb-1">Nombre de modules</p>
            <h4 class="card-title mb-3" id="total-modules">
              0
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
                <div
                  class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-25"
                  style="width: 50px; height: 50px;">
                  <i style="font-size: 24px; color: #ee091c;" class='bx bx-station'></i>
                </div>
              </div>
              <div><i class='bx bx-info-circle '></i></div>
            </div>
            <p class="mb-1">Modules en panne</p>
            <h4 class="card-title mb-3" id="modules-en-panne">0</h4>
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
                <div
                  class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-25"
                  style="width: 50px; height: 50px;">
                  <i style="font-size: 24px; color: #ee7009;" class='bx bxs-file-import'></i>
                </div>
              </div>
              <div><i class='bx bx-info-circle '></i></div>
            </div>
            <p class="mb-1">Nombre de données</p>
            <h4 class="card-title mb-3" id="total-donnees">0
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
                <div
                  class="mx-auto d-flex align-items-center justify-content-center rounded-circle bg-info bg-opacity-25"
                  style="width: 50px; height: 50px;">
                  <i style="font-size: 24px; color: #4609ee;" class='bx bx-signal-4'></i>
                </div>
              </div>
              <div><i class='bx bx-info-circle '></i></div>
            </div>
            <p class="mb-1">Disponibilité</p>
            <h4 class="card-title mb-3">
              <span id="disponibilite-systeme">

              </span>
            </h4>
            {{-- <small class="text-success fw-medium"><i class='bx bx-up-arrow-alt'></i> +28.14%</small> --}}
          </div>
        </div>
      </div>
    </div>
  </div>

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
            <td>

              @if ($module->valeur)
              {{$module->valeur->valeur." ".$module->unite}}
              @else
              "N/A"
              @endif

              {{--
            <td style="max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
              {{ Str::limit($module->emplacement, 10, '...') }}
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
                  <a class="dropdown-item" href="{{ route('modules.show', $module->id) }}">
                    <i class="bx bx-show me-1 text-primary"></i> Afficher
                  </a>
                  <a class="dropdown-item" href="{{ route('modules.edit', $module->id) }}">
                    <i class="bx bx-edit-alt me-1 text-warning"></i> Modifier
                  </a>
                  <a class="dropdown-item delete-module" href="#" data-id="{{ $module->id }}">
                    <i class="bx bx-trash me-1 text-danger"></i> Supprimer
                  </a>
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

</div>
@endsection