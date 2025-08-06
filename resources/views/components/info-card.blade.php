<div {{ $attributes->merge(['class' => 'info-card']) }}>
    <div class="flex items-center mb-4 text-blue-600">
        <i class="fas {{ $icon ?? 'fa-info-circle' }} mr-2"></i>
        <h3 class="text-lg font-semibold">{{ $title }}</h3>
    </div>
    <div class="space-y-3 pl-8 text-gray-700">
        {{ $slot }}
    </div>
</div>
