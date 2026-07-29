<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm ring-1 ring-slate-900/5">
    <ul role="list" class="divide-y divide-slate-100">
        @foreach ($items as $download)
            <li class="group relative flex flex-col gap-x-6 gap-y-4 px-4 py-5 hover:bg-slate-50 sm:flex-row sm:items-center sm:px-6 transition duration-200">
                <div class="flex flex-1 items-start gap-x-4">
                    <div class="mt-1 flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-100 border border-slate-200/60 text-slate-500 group-hover:bg-primary/10 group-hover:border-primary/20 group-hover:text-primary transition duration-300">
                        @php
                            $ext = strtolower(pathinfo($download->file_path, PATHINFO_EXTENSION));
                            $icon = match($ext) {
                                'pdf' => 'file-text',
                                'doc', 'docx' => 'file-word',
                                'xls', 'xlsx' => 'file-spreadsheet',
                                'zip', 'rar' => 'file-archive',
                                default => 'file',
                            };
                            $colorClass = match($ext) {
                                'pdf' => 'text-red-500',
                                'doc', 'docx' => 'text-blue-500',
                                'xls', 'xlsx' => 'text-green-600',
                                'zip', 'rar' => 'text-amber-500',
                                default => 'text-slate-500',
                            };
                        @endphp
                        <i data-lucide="{{ $icon }}" class="h-6 w-6 {{ $colorClass }}"></i>
                    </div>
                    <div class="min-w-0 flex-auto">
                        <p class="text-base font-semibold leading-6 text-slate-900 mb-1 group-hover:text-primary transition">
                            <a href="{{ route('downloads.download', $download) }}">
                                <span class="absolute inset-0"></span>
                                {{ $download->title }}
                            </a>
                        </p>
                        @if ($download->description)
                            <p class="text-sm leading-5 text-slate-500 mb-2 line-clamp-2">{{ $download->description }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs font-medium text-slate-400">
                            <div class="flex items-center gap-1.5 rounded-md bg-slate-100 px-2 py-0.5">
                                <i data-lucide="hard-drive" class="h-3 w-3"></i> {{ $download->formattedSize() }}
                            </div>
                            <div class="flex items-center gap-1.5 rounded-md bg-slate-100 px-2 py-0.5">
                                <i data-lucide="tag" class="h-3 w-3"></i> {{ $download->categoryLabel() }}
                            </div>
                            @if ($download->published_at)
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="h-3 w-3"></i> {{ $download->published_at->format('M j, Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex shrink-0 items-center sm:flex-col sm:items-end">
                    <button type="button" class="relative z-10 flex items-center justify-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition">
                        <i data-lucide="download" class="h-4 w-4 text-slate-400 group-hover:text-primary transition"></i>
                        Download <span class="uppercase tracking-widest text-[10px] text-slate-400 ml-1">{{ $ext }}</span>
                    </button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
