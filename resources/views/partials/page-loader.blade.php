{{-- Page transition loader: branded overlay + top progress bar. Self-contained critical CSS so it paints instantly. --}}
<div id="bv-page-loader" aria-hidden="true">
    <div class="bv-loader__inner">
        <div class="bv-loader__ring">
            <span class="bv-loader__leaf">🌿</span>
        </div>
        <div class="bv-loader__logo">Borneo Venture</div>
        <div class="bv-loader__text">Memuat petualangan…</div>
    </div>
</div>
<div id="bv-progress" aria-hidden="true"></div>

<style>
    #bv-page-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #0b1a12;
        opacity: 1;
        transition: opacity .5s ease;
    }
    #bv-page-loader.is-hidden {
        opacity: 0;
        pointer-events: none;
        visibility: hidden;
    }
    .bv-loader__inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 18px;
    }
    .bv-loader__ring {
        position: relative;
        width: 72px;
        height: 72px;
        border-radius: 50%;
        border: 3px solid rgba(129, 199, 132, .18);
        border-top-color: #81c784;
        animation: bvSpin .9s linear infinite;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bv-loader__leaf {
        font-size: 26px;
        animation: bvPulse 1.4s ease-in-out infinite;
    }
    .bv-loader__logo {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: .5px;
    }
    .bv-loader__text {
        font-family: 'Inter', system-ui, sans-serif;
        font-size: .8rem;
        color: rgba(207, 227, 212, .6);
        letter-spacing: 2px;
        text-transform: uppercase;
        animation: bvBlink 1.6s ease-in-out infinite;
    }
    #bv-progress {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        width: 0;
        z-index: 10000;
        background: linear-gradient(90deg, #2e7d32, #81c784);
        box-shadow: 0 0 10px rgba(129, 199, 132, .7);
        transition: width .4s ease;
    }
    @keyframes bvSpin { to { transform: rotate(360deg); } }
    @keyframes bvPulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.18); } }
    @keyframes bvBlink { 0%,100% { opacity: .4; } 50% { opacity: .9; } }

    @media (prefers-reduced-motion: reduce) {
        .bv-loader__ring,
        .bv-loader__leaf,
        .bv-loader__text { animation: none; }
        #bv-page-loader,
        #bv-progress { transition: opacity .2s ease, width .2s ease; }
    }
</style>

<script>
(function () {
    const loader = document.getElementById('bv-page-loader');
    const bar = document.getElementById('bv-progress');
    if (!loader) return;
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function hide() {
        if (bar) bar.style.width = '100%';
        loader.classList.add('is-hidden');
        if (bar) setTimeout(() => { bar.style.width = '0'; }, 450);
    }

    function show() {
        loader.classList.remove('is-hidden');
        if (bar) bar.style.width = '85%';
    }

    // Reveal page once DOM is ready (don't wait for all images/video)
    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }
    ready(() => setTimeout(hide, reduce ? 0 : 350));
    // Hard fallback so the loader never gets stuck
    setTimeout(hide, 3500);

    // Back/forward (bfcache) — page restored from cache, make sure loader is gone
    window.addEventListener('pageshow', (e) => { if (e.persisted) hide(); });

    // Show loader when navigating to another internal page
    document.addEventListener('click', (e) => {
        const a = e.target.closest('a');
        if (!a) return;

        const href = a.getAttribute('href');
        if (!href) return;

        // New tab, download, or modified click → let the browser handle it
        if (a.target === '_blank' || a.hasAttribute('download')) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;

        // Non-navigations
        if (href.startsWith('#') || href.startsWith('mailto:') ||
            href.startsWith('tel:') || href.startsWith('javascript:')) return;

        let url;
        try { url = new URL(href, location.href); } catch (_) { return; }

        if (url.origin !== location.origin) return;                 // external link
        if (url.pathname === location.pathname && url.hash) return; // same-page anchor (smooth scroll)

        show();
    });

    // Safety net for other full-page navigations (form GET, etc.)
    window.addEventListener('beforeunload', () => { if (!reduce) show(); });
})();
</script>
