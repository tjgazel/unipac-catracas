<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GerenciarUsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $usuarios = User::all();

        return view('auth.gerenciar', compact(['usuarios']));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        return view('auth.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'digits:11', Rule::unique('users', 'cpf')->ignore($id)],
            'tipo_usuario' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($data['password']);

        User::findOrFail($id)->update($data);

        toastr()->success('Atualizado com sucesso');

        return redirect()->route('gerenciar-usuarios.index');
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->id == auth()->user()->id) {
            toastr()->error('Você não pode excluir sua conta');

            return redirect()->route('gerenciar-usuarios.index');
        }

        $usuario->delete();

        toastr()->success('Removido com sucesso');

        return redirect()->route('gerenciar-usuarios.index');
    }
}
