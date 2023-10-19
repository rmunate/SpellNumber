import { defineConfig } from 'vitepress'

// Función para obtener la versión de forma asincrónica
async function apiGithub() {
    const url = "https://repo.packagist.org/p2/rmunate/spell-number.json";
    const response = await fetch(url);
    const data = await response.json();
    const currentVersion = data.packages["rmunate/spell-number"][0].version;
    const currentVersionDate = data.packages["rmunate/spell-number"][0].time.split("T")[0];
    return {
        version: currentVersion,
        date: currentVersionDate,
    };
}

// Montar la configuracion de la documentacion.
export default async () => {

    const api = await apiGithub();
  
    return defineConfig({
        title: "Laravel SpellNumber",
        description: "Easily convert numbers to words in Laravel Framework.",
        lastUpdated: true,
        base: '/SpellNumber',
        themeConfig: {
            logo: './public/spell-number.svg',
            nav: [
                {text: `${api.version} (${api.date})`, link: '/'},
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
                        {text: 'Languages Available', link: '/usage/languages-lvailable.md'},
                        {text: 'Numbers To Letters', link: '/usage/numbers-to-letters'},
                        {text: 'Numbers To Money', link: '/usage/numbers-to-money'},
                        {text: 'Config File', link: '/usage/config-file'},
                        {text: 'Config Custom Callback', link: '/usage/config-custom-callback'},
                    ]
                }, {
                    text: 'Contribute',
                    collapsed: true,
                    items: [
                        {text: 'Report Bugs', link: 'contribute/report-bugs'},
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
    });
};
