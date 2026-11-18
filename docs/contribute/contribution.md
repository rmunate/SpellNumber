---
title: Contributing
editLink: true
outline: deep
---

<script setup>
import { VPTeamMembers } from 'vitepress/theme-without-fonts'

const members = [
  {
    avatar: 'https://avatars.githubusercontent.com/u/91748598?v=4',
    name: 'Raúl Mauricio Uñate Castro',
    title: 'Creator | Bogotá DC - Colombia',
    links: [
      { icon: 'github', link: 'https://github.com/rmunate'},
      { icon: 'linkedin', link: 'https://www.linkedin.com/in/raul-mauricio-unate-castro/' },
      { icon: 'facebook', link: 'https://www.facebook.com/people/Code-Maestro/100093438305767/' },
      { icon: 'instagram', link: 'https://www.instagram.com/code.maestro/' },
      { icon: 'twitter', link: 'https://twitter.com/rmunate' },
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/56381478?v=4',
    name: 'Siros Fakhri',
    title: 'Developer | Iran/Tabriz',
    links: [
      { icon: 'github', link: 'https://github.com/sirosfakhri'},
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/18355852?v=4',
    name: 'Er. Ashok Devatwal',
    title: 'Developer | Alwar-Rajasthan',
    links: [
      { icon: 'github', link: 'https://github.com/ashokdevatwal'},
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/12556170?v=4',
    name: 'Olsza',
    title: 'Developer | Warszawa',
    links: [
      { icon: 'github', link: 'https://github.com/olsza'},
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/1346373?v=4',
    name: 'Jens Twesmann',
    title: 'Developer | Soest, Germany',
    links: [
      { icon: 'github', link: 'https://github.com/jetwes'},
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/51100789?v=4',
    name: 'John Alejandro Diaz Pinilla',
    title: 'Developer | Bogotá DC - Colombia',
    links: [
      { icon: 'github', link: 'https://github.com/alejandrodiazpinilla'},
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/10488154?v=4',
    name: 'Gabriel Rausch',
    title: 'Developer | Petrolina - PE, Brasil',
    links: [
      { icon: 'github', link: 'https://github.com/gdsrmygdsrjr'},
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/7442695?v=4',
    name: 'Frank Sepulveda',
    title: 'Developer | La Paz MX',
    links: [
      { icon: 'github', link: 'https://github.com/socieboy'},
    ]
  },{
    avatar: 'https://avatars.githubusercontent.com/u/56961917?v=4',
    name: 'Ngô Quốc Đạt',
    title: 'Developer | Ho Chi Minh, Vietnam',
    links: [
      { icon: 'github', link: 'https://github.com/datlechin'},
    ]
  }
]
</script>

# Contributing

## Local checks

Use PHP 8.2+ with Intl and mbstring, Composer 2, and Node.js 24 to work on the package:

```bash
composer update
composer test
npm ci
npm run docs:build
```

To test against a particular framework release, use `composer update --with "laravel/framework:^13.0"` (requires PHP 8.3+), or use `^12.0` instead. Include focused regression tests in pull requests that change the conversion behavior.

Use the VitePress development server only for local preview. The published documentation is a static build and does not run that server.

## GitHub Pages and releases

1. In GitHub, set **Settings → Pages → Build and deployment → Source** to **GitHub Actions**. The production environment is `github-pages`.
2. The [CI and GitHub Pages workflow](https://github.com/rmunate/SpellNumber/actions/workflows/deploy.yml) runs the PHP suite and builds the site on pull requests. A push to `main` or a manual run on `main` deploys the site only after both checks pass.
3. After the checks pass on the release commit, create and push the `v5.0.0` Git tag and publish the GitHub release. The Composer release version comes from the tag, not a hardcoded version in `composer.json`. Verify the version on [Packagist](https://packagist.org/packages/rmunate/spell-number).

## Contributors

<VPTeamMembers size="small" :members="members" />

## License
The project is released under the [MIT License](https://github.com/rmunate/SpellNumber/blob/main/LICENSE.md).