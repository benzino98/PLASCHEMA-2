import Alpine from 'alpinejs';
import './assistant';
import { animate } from 'motion';
import ApexCharts from 'apexcharts';
import { Notyf } from 'notyf';
import Swal from 'sweetalert2';
import { createIcons, icons } from 'lucide';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
import { Grid } from 'gridjs';
import 'gridjs/dist/theme/mermaid.css';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.animate = animate;

window.createRichTextEditor = ({ element, textarea, toolbar }) => {
    const editor = new Editor({
        element,
        extensions: [StarterKit],
        content: textarea.value,
        editorProps: { attributes: { class: 'tiptap-content', role: 'textbox', 'aria-multiline': 'true' } },
        onUpdate: ({ editor: instance }) => { textarea.value = instance.getHTML(); },
    });

    toolbar?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-editor-action]');
        if (!button) return;
        const chain = editor.chain().focus();
        const actions = {
            bold: () => chain.toggleBold().run(), italic: () => chain.toggleItalic().run(),
            strike: () => chain.toggleStrike().run(), h2: () => chain.toggleHeading({ level: 2 }).run(),
            h3: () => chain.toggleHeading({ level: 3 }).run(), bullet: () => chain.toggleBulletList().run(),
            ordered: () => chain.toggleOrderedList().run(), quote: () => chain.toggleBlockquote().run(),
            undo: () => chain.undo().run(), redo: () => chain.redo().run(),
        };
        actions[button.dataset.editorAction]?.();
    });
    return editor;
};

window.createFileUploader = (input) => FilePond.create(input, {
    allowMultiple: false,
    storeAsFile: true,
    credits: false,
    labelIdle: 'Drag & drop a document or <span class="filepond--label-action">browse</span>',
});

window.Grid = Grid;

window.enhanceAdminTables = () => {
    document.querySelectorAll('[data-gridjs-table]').forEach((wrapper) => {
        const table = wrapper.querySelector('table');
        if (!table) return;
        wrapper.style.position = 'relative';
        try {
            new Grid({
                from: table,
                sort: true,
                search: true,
                language: { search: { placeholder: 'Filter…' } },
                className: { table: 'w-full' },
            }).render(wrapper);
        } catch (e) {
            console.warn('Grid.js enhancement failed, native table remains.', e);
        }
    });
};

window.enhanceSelects = () => {
    document.querySelectorAll('[data-tom-select]').forEach((el) => {
        if (!el.tomselect) {
            new TomSelect(el, {
                create: false,
                maxOptions: null,
                controlInput: '<input>',
            });
        }
    });
};

window.refreshIcons = () => createIcons({ icons });

window.notyf = new Notyf({
    duration: 4000,
    position: { x: 'right', y: 'top' },
    types: [
        {
            type: 'success',
            background: '#0B8F4D',
            icon: false,
        },
        {
            type: 'error',
            background: '#dc2626',
            icon: false,
        },
    ],
});

window.Swal = Swal.mixin({
    confirmButtonColor: '#0B8F4D',
    cancelButtonColor: '#64748b',
});

document.addEventListener('DOMContentLoaded', () => {
    window.enhanceAdminTables();
    window.refreshIcons();
    window.enhanceSelects();
});

document.addEventListener('alpine:initialized', () => window.refreshIcons());

Alpine.start();

window.refreshIcons();
