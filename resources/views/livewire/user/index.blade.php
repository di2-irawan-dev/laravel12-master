<div>
    <!-- HEADER -->
    <x-header title="{{ $title }}" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input class="input-sm" placeholder="Search..." wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button @click="$wire.drawerFilter = true" responsive icon="o-funnel" class="btn-sm btn-primary indicator">
                Filters
                @if ($countFilter > 0)
                    <x-badge value="{{ $countFilter }}" class="badge-secondary badge-xs indicator-item" />
                @endif
            </x-button>
            <x-button label="Create" @click="$wire.create" responsive icon="o-plus" class="btn-sm btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- TABLE  -->
    <x-card>
        <x-table class="table-sm" :headers="$headers" :rows="$users" :sort-by="$sortBy"
            @row-click="$wire.edit($event.detail.id)" show-empty-text striped with-pagination per-page="perPage"
            :per-page-values="[5, 10, 20, 50, 100]">
            @scope('cell_id', $user, $users)
                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
            @endscope
            @scope('actions', $user, $title)
                <x-button icon="o-trash" wire:confirm="Are you sure you want to delete this {{ $title }}?"
                    wire:click="delete({{ $user['id'] }})" spinner class="btn-ghost btn-sm text-error" />
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawerFilter" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input class="input-sm" placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass"
            @keydown.enter="$wire.drawerFilter = false" />
        <x-select label="Verified" class="select-sm" placeholder="---" wire:model.defer="isVerified" :options="$noYesOptions"
            icon="o-bars-3" placeholder-value="" />
        <x-slot:actions>
            <x-button class="btn-sm" label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-sm btn-primary" wire:click="applyFilters" />
        </x-slot:actions>
    </x-drawer>

    <!-- FORM MODAL -->
    <x-modal wire:model="modalForm" title="{{ $title }}" :subtitle="$isEdit ? 'Update ' . $title : 'Create ' . $title" separator>
        <x-form wire:submit="save">
            <x-input label="Name" icon="o-user" placeholder="Full name" class="input-sm" wire:model="frm.name" />
            <x-input label="Email" icon="o-envelope" placeholder="email@example.com" class="input-sm"
                wire:model="frm.email" />
            @if (!$isEdit)
                <x-password class="input-sm" label="Password" password-icon="o-lock-closed"
                    password-visible-icon="o-lock-open" wire:model="frm.password" />
            @endif
            <x-slot:actions>
                <x-button label="Save" icon="o-paper-airplane" class="btn-sm btn-primary" type="submit"
                    spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

</div>
