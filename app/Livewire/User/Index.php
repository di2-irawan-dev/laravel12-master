<?php

namespace App\Livewire\User;

use App\Enums\NoYes;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Title('User')]
class Index extends Component
{
    use WithPagination;
    use Toast;

    public string $title = "User";
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public int $perPage = 10;
    public string $search = '';
    public bool $drawerFilter = false;
    public bool $modalForm = false;
    public bool $isEdit = false;
    public ?NoYes $isVerified = null;

    public UserForm $frm;

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#', 'sortable' => false, 'class' => 'w-1 text-base-content'],
            ['key' => 'name', 'label' => 'Name', 'class' => 'text-base-content'],
            ['key' => 'email', 'label' => 'E-mail', 'class' => 'text-base-content'],
            ['key' => 'email_verified_at', 'label' => 'Verified', 'format' => fn($row, $field) => $field ? 'Yes' : 'No'],
        ];
    }

    public function applyFilters()
    {
        $this->drawerFilter = false;
        $this->resetPage();
    }

    public function dataColletion()
    {
        return User::filter($this->search)
            ->withEmailVerified($this->isVerified)
            ->sorted($this->sortBy);
    }

    public function users(): LengthAwarePaginator
    {
        return $this->dataColletion()->paginate($this->perPage)->onEachSide(1);
    }

    public function updated($property): void
    {
        if (! is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function clear(): void
    {
        $this->reset([
            'drawerFilter',
            'search',
            'isVerified',
        ]);
        $this->resetPage();
    }

    public function getCountFilterProperty(): int
    {
        $count = 0;

        if ($this->search !== '') {
            $count++;
        }

        if ($this->isVerified) {
            $count++;
        }

        return $count;
    }

    public function create(): void
    {
        $this->isEdit = false;
        $this->frm->resetForm();
        $this->modalForm = true;
    }

    public function edit($id): void
    {
        $data = User::find($id);
        if ($data) {
            $this->isEdit = true;
            $this->frm->setData($data);
            $this->modalForm = true;
        }
    }

    public function save(): void
    {
        if (isset($this->frm->data)) {
            $this->frm->update();
            $this->success($this->title . ' updated successfully.');
        } else {
            $this->frm->store();
            $this->success($this->title . ' created successfully.');
        }
        $this->modalForm = false;
    }

    public function delete($id): void
    {
        $data = User::find($id);
        if ($data) {
            $this->frm->setData($data);
            $this->frm->delete();
            $this->success($this->title . ' deleted successfully.');
        }
    }

    public function render()
    {
        return view('livewire.user.index', [
            'users' => $this->users(),
            'headers' => $this->headers(),
            'countFilter' => $this->countFilter,
            'noYesOptions' => NoYes::options(),
        ]);
    }
}
