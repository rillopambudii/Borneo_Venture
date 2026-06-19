{{-- Interactive forest "fireflies" background — drifts, twinkles, reacts to mouse. Respects reduced-motion. --}}
<canvas id="bv-fireflies"
        class="fixed inset-0 -z-10 pointer-events-none w-full h-full"
        aria-hidden="true"></canvas>

{{-- Subtle animated aurora glow behind everything --}}
<div class="fixed inset-0 -z-20 pointer-events-none overflow-hidden" aria-hidden="true">
    <div class="bv-aurora bv-aurora-1"></div>
    <div class="bv-aurora bv-aurora-2"></div>
</div>

<style>
    .bv-aurora {
        position: absolute;
        width: 60vmax;
        height: 60vmax;
        border-radius: 50%;
        filter: blur(90px);
        opacity: 0.25;
        will-change: transform;
    }
    .bv-aurora-1 {
        background: radial-gradient(circle, rgba(46,125,50,0.6), transparent 70%);
        top: -15vmax;
        left: -10vmax;
        animation: bvAurora1 22s ease-in-out infinite alternate;
    }
    .bv-aurora-2 {
        background: radial-gradient(circle, rgba(129,199,132,0.4), transparent 70%);
        bottom: -20vmax;
        right: -15vmax;
        animation: bvAurora2 28s ease-in-out infinite alternate;
    }
    @keyframes bvAurora1 {
        from { transform: translate(0, 0) scale(1); }
        to   { transform: translate(15vmax, 10vmax) scale(1.2); }
    }
    @keyframes bvAurora2 {
        from { transform: translate(0, 0) scale(1.1); }
        to   { transform: translate(-12vmax, -8vmax) scale(1); }
    }
    @media (prefers-reduced-motion: reduce) {
        .bv-aurora { animation: none; }
    }
</style>

<script>
(function () {
    const canvas = document.getElementById('bv-fireflies');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let width, height, dpr;
    const colors = ['129,199,132', '255,213,121', '200,230,201']; // forest green, warm amber, soft mint
    let particles = [];
    const mouse = { x: -9999, y: -9999, active: false };

    function resize() {
        dpr = Math.min(window.devicePixelRatio || 1, 2);
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width * dpr;
        canvas.height = height * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        buildParticles();
    }

    function buildParticles() {
        // Density scales with screen size, capped for performance
        const count = Math.min(70, Math.floor((width * height) / 22000));
        particles = [];
        for (let i = 0; i < count; i++) {
            particles.push(spawn());
        }
    }

    function spawn() {
        return {
            x: Math.random() * width,
            y: Math.random() * height,
            r: Math.random() * 1.8 + 0.8,
            baseAlpha: Math.random() * 0.5 + 0.2,
            phase: Math.random() * Math.PI * 2,
            twinkle: Math.random() * 0.02 + 0.005,
            vx: (Math.random() - 0.5) * 0.25,
            vy: -(Math.random() * 0.25 + 0.05),
            color: colors[Math.floor(Math.random() * colors.length)],
        };
    }

    function draw() {
        ctx.clearRect(0, 0, width, height);

        for (const p of particles) {
            if (!reduceMotion) {
                // Drift
                p.x += p.vx;
                p.y += p.vy;
                p.phase += p.twinkle;

                // Mouse interaction — gentle repel + glow
                if (mouse.active) {
                    const dx = p.x - mouse.x;
                    const dy = p.y - mouse.y;
                    const dist = Math.hypot(dx, dy);
                    if (dist < 120 && dist > 0) {
                        const force = (120 - dist) / 120;
                        p.x += (dx / dist) * force * 1.5;
                        p.y += (dy / dist) * force * 1.5;
                    }
                }

                // Wrap around edges
                if (p.y < -10) { p.y = height + 10; p.x = Math.random() * width; }
                if (p.x < -10) p.x = width + 10;
                if (p.x > width + 10) p.x = -10;
            }

            const flicker = reduceMotion ? p.baseAlpha : p.baseAlpha + Math.sin(p.phase) * 0.25;
            const alpha = Math.max(0, Math.min(1, flicker));

            // Glow halo
            const glow = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r * 5);
            glow.addColorStop(0, `rgba(${p.color},${alpha})`);
            glow.addColorStop(1, `rgba(${p.color},0)`);
            ctx.fillStyle = glow;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r * 5, 0, Math.PI * 2);
            ctx.fill();

            // Core
            ctx.fillStyle = `rgba(${p.color},${alpha})`;
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fill();
        }

        if (!reduceMotion) requestAnimationFrame(draw);
    }

    window.addEventListener('resize', resize, { passive: true });
    window.addEventListener('pointermove', (e) => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
        mouse.active = true;
    }, { passive: true });
    window.addEventListener('pointerout', () => { mouse.active = false; });

    resize();
    draw(); // renders once if reduced-motion, animates otherwise
})();
</script>
