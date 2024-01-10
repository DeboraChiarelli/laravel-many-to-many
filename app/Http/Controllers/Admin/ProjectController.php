<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function show(Project $project)
    {
        $project->load('type'); // Carica la relazione 'type'
        return view('admin.projects.show', compact('project'));
    }

    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
            'description' => 'required|string',
            'type_id' => 'nullable|exists:types,id', // Garantisceche type_id sia valido, se presente
        ]);
    
        Project::create($request->all());
    
        return redirect()->route('admin.projects.index')
            ->with('success', 'Progetto creato con successo');
    }

    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
            'description' => 'required|string',
            'type_id' => 'nullable|exists:types,id', // Grantisceche type_id sia valido, se presente
        ]);
    
        $project->update($request->all());
    
        return redirect()->route('admin.projects.index')
            ->with('success', 'Progetto aggiornato con successo');
    }

}

/* L'utilizzo di ->with('success', 'Project created successfully') viene utilizzato spessp in Laravel per passare dei messaggi di feedback (come un messaggio di successo) alla vista successiva dopo una reindirizzamento.
In quersto caso specifico, dopo che un nuovo progetto è stato creato con successo, utilizzando Project::create($request->all()), si reindirizza l'utente alla pagina di elenco dei progetti. 
Tuttavia, si desidera fornire all'utente un feedback visivo che indichi che l'operazione è stata completata con successo. 
->with('success', 'Project created successfully'): passa un messaggio di tipo success alla sessione. Il primo parametro è la chiave (success), e il secondo è il valore associato a questa chiave (il messaggio).
Quando si reindirizza l'utente, questo messaggio sarà temporaneamente memorizzato nella sessione e può essere recuperato nella vista successiva. */