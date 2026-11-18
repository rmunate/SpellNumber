<script setup lang="ts">
import { computed, ref } from 'vue'
import { withBase } from 'vitepress'

const examples = {
  letters: {
    label: 'Letters',
    factory: 'integer(125)',
    locale: 'en',
    steps: [],
    method: 'toLetters()',
    result: 'one hundred twenty-five',
  },
  money: {
    label: 'Money',
    factory: "float('1.01')",
    locale: 'en',
    steps: ["currency('dollars')", "fraction('cents')"],
    method: 'toMoney()',
    result: 'one dollar and one cent',
  },
  ordinals: {
    label: 'Ordinals',
    factory: 'integer(2)',
    locale: 'es',
    steps: [],
    method: "toOrdinal('female')",
    result: 'segunda',
  },
}

const selected = ref<keyof typeof examples>('letters')
const example = computed(() => examples[selected.value])

const guides = [
  {
    number: '01',
    label: 'Setup',
    title: 'Get a working result',
    details: 'Check PHP Intl, install with Composer, and run your first conversions in a Laravel route.',
    link: '/getting-started/quickstart.html',
  },
  {
    number: '02',
    label: 'Usage',
    title: 'Choose a conversion',
    details: 'Pick the right input type. See how decimals, currency names, and ordinal rules are handled.',
    link: '/usage/numbers-to-letters.html',
  },
  {
    number: '03',
    label: 'Configuration',
    title: 'Make it fit your app',
    details: 'Set locale and currency defaults, write a cache-safe callback, and verify your configuration.',
    link: '/usage/config-file.html',
  },
]
</script>

<template>
  <main class="sn-home">
    <section class="sn-hero" aria-labelledby="sn-hero-title">
      <div class="sn-intro">
        <p class="sn-eyebrow"><span aria-hidden="true"></span> PHP Intl for Laravel</p>
        <h1 id="sn-hero-title">Turn numbers <span>into words.</span></h1>
        <p class="sn-summary">
          Spell out numbers, money amounts, and ordinals in your Laravel app.
          Follow the quickstart or go straight to the method you need.
        </p>
        <div class="sn-actions">
          <a class="sn-button sn-button--primary" :href="withBase('/getting-started/quickstart.html')">
            Get started <span aria-hidden="true">&rarr;</span>
          </a>
          <a class="sn-button sn-button--secondary" :href="withBase('/reference/api.html')">Browse the API</a>
        </div>
        <ul class="sn-facts" aria-label="Package compatibility">
          <li>Laravel 8&ndash;13</li>
          <li>11 language presets</li>
          <li>MIT licensed</li>
        </ul>
      </div>

      <figure class="sn-code-card">
        <figcaption class="sn-code-caption">
          <span class="sn-dots" aria-hidden="true"><i></i><i></i><i></i></span>
          Conversion examples <span class="sn-code-tag">PHP</span>
        </figcaption>
        <div class="sn-examples" role="group" aria-label="Select an example">
          <button
            v-for="(sample, key) in examples"
            :key="key"
            type="button"
            :aria-pressed="selected === key"
            @click="selected = key"
          >
            {{ sample.label }}
          </button>
        </div>
        <pre class="sn-code" tabindex="0" aria-label="PHP example"><code><span class="sn-code-keyword">use</span> Rmunate\Utilities\SpellNumber;<br><br><span class="sn-code-class">SpellNumber</span>::<span class="sn-code-call">{{ example.factory }}</span><br>    -&gt;locale(<span class="sn-code-string">'{{ example.locale }}'</span>)<template v-for="step in example.steps" :key="step"><br>    -&gt;<span class="sn-code-call">{{ step }}</span></template><br>    -&gt;<span class="sn-code-call">{{ example.method }}</span>;</code></pre>
        <output class="sn-result" aria-live="polite">
          <span class="sn-result-label">Output <code>{{ example.locale }}</code></span>
          <span class="sn-result-words" :lang="example.locale">{{ example.result }}</span>
        </output>
      </figure>
    </section>

    <section class="sn-guide" aria-labelledby="sn-guide-title">
      <p class="sn-section-label">Developer guide</p>
      <h2 id="sn-guide-title">From installation to production</h2>
      <p>Every guide shows what to run, where to put the code, and what to expect.</p>
      <div class="sn-guide-grid">
        <a v-for="guide in guides" :key="guide.link" class="sn-guide-card" :href="withBase(guide.link)">
          <span class="sn-card-meta"><span>{{ guide.number }}</span> {{ guide.label }}</span>
          <span class="sn-card-title">{{ guide.title }} <span aria-hidden="true">&rarr;</span></span>
          <span class="sn-card-description">{{ guide.details }}</span>
        </a>
      </div>
      <div class="sn-guide-links">
        <a :href="withBase('/usage/languages-available.html')">Explore supported languages <span aria-hidden="true">&rarr;</span></a>
        <a :href="withBase('/reference/troubleshooting.html')">Troubleshoot a result <span aria-hidden="true">&rarr;</span></a>
        <a :href="withBase('/getting-started/changelog.html')">See what changed in 5.0 <span aria-hidden="true">&rarr;</span></a>
      </div>
    </section>
  </main>
