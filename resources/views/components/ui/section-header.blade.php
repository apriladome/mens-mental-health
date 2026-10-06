@props([
    'overline' => null,
    'title',
    'description' => null,
    'align' => 'left',
])

<div {{ $attributes->merge(['class' => $align === 'center' ? 'text-center max-w-2xl mx-auto mb-10' : 'max-w-2xl mb-8']) }}>
    @if($overline)
        <span class="inline-block text-xs uppercase font-mono tracking-widest text-teal-400 mb-2.5 font-medium">
            {{ $overline }}
        </span>
    @endif

    <h2 class="font-serif text-2xl sm:text-3xl lg:text-4xl font-semibold text-text-primary tracking-tight leading-tight">
        {{ $title }}
    </h2>

    @if($description)
        <p class="mt-3 text-text-secondary text-base sm:text-lg leading-relaxed">
            {{ $description }}
        </p>
    @endif
</div>