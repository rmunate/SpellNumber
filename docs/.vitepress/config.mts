import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel SpellNumber",
    description: "Easily convert numbers to words in Laravel Framework.",
    lastUpdated: true,
    base: '/SpellNumber',
    themeConfig: {
        logo: 'laravel_black.svg',
        nav: [
            {text: 'v4.0.0 (2023/10/19)', link: '/'},
        ],

        sidebar: [
            {
                text: 'Getting Started',
                collapsed: false,
                items: [
                    {text: 'Introduction', link: '/'},
                    {text: 'Installation', link: '/getting-started/installation'},
                    {text: 'Publish Vendor', link: '/getting-started/publish-vendor'},
                ]
            }, {
                text: 'Usage',
                collapsed: false,
                items: [
                    {text: 'Languages Available', link: '/usage/languages-available.md'},
                    {text: 'Numbers To Letters', link: '/usage/numbers-to-letters'},
                    {text: 'Numbers To Money', link: '/usage/numbers-to-money'},
                    {text: 'Config File', link: '/usage/config-file'},
                    {text: 'Config Custom Callback', link: '/usage/config-custom-callback'},
                ]
            }, {
                text: 'Contribute',
                collapsed: false,
                items: [
                    {text: 'Bug Report', link: 'contribute/report-bugs'},
                    {text: 'Contribution', link: 'contribute/contribution'}
                ]
            }
        ],

        socialLinks: [
            {icon: 'github', link: 'https://github.com/rmunate/SpellNumber'}
        ],
        search: {
            provider: 'local'
        }
    },
    head: [
        [
            'script',
            {async: '', src: 'https://www.googletagmanager.com/gtag/js?id=G-ZNPSG44PGL'}
        ],
        [
            'script',
            {},
            `window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-ZNPSG44PGL');`
        ]
    ]
})