</template>

<style scoped>
.sn-home {
  max-width: 1264px;
  margin: 0 auto;
  padding: clamp(1rem, 3.5vw, 3rem) clamp(1rem, 4vw, 3rem) 0;
}

.sn-hero {
  --sn-hero-muted: #e1d8f6;
  --sn-mint: #68efcb;
  display: grid;
  grid-template-columns: minmax(0, 1fr) minmax(0, 0.95fr);
  align-items: center;
  gap: clamp(1.75rem, 4.5vw, 4rem);
  padding: clamp(1.25rem, 5vw, 4.25rem);
  border: 1px solid #594389;
  border-radius: 2rem;
  background:
    radial-gradient(ellipse at 93% -16%, #6050c5 0%, transparent 57%),
    radial-gradient(ellipse at -8% 108%, #552187 0%, transparent 67%),
    linear-gradient(125deg, #21143b, #151631 72%);
  box-shadow: 0 22px 65px #38156b35;
  color: #fff;
}

.sn-intro {
  min-width: 0;
}

.sn-eyebrow,
.sn-section-label,
.sn-card-meta,
.sn-result-label,
.sn-code-tag {
  font-size: 0.76rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.sn-eyebrow {
  display: flex;
  align-items: center;
  gap: 0.55rem;
  color: var(--sn-mint);
}

.sn-eyebrow span,
.sn-dots i {
  width: 0.48rem;
  height: 0.48rem;
  border-radius: 50%;
  background-color: currentColor;
}

.sn-hero h1 {
  margin: 0.8rem 0 1rem;
  font-size: clamp(2.65rem, 5.3vw, 5.15rem);
  font-weight: 700;
  letter-spacing: -0.062em;
  line-height: 0.98;
}

.sn-hero h1 span {
  display: block;
  color: #d1b4ff;
}

.sn-summary {
  max-width: 35ch;
  color: var(--sn-hero-muted);
  font-size: clamp(1.05rem, 1.8vw, 1.28rem);
  line-height: 1.54;
}

.sn-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.7rem;
  margin-block: 1.55rem;
}

.sn-button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.55rem;
  min-height: 2.8rem;
  padding: 0.55rem 1rem;
  border: 1px solid transparent;
  border-radius: 0.75rem;
  font-weight: 700;
}

.sn-button--primary {
  background: var(--sn-mint);
  color: #08251d;
}

.sn-button--primary:hover {
  background: #a4ffe9;
}

.sn-button--secondary {
  border-color: #9c87c2;
  background: #1a122f6e;
  color: #fff;
}

.sn-button--secondary:hover {
  background: #3b2b60;
}

.sn-facts {
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem 1rem;
  color: var(--sn-hero-muted);
  font-size: 0.88rem;
  font-weight: 600;
}

.sn-facts li::before {
  margin-inline-end: 0.38rem;
  color: var(--sn-mint);
  content: '\2022';
}

.sn-code-card {
  min-width: 0;
  margin: 0;
  border: 1px solid #8470af;
  border-radius: 1.25rem;
  background: #151027;
  box-shadow: 0 16px 42px #0f082d7a;
}

.sn-code-caption {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 0.55rem 0.8rem;
  padding: 0.7rem 0.95rem;
  border-bottom: 1px solid #3c2e57;
  color: var(--sn-hero-muted);
  font-weight: 600;
}

.sn-dots {
  display: flex;
  gap: 0.28rem;
  color: #ab8df5;
}

.sn-dots i:first-child {
  color: #ff87b3;
}

.sn-dots i:last-child {
  color: var(--sn-mint);
}

.sn-code-tag {
  margin-inline-start: auto;
  color: #b7aaff;
}

.sn-examples {
  display: flex;
  flex-wrap: wrap;
  gap: 0.35rem;
  padding: 0.8rem 0.9rem 0;
}

.sn-examples button {
  min-height: 2.4rem;
  padding: 0.25rem 0.65rem;
  border: 1px solid #55436f;
  border-radius: 0.55rem;
  background-color: #231938;
  color: #e0d4f5;
  font-size: 0.9rem;
  font-weight: 700;
}

.sn-examples button:hover {
  border-color: #bda3ff;
}

.sn-examples button[aria-pressed='true'] {
  border-color: #bda3ff;
  background: #3d2c68;
  color: #fff;
}

.sn-hero :is(a, button, pre):focus-visible {
  outline: 2px solid #fff;
  outline-offset: 3px;
}

.sn-code {
  min-height: 10.1rem;
  margin: 0.8rem 0.9rem;
  padding: 0.62rem 0.7rem;
  overflow: auto;
  border-radius: 0.55rem;
  background: #100d20;
  color: #f0eafa;
  font-size: 0.81rem;
  line-height: 1.62;
}

.sn-code-keyword,
.sn-code-class {
  color: #c5a6ff;
}

.sn-code-call,
.sn-code-string {
  color: var(--sn-mint);
}

.sn-result {
  display: block;
  margin: 0 0.9rem 0.9rem;
  padding: 0.65rem 0.78rem;
  border: 1px solid #377367;
  border-radius: 0.65rem;
  background: #162e36;
}

.sn-result-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #bce3d8;
}

.sn-result-label code {
  padding-inline: 0.25rem;
  border: 1px solid #518779;
  border-radius: 0.25rem;
  text-transform: none;
}

.sn-result-words {
  display: block;
  color: var(--sn-mint);
  font-size: 1.24rem;
  font-weight: 700;
}

.sn-guide {
  padding: clamp(2.25rem, 5vw, 4rem) 0 0;
}

.sn-section-label {
  color: var(--vp-c-brand-1);
}

.sn-guide h2 {
  margin: 0.3rem 0 0.55rem;
  font-size: var(--sn-heading-size);
  font-weight: 700;
  letter-spacing: -0.038em;
  line-height: 1.1;
}

.sn-guide > p:not(.sn-section-label) {
  color: var(--vp-c-text-2);
  font-size: 1.12rem;
}

.sn-guide-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1rem;
  margin-top: 1.4rem;
}

