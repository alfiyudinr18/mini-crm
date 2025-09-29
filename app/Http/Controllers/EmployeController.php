<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Company;
use App\Http\Requests\EmployeRequest;
use Illuminate\Http\RedirectResponse;

class EmployeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employes = Employe::with('company')
            ->paginate(10)
            ->through(fn ($employe) => [
                'id' => $employe->id,
                'first_name' => $employe->first_name,
                'last_name' => $employe->last_name,
                'email' => $employe->email,
                'phone' => $employe->phone,
                'company' => $employe->company?->name,
             ]);
            return inertia('Employes/Index', [
                'employes' => $employes,
                'auth' => [
                    'user' => [
                        'id' => auth()->id(),
                        'name' => auth()->user()->name,
                        'email' => auth()->user()->email,
                        'roles' => auth()->user()->getRoleNames(),
                    ],
                ],
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('Employes/Create', [
            'companies' => Company::all(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeRequest $request): RedirectResponse
    {
        Employe::create($request->validated());
        return redirect()->route('employes.index')
            ->with('success', 'Employe created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employe $employe)
    {
        return Inertia('Employes/Show', [
            'employe' => $employe->load('company'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employe $employe)
    {
        return Inertia('Employes/Edit', [
            'employe' => $employe,
            'companies' => Company::all(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeRequest $request, Employe $employe)
    {
        $employe->update($request->validated());
        return redirect()->route('employes.index')
            ->with('success', 'Employe updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employe $employe)
    {
        $employe->delete();
        return redirect()->route('employes.index')
            ->with('success', 'Employe deleted successfully.');
    }
}
