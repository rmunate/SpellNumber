import { defineConfig } from 'vitepress'

// Keep asset URLs rooted at the GitHub Pages project path.
const base = '/SpellNumber/'
const siteUrl = `https://rmunate.github.io${base}`
const description = 'Spell out numbers, money amounts, and ordinals in Laravel.'

export default defineConfig({
  title: 'SpellNumber',
  description,
  lang: 'en-US',
  base,
  head: [
    ['link', { rel: 'icon', href: `${base}img/spell-number-mark.svg`, type: 'image/svg+xml' }],
    ['meta', { property: 'og:title', content: 'SpellNumber' }],
    ['meta', { property: 'og:description', content: description }],
    ['meta', { property: 'og:url', content: siteUrl }],
    ['meta', { property: 'og:image', content: `${siteUrl}img/logo-github.png` }],
    ['meta', { property: 'og:type', content: 'website' }],
  ],
  themeConfig: {
    footer: {
      message: `Released under the MIT License. <a href="${base}licenses/titillium-web.txt">Titillium Web font license</a>`,
      copyright: 'Copyright © Raul Mauricio Uñate',
    },
    editLink: {
      pattern: 'https://github.com/rmunate/SpellNumber/edit/main/docs/:path',
    },
    logo: { src: '/img/spell-number-mark.svg', alt: '' },
    nav: [
      { text: 'Quickstart', link: '/getting-started/quickstart', activeMatch: '^/getting-started/(introduction|installation|quickstart)' },
      { text: 'API reference', link: '/reference/api', activeMatch: '^/reference/' },
      { text: 'v5.0.0', link: '/getting-started/changelog' },
    ],
    sidebar: [
      {
        text: 'Get started',
        items: [
          { text: 'Introduction', link: '/getting-started/introduction' },
          { text: 'Installation', link: '/getting-started/installation' },
          { text: 'Quickstart', link: '/getting-started/quickstart' },
        ],
      },
      {
        text: 'Conversions',
        items: [
          { text: 'Numbers to letters', link: '/usage/numbers-to-letters' },
          { text: 'Numbers to money', link: '/usage/numbers-to-money' },
          { text: 'Numbers to ordinals', link: '/usage/numbers-to-ordinal' },
          { text: 'Languages and locales', link: '/usage/languages-available' },
        ],
      },
      {
        text: 'Customize',
        items: [
          { text: 'Publish configuration', link: '/getting-started/publish-vendor' },
          { text: 'Configuration', link: '/usage/config-file' },
          { text: 'Output callbacks', link: '/usage/config-custom-callback' },
          { text: 'Macros', link: '/usage/macroable' },
        ],
      },
      {
        text: 'Reference',
        items: [
          { text: 'API reference', link: '/reference/api' },
          { text: 'Troubleshooting', link: '/reference/troubleshooting' },
        ],
      },
      {
        text: 'Project',
        collapsed: true,
        items: [
          { text: 'Release notes', link: '/getting-started/changelog' },
          { text: 'Contributing', link: '/contribute/contribution' },
          { text: 'Report a bug', link: '/contribute/report-bugs' },
        ],
      },
    ],
    socialLinks: [
      { icon: 'github', link: 'https://github.com/rmunate/SpellNumber' },
    ],
    search: { provider: 'local' },
  },
})
