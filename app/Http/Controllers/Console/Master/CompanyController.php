<?php

namespace App\Http\Controllers\Console\Master;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyCreateRequest;
use App\DataTables\Console\CompanyDataTable;
use App\Http\Requests\CompanyUpdateRequest;
use App\Repositories\Console\CompanyRepository;

class CompanyController extends Controller
{
    public function index(CompanyDataTable $dataTable)
    {
        return $dataTable->render('console.master.company.index');
    }

    public function create()
    {
        return view('console.master.company.create');
    }

    public function store(CompanyCreateRequest $request, CompanyRepository $repository)
    {
        try {
            $data = $request->validated();
            $repository->store($data);

            return redirect()->route('console.company.index')->with('success', 'Berhasil menginput perusahaan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.company.index')->with('error', 'Gagal menginput perusahaan');
        }
    }

    public function show(Company $company)
    {
        return view('console.master.company.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('console.master.company.edit', compact('company'));
    }

    public function update(CompanyUpdateRequest $request, Company $company, CompanyRepository $repository)
    {
        try {
            $data = $request->validated();
            $repository->update($company->id, $data);

            return redirect()->route('console.company.index')->with('success', 'Berhasil mengupdate perusahaan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.company.index')->with('error', 'Gagal mengupdate perusahaan');
        }
    }

    public function destroy(Company $company, CompanyRepository $repository)
    {
        try {
            $repository->destroy($company->id);

            return redirect()->route('console.company.index')->with('success', 'Berhasil menghapus perusahaan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('console.company.index')->with('error', 'Gagal menghapus perusahaan');
        }
    }
}
