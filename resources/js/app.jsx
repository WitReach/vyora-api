import './bootstrap';
import '../css/app.css';

import { createRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import Layout from './Components/Layout';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Vyora';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.tsx', { eager: true });
        let page = pages[`./Pages/${name}.tsx`];
        if (!page) {
            // fallback to jsx if needed
            const pagesJsx = import.meta.glob('./Pages/**/*.jsx', { eager: true });
            page = pagesJsx[`./Pages/${name}.jsx`];
        }
        page.default.layout = page.default.layout || ((page) => <Layout>{page}</Layout>);
        return page;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },
    progress: {
        color: '#4B5563',
    },
});
