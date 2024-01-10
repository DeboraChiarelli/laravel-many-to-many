@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{ $project->title }}</h2>
                <p>{{ $project->description }}</p>
                <img src="{{ $project->image_path }}" alt="{{ $project->title }}" class="img-fluid">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-primary">Torna alla lista</a>
            </div>
        </div>
    </div>
@endsection