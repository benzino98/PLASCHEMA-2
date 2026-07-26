<div class="card">
    <div class="space-y-6">
        {{-- Category --}}
        <div>
            <label for="faq_category_id" class="block text-sm font-semibold text-slate-700 mb-2">
                Category <span class="text-red-600">*</span>
            </label>
            <select
                name="faq_category_id"
                id="faq_category_id"
                required
                class="block w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 @error('faq_category_id') border-red-500 @enderror"
            >
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        {{ old('faq_category_id', $faq->faq_category_id ?? '') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('faq_category_id')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Question --}}
        <div>
            <label for="question" class="block text-sm font-semibold text-slate-700 mb-2">
                Question <span class="text-red-600">*</span>
            </label>
            <input
                type="text"
                name="question"
                id="question"
                value="{{ old('question', $faq->question ?? '') }}"
                required
                maxlength="500"
                placeholder="e.g., How do I enroll in PLASCHEMA?"
                class="block w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 @error('question') border-red-500 @enderror"
            >
            @error('question')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Answer --}}
        <div>
            <label for="answer" class="block text-sm font-semibold text-slate-700 mb-2">
                Answer <span class="text-red-600">*</span>
            </label>
            <textarea
                name="answer"
                id="answer"
                rows="8"
                required
                placeholder="Provide a clear and helpful answer..."
                class="block w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 @error('answer') border-red-500 @enderror"
            >{{ old('answer', $faq->answer ?? '') }}</textarea>
            @error('answer')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-slate-500">Plain text only. Line breaks will be preserved.</p>
        </div>

        {{-- Sort Order --}}
        <div>
            <label for="sort_order" class="block text-sm font-semibold text-slate-700 mb-2">
                Sort Order
            </label>
            <input
                type="number"
                name="sort_order"
                id="sort_order"
                value="{{ old('sort_order', $faq->sort_order ?? 999) }}"
                min="0"
                class="block w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 @error('sort_order') border-red-500 @enderror"
            >
            @error('sort_order')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-slate-500">Lower numbers appear first. Default is 999.</p>
        </div>

        {{-- Published --}}
        <div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    {{ old('is_published', $faq->is_published ?? true) ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-slate-300 text-primary focus:ring-primary accent-primary"
                >
                <div>
                    <p class="text-sm font-semibold text-slate-900">Publish this FAQ</p>
                    <p class="text-xs text-slate-500">Make this FAQ visible on the public website</p>
                </div>
            </label>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between border-t border-slate-200 pt-6">
            <a href="{{ route('admin.faqs.index') }}" class="btn-outline">
                <i data-lucide="x" class="h-4 w-4"></i>
                Cancel
            </a>
            <button type="submit" class="btn-primary">
                <i data-lucide="save" class="h-4 w-4"></i>
                {{ isset($faq) ? 'Update FAQ' : 'Create FAQ' }}
            </button>
        </div>
    </div>
</div>
