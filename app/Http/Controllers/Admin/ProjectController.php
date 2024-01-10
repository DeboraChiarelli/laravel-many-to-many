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
        $project->load('technologies'); // Carico la relazione 'technologies'
        return view('admin.projects.show', compact('project'));
    }

    public function create()
    {
        $technologies = Technology::all();
        return view('admin.projects.create', compact('technologies'));
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
            'technologies' => 'nullable|array', // Valida che technologies sia un array
            'technologies.*' => 'exists:technologies,id', // Valida che ciascun elemento nell'array esista come tecnologia
        ]);
        // La funzione create accetta un array associativo di attributi del modello e crea una nuova riga nel database con quegli attributi. In questo caso, il metodo onlyserve ad estrarre solo gli attributi specificati dalla richiesta HTTP. L'array ['title', 'image_path', 'description', 'type_id'] contiene i campi del modello Project da assegnare al nuovo progetto.
        $project = Project::create($request->only(['title', 'image_path', 'description', 'type_id']));
        // Verifico se l'utente ha selezionato delle nuove tecnologie per il progetto
        if ($request->has('technologies')) {
            $project->technologies()->attach($request->input('technologies')); // Con questo metodo aggiungo nuove associazioni tra il progetto e le tecnologie specificate nell'array fornito in input ($request->input('technologies')) tramite il metodo attach.
        }
    
        return redirect()->route('admin.projects.index')
            ->with('success', 'Progetto creato con successo');
    }

    public function edit(Project $project)
    {
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'technologies'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image_path' => 'required|string',
            'description' => 'required|string',
            'type_id' => 'nullable|exists:types,id', // Grantisceche type_id sia valido, se presente
            'technologies' => 'nullable|array', // Valida che technologies sia un array
            'technologies.*' => 'exists:technologies,id', // Valida che ciascun elemento nell'array esista come tecnologia
        ]);
    
        $project->update($request->only(['title', 'image_path', 'description', 'type_id']));
        // Verifico se l'utente ha selezionato delle nuove tecnologie per il progetto
        if ($request->has('technologies')) {
            $project->technologies()->sync($request->input('technologies')); // Se sono presenti nuove tecnologie, il metodo sync viene chiamato sulla relazione technologies del modello Project. Il metodo sync sincronizza le tecnologie associate al progetto con l'array fornito in input. Le tecnologie esistenti che non sono più presenti nell'array vengono rimosse, e le nuove tecnologie vengono aggiunte.
        } else {
            // Se non sono selezionate nuove tecnologie, vengono rimosse tutte le associazioni, perché l'utente non ha selezionato nuove tecnologie (la condizione è falsa), quindi ha intenzione di rimuovere tutte le tecnologie associate al progetto.
            $project->technologies()->detach(); // Per questo viene utilizzato il metodo detach, che rimuove tutte le associazioni tra il progetto e le tecnologie, lasciando il progetto senza alcuna tecnologia associata.
        }
    
        return redirect()->route('admin.projects.index')
            ->with('success', 'Progetto aggiornato con successo');
    }

}

/* L'utilizzo di ->with('success', 'Project created successfully') viene utilizzato spessp in Laravel per passare dei messaggi di feedback (come un messaggio di successo) alla vista successiva dopo una reindirizzamento.
In quersto caso specifico, dopo che un nuovo progetto è stato creato con successo, utilizzando Project::create($request->all()), si reindirizza l'utente alla pagina di elenco dei progetti. 
Tuttavia, si desidera fornire all'utente un feedback visivo che indichi che l'operazione è stata completata con successo. 
->with('success', 'Project created successfully'): passa un messaggio di tipo success alla sessione. Il primo parametro è la chiave (success), e il secondo è il valore associato a questa chiave (il messaggio).
Quando si reindirizza l'utente, questo messaggio sarà temporaneamente memorizzato nella sessione e può essere recuperato nella vista successiva. */