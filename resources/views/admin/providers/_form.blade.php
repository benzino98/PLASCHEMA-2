@php
    $provider = $provider ?? null;
    $isEdit = $provider !== null;
@endphp

<div class="grid gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="name" class="block text-sm font-medium text-slate-700">Hospital Name *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $provider?->name) }}" required
            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="lga" class="block text-sm font-medium text-slate-700">LGA *</label>
        <select name="lga" id="lga" required class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
            <option value="">Select LGA</option>
            @foreach ($lgas as $lga)
                <option value="{{ $lga }}" @selected(old('lga', $provider?->lga) === $lga)>{{ $lga }}</option>
            @endforeach
        </select>
        @error('lga')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="specialty" class="block text-sm font-medium text-slate-700">Specialty</label>
        <select name="specialty" id="specialty" class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
            <option value="">Select specialty</option>
            @foreach ($specialties as $specialty)
                <option value="{{ $specialty }}" @selected(old('specialty', $provider?->specialty) === $specialty)>{{ $specialty }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="ownership" class="block text-sm font-medium text-slate-700">Ownership</label>
        <select name="ownership" id="ownership" class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
            <option value="">Select ownership</option>
            @foreach ($ownershipTypes as $type)
                <option value="{{ $type }}" @selected(old('ownership', $provider?->ownership) === $type)>{{ $type }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="accreditation_status" class="block text-sm font-medium text-slate-700">Accreditation *</label>
        <select name="accreditation_status" id="accreditation_status" required class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
            @foreach (['accredited', 'pending', 'suspended'] as $status)
                <option value="{{ $status }}" @selected(old('accreditation_status', $provider?->accreditation_status ?? 'accredited') === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="address" class="block text-sm font-medium text-slate-700">Address *</label>
        <textarea name="address" id="address" rows="2" required class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">{{ old('address', $provider?->address) }}</textarea>
        @error('address')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $provider?->phone) }}"
            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $provider?->email) }}"
            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
    </div>

    <div class="sm:col-span-2">
        <label for="working_hours" class="block text-sm font-medium text-slate-700">Working Hours</label>
        <textarea name="working_hours" id="working_hours" rows="2" class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">{{ old('working_hours', $provider?->working_hours) }}</textarea>
    </div>

    <div>
        <label for="latitude" class="block text-sm font-medium text-slate-700">Latitude</label>
        <input type="number" step="any" name="latitude" id="latitude" value="{{ old('latitude', $provider?->latitude) }}"
            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
    </div>

    <div>
        <label for="longitude" class="block text-sm font-medium text-slate-700">Longitude</label>
        <input type="number" step="any" name="longitude" id="longitude" value="{{ old('longitude', $provider?->longitude) }}"
            class="mt-1 w-full rounded-[var(--radius-button)] border border-slate-200 px-3 py-2 text-sm">
    </div>

    <div class="sm:col-span-2">
        <p class="text-sm font-medium text-slate-700">Services</p>
        <div class="mt-2 grid grid-cols-2 gap-2 sm:grid-cols-3">
            @foreach ($serviceTypes as $service)
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="services[]" value="{{ $service }}"
                        @checked(in_array($service, old('services', $provider?->services ?? [])))
                        class="rounded border-slate-300 text-primary focus:ring-primary">
                    {{ $service }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="sm:col-span-2">
        <label class="flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $provider?->is_published ?? true))
                class="rounded border-slate-300 text-primary focus:ring-primary">
            Published on public site
        </label>
    </div>
</div>
