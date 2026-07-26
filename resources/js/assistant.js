document.addEventListener('alpine:init', () => {
    Alpine.data('assistant', (knowledge) => ({
        open: false,
        messages: [],
        input: '',
        busy: false,

        init() {
            this.addBot(this.trans('welcome'));
        },

        toggle() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => this.$refs.input?.focus());
            }
        },

        close() {
            this.open = false;
            this.$nextTick(() => this.$refs.trigger?.focus());
        },

        send() {
            const text = this.input.trim();
            if (!text) return;
            this.input = '';
            this.addUser(text);
            this.busy = true;
            this.$nextTick(() => this.reply(text));
        },

        suggest(query) {
            this.input = query;
            this.$nextTick(() => { if (!this.open) this.toggle(); });
        },

        addUser(text) {
            this.messages.push({ role: 'user', text });
        },

        addBot(text, trusted = true) {
            this.messages.push({ role: 'bot', text, trusted });
        },

        render(message) {
            let html = message.text;
            if (!message.trusted) {
                const div = document.createElement('div');
                div.textContent = html;
                html = div.innerHTML;
            }
            return html
                .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                .replace(/\n/g, '<br>');
        },

        /** Deterministic reply builder */
        reply(text) {
            const lower = text.toLowerCase();
            const t = (s) => s.toLowerCase().replace(/[^a-z0-9\s]/g, '').trim();

            // --- Intent matching ---------------------------------------------------
            const matchEnrollment = /enroll|register|sign.?up|join|coverage|how do i (get|start)/.test(lower);
            const matchVerify = /verif(y|ied|ication)|check.*(member|status|beneficiar)|lookup/.test(lower);
            const matchPayment = /pay|premium|renew|contribution|bill/.test(lower);
            const matchHospital = /hospit(al|als)|doctor|provider|facilit(y|ies)|find.*(clinic|care|medic)/.test(lower);
            const matchPlan = /plan|benefit|cover|package|scheme/.test(lower);
            const matchSupport = /support|help|customer.*care|contact|complaint/.test(lower);
            const matchFaqs = /faq|question|common|frequent/.test(lower);
            const matchGreet = /^(hi|hello|hey|good|morning|afternoon|evening)/i.test(text);

            if (matchEnrollment) {
                this.addBot(this.trans('enrollment'));
                return;
            }
            if (matchVerify) {
                this.addBot(this.trans('verification'));
                return;
            }
            if (matchPayment) {
                this.addBot(this.trans('payment'));
                return;
            }
            if (matchHospital) {
                this.addBot(this.trans('hospital'));
                return;
            }
            if (matchPlan) {
                this.addBot(this.trans('plans'));
                return;
            }
            if (matchSupport) {
                this.addBot(this.trans('support'));
                return;
            }
            if (matchFaqs) {
                this.addBot(this.trans('faqs'));
                return;
            }
            if (matchGreet) {
                this.addBot(this.trans('welcome'));
                return;
            }

            // --- FAQ term scoring -------------------------------------------------
            const tokens = t(text);
            if (tokens.length > 2 && knowledge?.faqs) {
                const words = tokens.split(/\s+/).filter(Boolean);
                const results = [];

                for (const group of knowledge.faqs) {
                    for (const faq of group.questions) {
                        const faqText = t(faq.question) + ' ' + t(faq.answer);
                        const matchCount = words.filter((w) => faqText.includes(w)).length;
                        if (matchCount >= 2) {
                            results.push({ score: matchCount / words.length, question: faq.question, answer: faq.answer });
                        }
                    }
                }

                results.sort((a, b) => b.score - a.score);

                if (results.length > 0 && results[0].score >= 0.4) {
                    const best = results[0];
                    this.addBot(`**${best.question}**\n\n${best.answer}`, false);
                    if (results.length > 1) {
                        this.addBot(this.trans('faq_more'));
                    }
                    return;
                }
            }

            // --- Fallback ---------------------------------------------------------
            this.addBot(this.trans('fallback'));
        },

        trans(key) {
            const svc = knowledge?.services ?? [];
            const enrollmentUrl = svc.find((s) => s.key === 'enrollment')?.url ?? '#';
            const verificationUrl = svc.find((s) => s.key === 'verification')?.url ?? '#';
            const paymentUrl = svc.find((s) => s.key === 'payment')?.url ?? '#';
            const supportUrl = svc.find((s) => s.key === 'support')?.url ?? '#';
            const providerUrl = knowledge?.providerSearchUrl ?? '/providers';
            const plansUrl = knowledge?.plansUrl ?? '/health-plans';
            const faqsUrl = knowledge?.faqsUrl ?? '/faqs';
            const contactUrl = knowledge?.contactUrl ?? '/contact';

            const t = {
                welcome: `👋 Hello! I am the ${knowledge?.siteName ?? 'PLASCHEMA'} assistant. I can help with enrollment, finding hospitals, explaining plans, and common questions. **This is an automated assistant — no personal data is stored or sent.**\n\nTry one of the suggestions below.`,
                enrollment: `**Online Enrollment**\n\nYou can register yourself and your dependants online through our secure enrollment portal:\n<a href="${enrollmentUrl}" target="_blank" rel="noopener noreferrer">${enrollmentUrl}</a>\n\nAfter enrolling, you will receive a confirmation with your membership details. If you need help with the process, please contact support.`,
                verification: `**Membership Verification**\n\nYou can check your PLASCHEMA membership status and verify beneficiary details here:\n<a href="${verificationUrl}" target="_blank" rel="noopener noreferrer">${verificationUrl}</a>\n\nYou will need your membership ID or registered details to proceed.`,
                payment: `**Premium Payment**\n\nPay or renew your health insurance premium securely online:\n<a href="${paymentUrl}" target="_blank" rel="noopener noreferrer">${paymentUrl}</a>\n\nAccepted payment methods are displayed on the portal.`,
                hospital: `**Find a Hospital / Provider**\n\nSearch our network of accredited healthcare providers:\n<a href="${providerUrl}">${providerUrl}</a>\n\nYou can filter by Local Government Area, specialty, and type of service to find a facility near you.`,
                plans: `**Health Insurance Plans**\n\nPLASCHEMA offers several health plans designed for different needs. View all plans with pricing and benefits:\n<a href="${plansUrl}">${plansUrl}</a>` + (knowledge?.plans?.length > 0 ? '\n\n' + knowledge.plans.map((p) => `• **${p.name}** — ${p.description ?? 'Learn more about coverage.'}`).join('\n') : ''),
                support: `**PLASCHEMA Support**\n\nGet help with enrollment, payments, benefits, or any other enquiry:\n<a href="${supportUrl}" target="_blank" rel="noopener noreferrer">${supportUrl}</a>\n\nYou can also reach us via the <a href="${contactUrl}">contact page</a>.`,
                faqs: `**Frequently Asked Questions**\n\nBrowse our full FAQ library:\n<a href="${faqsUrl}">${faqsUrl}</a>\n\nYou can also ask me specific questions about enrollment, plans, providers, and more.`,
                faq_more: `I found several related questions. You can browse all FAQs on the <a href="${faqsUrl}">FAQs page</a>.`,
                fallback: `I am not quite sure I understood that. I can help with:\n\n• **Enrollment** — How to register and get covered\n• **Find a hospital** — Search providers in your area\n• **Health plans** — Compare benefits and pricing\n• **Premium payment** — Renew or pay online\n• **Verify membership** — Check your status\n\nIf you need further assistance, please visit the <a href="${faqsUrl}">FAQs</a> or <a href="${contactUrl}">contact us</a>.`,
            };

            return t[key] ?? '';
        },
    }));
});
