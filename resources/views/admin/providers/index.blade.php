@extends('layouts.admin')

@section('title', 'Providers')
@section('page_heading', 'Healthcare Providers')

@section('content')
    @if (session('success'))
        <div class="mb-6 rounded-lg bg-primary-50 px-4 py-3 text-sm font-medium text-primary">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $providers->total() }} providers total</p>
        <a href="{{ route('admin.providers.create') }}" class="btn-primary !px-4 !py-2 text-xs">
            <i data-lucide="plus" class="h-4 w-4"></i> Add Provider
        </a>
    </div>

    <div class="card overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-900">Name</th>
                        <th class="px-4 py-3 font-semibold text-slate-900">LGA</th>
                        <th class="px-4 py-3 font-semibold text-slate-900">Specialty</th>
                        <th class="px-4 py-3 font-semibold text-slate-900">Status</th>
                        <th class="px-4 py-3 font-semibold text-slate-900">Published</th>
                        <th class="px-4 py-3 font-semibold text-slate-900"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($providers as $provider)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-4 py-3 font-medium text-slate-900">{{ $provider->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $provider->lga }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $provider->specialty }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $provider->accreditationColor() }}">
                                    {{ $provider->accreditationLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($provider->is_published)
                                    <span class="text-primary">Yes</span>
                                @else
                                    <span class="text-slate-400">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('providers.show', $provider) }}" class="text-slate-400 hover:text-primary" target="_blank" title="View public page">
                                        <i data-lucide="external-link" class="h-4 w-4"></i>
                                    </a>
                                    <a href="{{ route('admin.providers.edit', $provider) }}" class="text-slate-400 hover:text-primary" title="Edit">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>
                                    <form action="{{ route('admin.providers.destroy', $provider) }}" method="POST" onsubmit="return confirm('Delete this provider?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-500" title="Delete">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No providers yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $providers->links() }}</div>
@endsection
