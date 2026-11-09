<?php 

namespace App\Repositories\Console;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

Class CompanyRepository
{
    public function store($data)
    {
        $data['created_by'] = Auth::id();
        Company::create($data);
    }

    public function update(int $id, $data)
    {
        $data['created_by'] = Auth::id();
        Company::where('id', $id)->update($data);
    }

    public function destroy(int $id)
    {
        Company::where('id', $id)->delete();
    }
}