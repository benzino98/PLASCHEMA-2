@props([
    'items' => [],
    'allowMultiple' => false,
])

<div
    x-data="{
        open: {{ $allowMultiple ? '[]' : 'null' }},
        toggle(id) {
            if ({{ $allowMultiple ? 'true' : 'false' }}) {
                const i = this.open.indexOf(id);
                i === -1 ? this.open.push(id) : this.open.splice(i, 1);
            } else {
                this.open = this.open === id ? null : id;
            }
        },
        isOpen(id) {
            return {{ $allowMultiple ? 'true' : 'false' }}
                ? this.open.includes(id)
                : this.open === id;
        }
    }"
    {{ $attributes->merge(['class' => 'space-y-3']) }}
>
    @foreach ($items as $index => $item)
        <div class="overflow-hidden rounded-[var(--radius-card)] border border-slate-200 bg-white">
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left transition hover:bg-slate-50"
                @click="toggle({{ $index }})"
                :aria-expanded="isOpen({{ $index }})"
            >
                <span class="font-medium text-slate-900">{{ $item['question'] }}</span>
                <i
                    data-lucide="chevron-down"
                    class="h-5 w-5 shrink-0 text-slate-400 transition-transform duration-200"
                    :class="isOpen({{ $index }}) && 'rotate-180'"
                ></i>
            </button>
            <div
                x-show="isOpen({{ $index }})"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                x-cloak
            >
                <div class="border-t border-slate-100 px-5 py-4 text-sm leading-relaxed text-slate-600">
                    {{ $item['answer'] }}
                </div>
            </div>
        </div>
    @endforeach

    @if ($slot->isNotEmpty())
        {{ $slot }}
    @endif
</div>
