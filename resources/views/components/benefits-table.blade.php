@props(['plans', 'benefitRows'])

<div class="overflow-x-auto rounded-[var(--radius-card)] border border-slate-200 bg-white" style="box-shadow: var(--shadow-card)">
    <table class="w-full min-w-[640px] text-left text-sm">
        <thead>
            <tr class="border-b border-slate-200 bg-slate-50">
                <th class="px-4 py-4 font-semibold text-slate-900 sm:px-6">Benefit</th>
                @foreach ($plans as $plan)
                    <th class="px-4 py-4 text-center font-semibold text-slate-900 sm:px-6">{{ $plan->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach ($benefitRows as $row)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-4 py-3 font-medium text-slate-700 sm:px-6">{{ $row->benefit_label }}</td>
                    @foreach ($plans as $plan)
                        @php $included = $plan->benefits->firstWhere('benefit_key', $row->benefit_key)?->is_included; @endphp
                        <td class="px-4 py-3 text-center sm:px-6">
                            @if ($included)
                                <i data-lucide="check-circle" class="mx-auto h-5 w-5 text-primary"></i>
                                <span class="sr-only">Included</span>
                            @else
                                <i data-lucide="minus" class="mx-auto h-5 w-5 text-slate-300"></i>
                                <span class="sr-only">Not included</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
