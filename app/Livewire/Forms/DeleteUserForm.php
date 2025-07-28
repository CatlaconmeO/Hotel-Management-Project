<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class DeleteUserForm extends Form
{
    public string $password = '';

    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'current_password'],
        ];
    }
}
