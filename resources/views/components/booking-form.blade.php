<div class="bg-white p-[30px] rounded-[16px] shadow relative z-10">
    <h5 class="text-center mb-[30px]">Book Your Stay</h5>

    <form wire:submit.prevent="submit">
        <div class="grid gap-[30px]">
            <x-input.date label="Check In" wire:model="check_in" />
            <x-input.date label="Check Out" wire:model="check_out" />
            <x-input.select label="Adult" wire:model="adult" :options="range(1, 9)" suffix="Person" />
            <x-input.select label="Child" wire:model="child" :options="range(0, 9)" suffix="Child" />

            <button type="submit" class="theme-btn btn-style fill no-border min-w-[140px] h-[56px] rounded-[6px]">
                <span>Check Now</span>
            </button>
        </div>
    </form>
</div>
