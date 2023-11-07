import {defineConfig} from 'vitepress'

export default defineConfig({
    title: "Laravel SpellNumber",
    description: "Easily convert numbers to words in Laravel Framework.",
    lang: 'en-US',
    lastUpdated: true,
    base: '/SpellNumber',
    themeConfig: {
        logo: 'logo.png',
        nav: [
            {text: 'v4.1.1 (2023/11/07)', link: '/'},
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
                    {text: 'Numbers To Ordinal', link: '/usage/numbers-to-ordinal'},
                    {text: 'Config File', link: '/usage/config-file'},
                    {text: 'Config Custom Callback', link: '/usage/config-custom-callback'},
                    {text: 'Macroable', link: '/usage/macroable'},
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
        ['link', {
                rel: 'icon',
                href: '/SpellNumber/logo.png',
                type: 'image/png'
            }
        ],
        ['meta', {
                property: 'og:image',
                content: '/SpellNumber/logo-github.png' 
            }
        ],
        ['meta', {
                property: 'og:image:secure_url',
                content: '/SpellNumber/logo-github.png'
            }
        ],
        ['meta', {
                property: 'og:image:width',
                content: '600'
            }
        ],
        ['meta', {
                property: 'og:image:height',
                content: '400'
            }
        ],
        ['meta', {
                property: 'og:title',
                content: 'SpellNumber'
            }
        ],
        ['meta', {
                property: 'og:description',
                content: 'Easily convert numbers to words in Laravel Framework.'
            }
        ],
        ['meta', {
                property: 'og:url',
                content: 'https://rmunate.github.io/SpellNumber/'
            }
        ],
        ['meta', {
                property: 'og:type',
                content: 'website'
            }
        ],
    ],
})
