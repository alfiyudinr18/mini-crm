<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $companies = Company::orderBy('created_at','desc')->paginate(10);
        if ($request->wantsJson()) return response()->json($companies);
        return inertia('Companies/Index', compact('companies'));
    }

    public function create()
    {
        return inertia('Companies/Create');
    }

    public function store(CompanyRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('companies', 'public');
            $data['logo'] = $path;
        }

        $company = Company::create($data);
        return redirect()->route('companies.index')->with('success','Company created.');
    }

    public function show(Company $company)
    {
        return inertia('Companies/Show', compact('company'));
    }

    public function edit(Company $company)
    {
        return inertia('Companies/Edit', compact('company'));
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $data = $request->validated();
        if ($request->hasFile('logo')) {
            // delete old
            if ($company->logo) Storage::disk('public')->delete($company->logo);
            $data['logo'] = $request->file('logo')->store('companies', 'public');
        }
        $company->update($data);
        return redirect()->route('companies.index')->with('success','Company updated.');
    }

    public function destroy(Company $company)
    {
        if ($company->logo) Storage::disk('public')->delete($company->logo);
        $company->delete();
        return redirect()->route('companies.index')->with('success','Company deleted.');
    }
}
