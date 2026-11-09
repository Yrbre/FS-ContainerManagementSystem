<?php

namespace App\Http\Controllers\Console\Master;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Console\AdminDatatable;
use App\Enums\RoleEnum;
use App\Repositories\Console\AdminRepository;
use App\Http\Requests\Console\AdminCreateRequest;
use App\Http\Requests\Console\AdminUpdateRequest;

class AdminController extends Controller
{

    protected $roles = [
        RoleEnum::ADMIN,
        RoleEnum::CHECKER,
        RoleEnum::SUPERVISOR,
        RoleEnum::MANAGER,
        RoleEnum::FINANCE,
        RoleEnum::FINANCESTAFF,
        RoleEnum::PURCHASING,
        RoleEnum::SITEMANAGER
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminDatatable $dataTable)
    {
        $content_title = 'User';
        return $dataTable->render('console.master.admin.index', compact('content_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $content_title = 'User';
        $roles = $this->roles;

        return view('console.master.admin.create', compact('content_title', 'roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCreateRequest $request, AdminRepository $repository)
    {
        try {
            $data = $request->validated();
            return $repository->store($data);
        } catch (\Exception $e) {
            return redirect()->route('console.admin.index')->with('error', $e->getMessage());
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return view('console.master.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin) 
    {
        $content_title = 'User';
        $roles = $this->roles;

        return view('console.master.admin.edit', compact('admin', 'content_title', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUpdateRequest $request, Admin $admin, AdminRepository $repository)
    {
        try {
            $data = $request->validated();
            return $repository->update($admin, $data);
        } catch (\Exception $e) {
            return redirect()->route('console.admin.index')->with('error', $e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin, AdminRepository $repository)
    {

        try {
            return $repository->destroy($admin);
        } catch (\Exception $e) {
            return redirect()->route('console.admin.index')->with('error', $e->getMessage());
        }
        
    }
}
