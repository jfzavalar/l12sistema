<?php

namespace App\Livewire\Intranet\Configuracion;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class Activos extends Component
{
    public $pass_anterior,$pass_nuevo,$pass_repetir;

    public function render()
    {
        return view('livewire.intranet.configuracion.activos');
    }

    public function actualizar_password()
    {
        $this->validate([
            'pass_anterior' => 'required',
            'pass_nuevo' => 'required|min:8|same:pass_repetir',
            'pass_repetir' => 'required|min:8',
        ], [
            'pass_anterior.required' => 'Debes ingresar tu contraseña actual.',
            'pass_nuevo.required' => 'Debes ingresar una nueva contraseña.',
            'pass_nuevo.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'pass_nuevo.same' => 'Las contraseñas no coinciden.',
            'pass_repetir.required' => 'Debes repetir la nueva contraseña.',
            'pass_repetir.min' => 'Debe tener al menos 8 caracteres.',
        ]);

        $usuario = Auth::user();

        // 🔒 Verificar que la contraseña anterior sea correcta
        if (!Hash::check($this->pass_anterior, $usuario->password)) {
            $this->addError('pass_anterior', 'La contraseña actual no es correcta.');
            return;
        }

        // ✅ Actualizar contraseña
        $usuario->password = Hash::make($this->pass_nuevo);
        $usuario->save();

        // Limpiar campos
        $this->reset(['pass_anterior', 'pass_nuevo', 'pass_repetir']);

        session()->flash('message', 'Tu contraseña se actualizó correctamente.');
    }
}
