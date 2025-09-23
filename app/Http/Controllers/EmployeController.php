<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\Company;
use App\Http\Requests\EmployeRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class EmployeController extends Controller
{
    /**
     * Display a listing of the employes.
     */
    public function index(): Response
    {
        $employes = Employe::with('company')
            ->paginate(10)
            ->through(fn ($employe) => [
                'id'         => $employe->id,
                'first_name' => $employe->first_name,
                'last_name'  => $employe->last_name,
                'email'      => $employe->email,
                'phone'      => $employe->phone,
                'company'    => $employe->company?->name,
            ]);

        return Inertia::render('Employes/Index', [
            'employes' => $employes,
        ]);
    }

    /**
     * Show the form for creating a new employe.
     */
    public function create(): Response
    {
        return Inertia::render('Employes/Create', [
            'companies' => Company::all(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created employe in storage.
     */
    public function store(EmployeRequest $request): RedirectResponse
    {
        Employe::create($request->validated());

        return redirect()->route('employes.index')
            ->with('success', 'Employe created successfully.');
    }

    public function show(Employe $employe): Response
    {
        return Inertia::render('Employes/Show', [
            'employe' => $employe->load('company'),
        ]);
    }

    /**
     * Show the form for editing the specified employe.
     */
    public function edit(Employe $employe): Response
    {
        return Inertia::render('Employes/Edit', [
            'employe'  => $employe,
            'companies' => Company::all(['id', 'name']),
        ]);
    }

    /**
     * Update the specified employe in storage.
     */
    public function update(EmployeRequest $request, Employe $employe): RedirectResponse
    {
        $employe->update($request->validated());

        return redirect()->route('employes.index')
            ->with('success', 'Employe updated successfully.');
    }

    /**
     * Remove the specified employe from storage.
     */
    public function destroy(Employe $employe): RedirectResponse
    {
        $employe->delete();

        return redirect()->route('employes.index')
            ->with('success', 'Employe deleted successfully.');
    }
}
