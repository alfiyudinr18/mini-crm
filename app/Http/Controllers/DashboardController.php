<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employe;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Companies
        $totalCompanies = Company::count();

        // Total Employees
        $totalEmployees = Employe::count();

        // Companies added in last 30 days
        $recentCompanies = Company::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Employees added in last 30 days
        $recentEmployees = Employe::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // Average employees per company
        $averageEmployeesPerCompany = $totalCompanies > 0
            ? round($totalEmployees / $totalCompanies, 1)
            : 0;

        // Companies without employees
        $companiesWithoutEmployees = Company::doesntHave('employes')->count();

        $stats = [
            'totalCompanies' => $totalCompanies,
            'totalEmployees' => $totalEmployees,
            'recentCompanies' => $recentCompanies,
            'recentEmployees' => $recentEmployees,
            'averageEmployeesPerCompany' => $averageEmployeesPerCompany,
            'companiesWithoutEmployees' => $companiesWithoutEmployees,
        ];

        return inertia('Dashboard', [
            'stats' => $stats,
        ]);
    }
}
