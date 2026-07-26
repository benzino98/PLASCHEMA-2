@if($errors->any())<div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"><p class="font-semibold">Please correct the form errors.</p><ul class="mt-2 list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
    <div class="space-y-6">
        <section class="card"><h2 class="text-lg font-semibold text-slate-900">Content</h2><div class="mt-5 space-y-5">
            <div><label for="title" class="block text-sm font-semibold text-slate-700">Title</label><input id="title" name="title" value="{{ old('title',$article->title) }}" required class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
            <div><label for="excerpt" class="block text-sm font-semibold text-slate-700">Excerpt</label><textarea id="excerpt" name="excerpt" rows="3" maxlength="1000" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm">{{ old('excerpt',$article->excerpt) }}</textarea></div>
            <div><label for="body" class="block text-sm font-semibold text-slate-700">Body</label></div>
            <div class="overflow-hidden rounded-xl border border-slate-300" x-data="tiptapComponent()">
                <div class="editor-toolbar" x-ref="toolbar">
                    <button type="button" data-editor-action="h2" title="Heading 2">H2</button>
                    <button type="button" data-editor-action="h3" title="Heading 3">H3</button>
                    <span class="w-px bg-slate-300"></span>
                    <button type="button" data-editor-action="bold" title="Bold"><strong>B</strong></button>
                    <button type="button" data-editor-action="italic" title="Italic"><em>I</em></button>
                    <button type="button" data-editor-action="strike" title="Strikethrough"><s>S</s></button>
                    <span class="w-px bg-slate-300"></span>
                    <button type="button" data-editor-action="bullet" title="Bulleted list">• List</button>
                    <button type="button" data-editor-action="ordered" title="Ordered list">1. List</button>
                    <button type="button" data-editor-action="quote" title="Quote">❝ Quote</button>
                    <span class="w-px bg-slate-300"></span>
                    <button type="button" data-editor-action="undo" title="Undo">↩ Undo</button>
                    <button type="button" data-editor-action="redo" title="Redo">↪ Redo</button>
                </div>
                <div x-ref="editorElement" class="tiptap-content" role="textbox" aria-multiline="true"></div>
                <textarea name="body" id="body" x-ref="textarea" required rows="12" class="sr-only">{{ old('body', $article->body) }}</textarea>
            </div>
        </div></section>
    </div>
    <aside class="card h-fit lg:sticky lg:top-6 space-y-5">
        <div><h2 class="text-lg font-semibold text-slate-900">Settings</h2><p class="mt-1 text-sm text-slate-500">Category, image, and publication controls.</p></div>
        <div><label for="category" class="block text-sm font-semibold text-slate-700">Category</label><select id="category" name="category" required class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm">@foreach($categories as $key=>$label)<option value="{{ $key }}" @selected(old('category',$article->category)===$key)>{{ $label }}</option>@endforeach</select></div>
        <div><label for="featured_image" class="block text-sm font-semibold text-slate-700">Featured image</label><input id="featured_image" name="featured_image" type="file" accept="image/png,image/jpeg,image/webp" class="mt-2 w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-primary">@if($article->featured_image)<p class="mt-2 text-xs text-slate-500">Current: <a href="{{ asset('storage/'.$article->featured_image) }}" target="_blank" rel="noopener" class="underline">{{ $article->featured_image }}</a></p>@endif</div>
        <div><label for="published_at" class="block text-sm font-semibold text-slate-700">Publish date</label><input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', optional($article->published_at ?? new DateTime)->format('Y-m-d\TH:i')) }}" class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-3 text-sm"></div>
        <label class="flex items-start gap-3"><input name="is_published" type="checkbox" value="1" @checked(old('is_published',$article->exists ? $article->is_published : true)) class="mt-1 h-4 w-4 accent-primary"><span><strong class="block text-sm text-slate-900">Published</strong><span class="text-xs text-slate-500">Visible when publish date is reached.</span></span></label>
        <div class="flex gap-3 border-t border-slate-200 pt-5"><a href="{{ route('admin.news.index') }}" class="btn-outline flex-1 justify-center">Cancel</a><button type="submit" class="btn-primary flex-1 justify-center"><i data-lucide="save" class="h-4 w-4"></i>Save</button></div>
    </aside>
</div>
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('tiptapComponent', () => ({
        editor: null,
        init() {
            this.$nextTick(() => {
                if (typeof window.createRichTextEditor !== 'function') return;
                this.editor = window.createRichTextEditor({
                    element: this.$refs.editorElement,
                    textarea: this.$refs.textarea,
                    toolbar: this.$refs.toolbar,
                });
            });
        },
        destroy() { this.editor?.destroy(); },
    }));
});
</script>
@endpush
