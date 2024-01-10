@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Aggiorna progetto</h2>
                <form action="{{ route('admin.projects.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $project->title }}">
                    </div>

                    <div class="form-group">
                        <label for="image_path">Image Path:</label>
                        <input type="text" name="image_path" id="image_path" class="form-control" value="{{ $project->image_path }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control">{{ $project->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="type_id">Tipologia:</label>
                        <select name="type_id" id="type_id" class="form-control">
                            <option value="">Seleziona una tipologia</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="technologies">Tecnologie:</label>
                        <!-- Creo un elemento <select> che rappresenta il campo di selezione. L'attributo name="technologies[]" indica un array di valori (le tecnologie selezionate). L'attributo id="technologies" fornisce un identificatore univoco. multiple: permette la selezione multipla, essendo un campo many-to-many. -->
                        <select name="technologies[]" id="technologies" class="form-control" multiple>
                            <!-- Itero attraverso tutte le tecnologie disponibili, rappresentate dalla variabile $technologies.
                                <option value="{{ $technology->id }}">{{ $technology->name }}</option> indica che, per ogni tecnologia, viene generato un elemento <option> con un valore uguale all'id della tecnologia e il testo dell'opzione corrisponde al nome della tecnologia. -->
                            @foreach($technologies as $technology)
                                <option value="{{ $technology->id }}">{{ $technology->name }}</option> <!-- Con value="{{ $technology->id }}" specificoil valore che sarà inviato al server quando l'opzione è selezionata. In questo caso, è l'id della tecnologia. {{ $technology->name }}: mostra il nome della tecnologia all'interno dell'opzione. -->
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Aggiorna progetto</button>
                </form>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-2">Torna alla lista</a>
            </div>
        </div>
    </div>
@endsection