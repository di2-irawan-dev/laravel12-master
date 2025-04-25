<div>
    <!-- HEADER -->
    <x-header title="Dashboard" separator progress-indicator />

    <!-- STATISTIC -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat title="Messages" value="44" icon="o-envelope" tooltip="Hello" color="text-primary" />

        <x-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-up" tooltip-bottom="There" />

        <x-stat title="Lost" description="This month" value="34" icon="o-arrow-trending-down"
            tooltip-left="Ops!" />

        <x-stat title="Sales" description="This month" value="22.124" icon="o-arrow-trending-down"
            class="text-orange-500" color="text-pink-500" tooltip-right="Gosh!" />
    </div>

    <!-- TABLE  -->
    <x-card title="Oldest orders" separator class="mt-4">
        <x-slot:menu>
            <x-button label="Order" icon-right="o-arrow-right" class="btn-sm btn-ghost" />
        </x-slot:menu>
        <x-table class="table-sm" :headers="$headers" :rows="$users" :sort-by="$sortBy">
            @scope('actions', $user)
                <x-button icon="o-trash" wire:click="delete({{ $user['id'] }})" spinner
                    class="btn-ghost btn-sm text-error" />
            @endscope
        </x-table>
    </x-card>

    <!-- FILTER DRAWER -->
    <x-drawer wire:model="drawer" title="Filters" right separator with-close-button class="lg:w-1/3">
        <x-input placeholder="Search..." wire:model.live.debounce="search" icon="o-magnifying-glass"
            @keydown.enter="$wire.drawer = false" />

        <x-slot:actions>
            <x-button label="Reset" icon="o-x-mark" wire:click="clear" spinner />
            <x-button label="Done" icon="o-check" class="btn-primary" @click="$wire.drawer = false" />
        </x-slot:actions>
    </x-drawer>

    <!-- FORM MODAL -->
    <x-modal wire:model="modalForm" title="Hello" subtitle="Livewire example">
        <x-form no-separator>
            <x-input label="Name" icon="o-user" placeholder="The full name" />
            <x-input label="Email" icon="o-envelope" placeholder="The e-mail" />

            {{-- Notice we are using now the `actions` slot from `x-form`, not from modal --}}
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.modalForm = false" />
                <x-button label="Confirm" class="btn-primary" />
            </x-slot:actions>
        </x-form>
    </x-modal>
</div>
