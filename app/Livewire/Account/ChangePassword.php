<?php

namespace App\Livewire\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Change Password')]
class ChangePassword extends Component
{
    public ?User $data;

    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->data = Auth::user();
    }

    public function rules()
    {
        return [
            'current_password' => ['required'],
            'password' => ['required', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function save()
    {
        $this->validate($this->rules());

        if (!Hash::check($this->current_password, $this->data->password)) {
            $this->addError('current_password', 'The provided password does not match your current password.');
            return;
        }

        $this->data->password = $this->password;
        $this->data->save();

        Auth::logout();
        return redirect()->route('login')->with('status', 'Password has been changed, please login.');
    }

    public function render()
    {
        return view('livewire.account.change-password');
    }
}
