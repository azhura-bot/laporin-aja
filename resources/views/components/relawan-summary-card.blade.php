@props([
    'title',
    'value',
    'description',
    'icon' => 'fas fa-users',
    'iconBgClass' => 'bg-blue-100',
    'iconTextClass' => 'text-blue-600',
    'valueTextClass' => 'text-blue-600',
    'footerText' => null,
    'footerClass' => 'text-gray-400'
])

<div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-200">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0">
            <div class="text-sm font-semibold text-slate-500 uppercase mb-3">{{ $title }}</div>
            <div class="text-4xl font-bold {{ $valueTextClass }}">{{ $value }}</div>
            <p class="mt-3 text-sm text-slate-500">{{ $description }}</p>
        </div>
        <div class="{{ $iconBgClass }} rounded-3xl p-4 shrink-0">
            <i class="{{ $icon }} {{ $iconTextClass }} text-2xl"></i>
        </div>
    </div>
    @if($footerText)
        <div class="mt-6 pt-4 border-t">
            <p class="text-sm {{ $footerClass }}">{{ $footerText }}</p>
        </div>
    @endif
</div>
