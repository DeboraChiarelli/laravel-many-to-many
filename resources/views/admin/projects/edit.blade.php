@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Crea un nuovo progetto</h2>
                <form action="{{ route('admin.projects.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="image_path">Image Path:</label>
                        <input type="text" name="image_path" id="image_path" class="form-control" value="{{ old('image_path') }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="type_id">Tipologia:</label>
                        <select name="type_id" id="type_id" class="form-control">
                            <option value="">Seleziona una tipologia</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ $project->type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="technologies">Tecnologie:</label>
                        <select name="technologies[]" id="technologies" class="form-control" multiple> <!-- creo un elemento <select> con l'attributo multiple, il che significa che l'utente può selezionare più di un'opzione -->
                            @foreach($technologies as $technology) <!-- Itero attraverso tutte le tecnologie disponibili, rappresentate dalla variabile $technologies. -->
                            <!-- Per ogni tecnologia, viene generato un elemento <option> con un valore uguale all'id della tecnologia e il testo dell'opzione corrisponde al nome della tecnologia -->
                                <!-- Suiccessivamente controllo se l'id della tecnologia è presente nell'array delle tecnologie selezionate. Se sì, l'opzione sarà selezionata; altrimenti, non sarà selezionata. L'uso di old('technologies', $project->technologies->pluck('id')->toArray()) è necessario per mantenere le selezioni durante la modifica di un progetto. old('technologies') restituirà i valori precedentemente selezionati, mentre $project->technologies->pluck('id')->toArray() fornirà le tecnologie già associate a quel progetto. -->
                                <option value="{{ $technology->id }}" {{ in_array($technology->id, old('technologies', $project->technologies->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $technology->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Crea progetto</button>
                </form>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-2">Torna alla lista</a>
            </div>
        </div>
    </div>
@endsection