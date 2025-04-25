<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $data;

    public $id;
    public $name;
    public $email;
    public $password;
    public $avatar;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->id),
            ],
            'password' => $this->id ? ['nullable'] : ['required', 'min:8'],
        ];
    }

    public function resetForm()
    {
        $this->reset();
        $this->resetErrorBag();
    }

    public function setData(User $data)
    {
        $this->resetForm();
        $this->data = $data;
        $this->id = $data->id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->avatar = $data->avatar;
    }

    public function store()
    {
        $this->validate();
        try {
            $this->data = new User();
            $this->data->name = $this->name;
            $this->data->email = $this->email;
            $this->data->password = $this->password;
            $this->data->email_verified_at = Carbon::now();
            $this->data->save();
            $this->resetForm();
        } catch (\Exception $e) {
            \Log::error('Error creating user: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $this->validate();
        try {
            $this->data->name = $this->name;
            $this->data->email = $this->email;
            $this->data->avatar = $this->avatar;
            $this->data->save();
            $this->resetForm();
        } catch (\Exception $e) {
            \Log::error('Error updating user: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        try {
            $this->data->delete();
        } catch (\Exception $e) {
            \Log::error('Error deleting user: ' . $e->getMessage());
        }
    }
}
