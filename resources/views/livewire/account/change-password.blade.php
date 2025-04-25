<div>
    <!-- HEADER -->
    <x-header title="Change Password" separator progress-indicator />

    <!-- TABLE  -->
    <x-card>
        <x-form wire:submit="save">
            <x-password class="input-sm" label="Current password" wire:model="current_password"
                password-icon="o-lock-closed" password-visible-icon="o-lock-open" />
            <x-password class="input-sm" label="New password" wire:model="password" password-icon="o-lock-closed"
                password-visible-icon="o-lock-open" />
            <x-password class="input-sm" label="Confirm password" wire:model="password_confirmation"
                password-icon="o-lock-closed" password-visible-icon="o-lock-open" />

            <x-slot:actions>
                <x-button label="Save" icon="o-paper-airplane" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>

</div>
