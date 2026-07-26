@if($assistantKnowledge)
<div
    id="plaschema-assistant"
    class="assistant-root"
    x-data="assistant(@js($assistantKnowledge))"
    @keydown.escape.window="if (open) close()"
>
    <button
        id="assistant-launcher"
        x-ref="trigger"
        type="button"
        class="assistant-launcher"
        @click="toggle()"
        :aria-expanded="open"
        aria-controls="assistant-panel"
        aria-label="Open PLASCHEMA assistant"
    >
        <span class="assistant-launcher-pulse" aria-hidden="true"></span>
        <i data-lucide="message-circle" class="h-6 w-6" x-show="!open"></i>
        <i data-lucide="x" class="h-6 w-6" x-show="open" x-cloak></i>
        <span class="hidden text-sm font-bold sm:inline">Ask PLASCHEMA</span>
    </button>

    <section
        id="assistant-panel"
        class="assistant-panel"
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-95"
        aria-label="PLASCHEMA digital assistant"
    >
        <header class="assistant-header">
            <div class="flex items-center gap-3">
                <div class="assistant-avatar"><i data-lucide="sparkles" class="h-5 w-5"></i></div>
                <div><h2 class="text-sm font-bold text-white">PLASCHEMA Assistant</h2><p class="flex items-center gap-1.5 text-xs text-emerald-100"><span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>Automated citizen help</p></div>
            </div>
            <button id="assistant-close" type="button" class="rounded-lg p-2 text-white/70 transition hover:bg-white/10 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white" @click="close()" aria-label="Close assistant"><i data-lucide="x" class="h-5 w-5"></i></button>
        </header>

        <div class="assistant-privacy"><i data-lucide="shield-check" class="h-3.5 w-3.5 shrink-0"></i><span>Scripted help only. Do not share personal or payment details.</span></div>

        <div
            id="assistant-messages"
            class="assistant-messages"
            role="log"
            aria-live="polite"
            aria-relevant="additions"
            x-ref="messages"
        >
            <template x-for="(message, index) in messages" :key="index">
                <article class="assistant-message" :class="message.role === 'user' ? 'assistant-message-user' : 'assistant-message-bot'">
                    <div class="assistant-message-avatar" x-show="message.role === 'bot'"><i data-lucide="sparkles" class="h-3.5 w-3.5"></i></div>
                    <div class="assistant-bubble" x-html="render(message)"></div>
                </article>
            </template>

            <div class="assistant-suggestions" x-show="messages.length <= 1">
                <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Popular questions</p>
                <button type="button" @click="suggest('How do I enroll?'); send()"><i data-lucide="user-plus"></i>How do I enroll?</button>
                <button type="button" @click="suggest('Find a hospital near me'); send()"><i data-lucide="map-pin"></i>Find a hospital</button>
                <button type="button" @click="suggest('Explain the health plans'); send()"><i data-lucide="heart-pulse"></i>Explain health plans</button>
                <button type="button" @click="suggest('Verify my membership'); send()"><i data-lucide="shield-check"></i>Verify membership</button>
            </div>
        </div>

        <form class="assistant-input-wrap" @submit.prevent="send()">
            <label for="assistant-input" class="sr-only">Ask PLASCHEMA a question</label>
            <input id="assistant-input" x-ref="input" x-model="input" type="text" maxlength="300" placeholder="Ask about enrollment, plans…" autocomplete="off" class="assistant-input">
            <button id="assistant-send" type="submit" class="assistant-send" :disabled="!input.trim()" aria-label="Send question"><i data-lucide="send" class="h-4 w-4"></i></button>
        </form>
        <p class="assistant-footer-note">For emergencies, call the official emergency numbers listed below.</p>
    </section>
</div>
@endif