.sn-guide-card {
  display: flex;
  flex-direction: column;
  gap: 0.55rem;
  padding: 1.2rem;
  border: 1px solid var(--vp-c-divider);
  border-radius: 1.05rem;
  background: var(--vp-c-bg-elv);
  box-shadow: 0 6px 20px #2c125a0e;
}

.sn-guide-card:hover,
.sn-guide-card:focus-visible {
  border-color: var(--vp-c-brand-1);
  background: var(--vp-c-bg-soft);
}

.sn-card-meta {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: var(--vp-c-brand-1);
}

.sn-card-meta span {
  padding: 0.13rem 0.35rem;
  border-radius: 0.4rem;
  background: var(--vp-c-brand-soft);
}

.sn-card-title {
  display: flex;
  justify-content: space-between;
  align-items: baseline;
  gap: 0.5rem;
  font-size: 1.38rem;
  font-weight: 700;
}

.sn-card-title span,
.sn-guide-links a {
  color: var(--vp-c-brand-1);
}

.sn-card-description {
  color: var(--vp-c-text-2);
}

.sn-guide-links {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem 1.25rem;
  margin-top: 1rem;
  font-weight: 600;
}

.sn-guide-links a:hover {
  text-decoration: underline;
}

@media (max-width: 900px) {
  .sn-hero {
    grid-template-columns: minmax(0, 1fr);
    max-width: 680px;
    margin-inline: auto;
  }

  .sn-hero h1 {
    font-size: clamp(2.6rem, 9.5vw, 4.4rem);
  }
}

@media (max-width: 720px) {
  .sn-guide-grid {
    grid-template-columns: minmax(0, 1fr);
  }
}
</style>
