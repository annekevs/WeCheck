@extends('layouts/contentNavbarLayout')
@section('title', 'Module - Edit')


@section('content')
<div class="card col-xl ">
    <div class="mb-6">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Editer un module</h5>
            <small class="text-muted float-end">Merged input group</small>
        </div>
        <div class="card-body d-flex col-xl align-items-center justify-content-center">
            <form action="{{ route('modules.update') }}" method="post" class="col-md-10">
                @csrf
                @method("PUT")

                <div class="mb-6">
                    <label class="form-label" for="nom">Nom</label>
                    <div class="input-group input-group-merge">
                        <span id="nom2" class="input-group-text">
                            <i class="bx bx-user"></i>
                        </span>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                            value="{{ old('nom') }}" placeholder="Capteur 1" />
                    </div>
                    @if ($errors->has('nom'))
                    <span class="text-danger">{{ $errors->first('nom') }}</span>
                    @endif
                </div>
                <div class="mb-6">
                    <label class="form-label" for="description">Description</label>
                    <div class="input-group input-group-merge">
                        <span id="description2" class="input-group-text"><i class="bx bx-comment"></i></span>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" value="{{ old('description') }}"
                            placeholder="Hi, Do you have a moment to talk Joe?"
                            aria-label="Hi, Do you have a moment to talk Joe?"
                            aria-describedby="description2"></textarea>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="form-label" for="emplacement">Emplacement</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                        <input type="text" class="form-control @error('emplacement') is-invalid @enderror"
                            id="emplacement" name="emplacement" value="{{ old('emplacement') }}" placeholder="john.doe"
                            aria-label="john.doe" aria-describedby="emplacement2" />
                    </div>
                    <div class="form-text"> You can use letters, numbers & periods </div>
                    @if ($errors->has('emplacement'))
                    <span class="text-danger">{{ $errors->first('emplacement') }}</span>
                    @endif
                </div>
                <div class="mb-6">
                    <label class="form-label" for="geolocalisation">Geolocalisation</label>
                    <div class="input-group input-group-merge">
                        <span id="geolocalisation2" class="input-group-text"><i class="bx bx-phone"></i></span>
                        <input type="text" id="geolocalisation" class="form-control phone-mask"
                            placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="geolocalisation2" />
                    </div>
                </div>
                <div class="mb-6">
                    <label class="form-label" for="date_ajout">Installé le</label>
                    <input class="form-control @error('date_ajout') is-invalid @enderror" name="date_ajout"
                        value="{{ old('date_ajout') }}" type="date" value="2021-06-18" id="date_ajout" />
                    @if ($errors->has('date_ajout'))
                    <span class="text-danger">{{ $errors->first('date_ajout') }}</span>
                    @endif
                </div>
                <div class="mb-3 row">
                    <input type="submit" class="col-md-3 offset-md-5 btn btn-primary mr-0" value="Sauvegarder">
                </div>
            </form>
        </div>
    </div>
</div>

@endsection