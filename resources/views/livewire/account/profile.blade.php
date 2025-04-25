<div>
    <!-- HEADER -->
    <x-header title="Profile" separator progress-indicator />

    <!-- TABLE  -->
    <x-card>
        <x-form wire:submit="save">
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-8">
                <div class="sm:w-1/3 flex justify-center pt-3">
                    <x-file hint="Click to change | Max 1MB" wire:model="photo" accept="image/png, image/jpeg, image/webp"
                        crop-after-change>
                        <img src="{{ $frm->data?->path_avatar }}" class="h-32 rounded-lg" />
                    </x-file>
                </div>
                <div class="w-full space-y-4">
                    <x-input class="input-sm" label="Name" icon="o-user" wire:model="frm.name" />
                    <x-input class="input-sm" label="Email" icon="o-envelope" wire:model="frm.email" readonly />
                </div>
            </div>
            <x-slot:actions>
                <x-button label="Save" icon="o-paper-airplane" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </x-card>

</div>
