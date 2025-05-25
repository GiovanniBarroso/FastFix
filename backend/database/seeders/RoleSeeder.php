<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'admin', 'descripcion' => 'Administrador con acceso completo al sistema, incluyendo gestión técnica.'],
            ['nombre' => 'cliente', 'descripcion' => 'Cliente con permisos para comprar, consultar presupuestos y gestionar su perfil.'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['nombre' => $role['nombre']], $role);
        }
    }
}
