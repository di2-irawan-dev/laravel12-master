<?php

namespace App\Livewire\Account;

use App\Livewire\Forms\UserForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

#[Title('Profile')]
class Profile extends Component
{
    use WithFileUploads;
    use Toast;

    public UserForm $frm;
    public $photo;

    public function mount()
    {
        $this->frm->setData(Auth::user());
    }

    public function save()
    {
        $this->validate();

        if ($this->photo) {
            if ($this->frm->avatar) {
                Storage::disk('public')->delete($this->frm->avatar);
            }

            $path = $this->photo->store('user', 'public');
            $this->frm->avatar = $path;
        }

        $this->frm->update();
        $this->success(
            'Profile account successfully updated.',
            redirectTo: '/account/profile'
        );
    }

    public function render()
    {
        return view('livewire.account.profile');
    }
}
