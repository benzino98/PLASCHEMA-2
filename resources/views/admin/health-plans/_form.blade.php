@php
    $benefitRows = old('benefits', collect($benefits)->map(fn($b) => ['id'=>$b->id,'benefit_key'=>$b->benefit_key,'benefit_label'=>$b->benefit_label,'is_included'=>$b->is_included])->values()->all());
@endphp
@if($errors->any())<div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"><p class="font-semibold">Please correct the form errors.</p><ul class="mt-2 list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
    <div class="space-y-6">
        <section class="card"><h2 class="text-lg font-semibold text-slate-900">Plan details</h2><div class="mt-5 grid gap-5 md:grid-cols-2">
            <div><label for="name" class="block text-sm font-semibold text-slate-700">Plan name</label><input id="name" name="name" value="{{ old('name',$plan->name) }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
            <div><label for="sector" class="block text-sm font-semibold text-slate-700">Sector</label><input id="sector" name="sector" value="{{ old('sector',$plan->sector) }}" required placeholder="Formal / Informal" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
            <div class="md:col-span-2"><label for="description" class="block text-sm font-semibold text-slate-700">Description</label><textarea id="description" name="description" rows="5" required class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm">{{ old('description',$plan->description) }}</textarea></div>
            <div><label for="price_amount" class="block text-sm font-semibold text-slate-700">Price amount (₦)</label><input id="price_amount" name="price_amount" type="number" min="0" step="0.01" value="{{ old('price_amount',$plan->price_amount) }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
            <div><label for="price_label" class="block text-sm font-semibold text-slate-700">Price label</label><input id="price_label" name="price_label" value="{{ old('price_label',$plan->price_label) }}" required placeholder="per person / year" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
        </div></section>
        <section class="card" x-data='{ items: @json(array_values($benefitRows ?: [['id'=>null,'benefit_key'=>'','benefit_label'=>'','is_included'=>true]])) }'>
            <div class="flex items-center justify-between gap-4"><div><h2 class="text-lg font-semibold text-slate-900">Benefits</h2><p class="mt-1 text-sm text-slate-500">Define each covered or excluded service.</p></div><button type="button" class="btn-outline px-4 py-2" @click="items.push({id:null,benefit_key:'',benefit_label:'',is_included:true})"><i data-lucide="plus" class="h-4 w-4"></i>Add benefit</button></div>
            <div class="mt-5 space-y-4"><template x-for="(item,index) in items" :key="index"><div class="grid gap-3 rounded-xl border border-slate-200 p-4 md:grid-cols-[12rem_1fr_auto]">
                <input type="hidden" :name="`benefits[${index}][id]`" x-model="item.id">
                <input :name="`benefits[${index}][benefit_key]`" x-model="item.benefit_key" placeholder="outpatient_care" required class="rounded-lg border border-slate-300 px-4 py-3 text-sm" aria-label="Benefit key">
                <input :name="`benefits[${index}][benefit_label]`" x-model="item.benefit_label" placeholder="Outpatient consultations" required class="rounded-lg border border-slate-300 px-4 py-3 text-sm" aria-label="Benefit label">
                <div class="flex items-center gap-2"><label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" :name="`benefits[${index}][is_included]`" value="1" x-model="item.is_included" class="h-4 w-4 accent-primary">Included</label><button type="button" @click="items.splice(index,1)" class="rounded-lg border border-red-200 p-3 text-red-600" aria-label="Remove benefit"><i data-lucide="trash-2" class="h-4 w-4"></i></button></div>
            </div></template></div>
        </section>
    </div>
    <aside class="card h-fit lg:sticky lg:top-6"><h2 class="text-lg font-semibold text-slate-900">Publishing</h2><div class="mt-5 space-y-5">
        <div><label for="sort_order" class="block text-sm font-semibold text-slate-700">Sort order</label><input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order',$plan->sort_order ?? 999) }}" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
        <label class="flex items-start gap-3"><input name="is_featured" type="checkbox" value="1" @checked(old('is_featured',$plan->is_featured)) class="mt-1 h-4 w-4 accent-primary"><span><strong class="block text-sm text-slate-900">Featured plan</strong><span class="text-xs text-slate-500">Highlight publicly.</span></span></label>
        <div class="flex gap-3 border-t border-slate-200 pt-5"><a href="{{ route('admin.health-plans.index') }}" class="btn-outline flex-1 justify-center">Cancel</a><button type="submit" class="btn-primary flex-1 justify-center"><i data-lucide="save" class="h-4 w-4"></i>Save</button></div>
    </div></aside>
</div>
