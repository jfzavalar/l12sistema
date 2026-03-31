<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsuariosExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel; 
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("procesos.admin.users.index");
    }

    public function editRoles(User $user)
    {
        // $roles = Role::orderBy('rol')->get();
        $roles = Role::orderBy('name', 'asc')->get();

        return view('procesos.admin.users.assign-roles', compact('user', 'roles'));
    }

    public function updateRoles(Request $request, User $user)
    {
        $user->syncRoles($request->roles); // asigna los roles
        return redirect()->back()->with('success', 'Roles actualizados correctamente.');
    }

    //Exportar a Excel
    public function exportarExcel()
    {
        return Excel::download(new UsuariosExport, 'usuarios.xlsx');
    }
}
