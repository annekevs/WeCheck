@extends('layouts/contentNavbarLayout')
@section('title', 'Module - Create')


@section('content')
<div class="card col-xl ">
    <div class="mb-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Ajouter un module</h5>
            <small class="text-primary float-end">
                <i class='bx bx-station bx-lg'></i> </small>
        </div>
        <div class="card-body d-flex col-xl align-items-center justify-content-center">
            <form action="{{ route('modules.store') }}" method="post" class="col-md-10">
                @csrf
                <div class="mb-6">
                    <label class="form-label" for="nom">
                        <span id="nom2" class=""><i class='bx bxs-label me-1'></i></span>Nom
                    </label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                            value="{{ old('nom') }}" placeholder="Capteur 1" />
                    </div>

                    @if ($errors->has('nom'))
                    <span class="text-danger mx-8">{{ $errors->first('nom') }}</span>
                    @endif

                </div>
                <div class="mb-6">
                    <label class="form-label" for="description">
                        <span class=""><i class="bx bx-comment me-1"></i></span>
                        Description</label>
                    <div class="input-group input-group-merge">
                        {{-- <span id="description2" class="input-group-text"><i class="bx bx-comment"></i></span> --}}
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" value="{{ old('description') }}"
                            placeholder="Module destiné à.... Version:... Precautions:....., Liste des composants:....,"
                            aria-label="Module destiné à.... Version:... Precautions:....., Liste des composants:....,"
                            aria-describedby="description2"></textarea>
                    </div>
                </div>
                <div class="mb-6 flex-row d-flex justify-content-between">
                    <div class="row-6 w-100 me-10">
                        <label class="form-label" for="type"><span id="type" class="me-1">
                                <i class='bx bx-category-alt'></i>
                            </span>Type</label>
                        <div class="input-group input-group-merge">

                            <input type="text" class="form-control @error('type') is-invalid @enderror" id="type"
                                name="type" value="{{ old('type') }}" placeholder="Temperature" />
                        </div>
                        <div class="form-text"> Le type de valeur mesurée: Température, Pression, etc... </div>
                        @if ($errors->has('type'))
                        <span class="text-danger">{{ $errors->first('type') }}</span>
                        @endif
                    </div>
                    <div class=" row-md-6 w-100">
                        <label class="form-label" for="unite"><span id="unite" class="me-1">
                                <i class='bx bxs-ruler'></i>
                            </span>Unite</label>
                        <div class="input-group input-group-merge">

                            <input type="text" class="form-control @error('unite') is-invalid @enderror" id="unite"
                                name="unite" value="{{ old('unite') }}" placeholder="°C" />
                        </div>
                        <div class="form-text">{{" "}} L'unité de mesure: °C, hPa, m/s, etc...</div>
                        @if ($errors->has('unite'))
                        <span class="text-danger">{{ $errors->first('unite') }}</span>
                        @endif
                    </div>
                </div>
                <div class="mb-6">
                    <label class="form-label" for="emplacement"><span class="me-3"><i
                                class='bx bx-home-circle'></i></i></span>Emplacement</label>
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control @error('emplacement') is-invalid @enderror"
                            id="emplacement" name="emplacement" value="{{ old('emplacement') }}"
                            placeholder="225 Rue des Templiers, 59000 Lille, Salle Machine" aria-label="john.doe"
                            aria-describedby="emplacement2" />
                    </div>
                    <div class="form-text"> Vous pouvez mettre l'adresse complète suivie de l'emplacement </div>
                    @if ($errors->has('emplacement'))
                    <span class="text-danger">{{ $errors->first('emplacement') }}</span>
                    @endif
                </div>
                <div class="mb-6">
                    <label class="form-label" for="geolocalisation"><span id="geolocalisation2" class="me-3"><i
                                class='bx bxs-map-pin'></i></span>Geolocalisation</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="geolocalisation" class="form-control phone-mask"
                            placeholder="50.63386630811341, 3.0216060423296613" aria-label="latitude, longitude"
                            aria-describedby="geolocalisation2" />
                    </div>
                </div>
                <div class="mb-6">
                    <label class="form-label" for="date_ajout">Date d'installation</label>
                    <input class="form-control @error('date_ajout') is-invalid @enderror" name="date_ajout"
                        value="{{ old('date_ajout') }}" type="date" value="2021-06-18" id="date_ajout" />
                    @if ($errors->has('date_ajout'))
                    <span class="text-danger">{{ $errors->first('date_ajout') }}</span>
                    @endif
                </div>
                <div class="mb-3 row">
                    <input type="submit" class="col-md-3 offset-md-5 btn btn-primary mr-0" value="Ajouter">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection