function usuarios() {
    $('#menu_carga').show();
}

function roles() {
    $('#menu_carga').show();
}

function poderes() {
    $('#menu_carga').show();
}

function capacitaciones() {
    $('#menu_carga').show();
}

function mis_capacitaciones() {
    $('#menu_carga').show();
}

function expedientes() {
    $('#menu_carga').show();
}

function revista() {
    $('#menu_carga').show();
}

function estadistica() {
    $('#menu_carga').show();
}

function crear_usuario() {
    $('#menu_carga').show();
}

function editar_usuario() {
    $('#menu_carga').show();
}

function crear_rol() {
    $('#menu_carga').show();
}

function editar_rol() {
    $('#menu_carga').show();
}

function turnos() {
    $('#menu_carga').show();
}

function historial() {
    $('#menu_carga').show();
}

function mis_citas() {
    $('#menu_carga').show();
}

(function () {

    try {
        const csrfTag = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTag) return;

        const meta = (name, fallback = null) => {
            const el = document.querySelector(`meta[name="${name}"]`);
            return el ? el.getAttribute('content') : fallback;
        };

        const REVERB_KEY = meta('reverb-key', 'local');
        const REVERB_HOST = meta('reverb-host', window.location.hostname);
        const REVERB_PORT = parseInt(meta('reverb-port', '8080'), 10);
        const REVERB_SCHEME = meta('reverb-scheme', window.location.protocol.replace(':',''));
        const FORCE_TLS = (REVERB_SCHEME === 'https');

        function loadScript(src) {
            return new Promise((resolve, reject) => {
                const s = document.createElement('script');
                s.src = src;
                s.async = true;
                s.onload = resolve;
                s.onerror = reject;
                document.head.appendChild(s);
            });
        }

        function ensureEcho() {
            if (window.Echo) return Promise.resolve();
            return loadScript('https://cdn.jsdelivr.net/npm/laravel-echo@^1/dist/echo.iife.js');
        }

        function initEcho() {
            if (window.Echo) return;
            const token = csrfTag.getAttribute('content');
            window.Echo = new window.EchoIIFE.Echo({
                broadcaster: 'reverb',
                key: REVERB_KEY,
                wsHost: REVERB_HOST,
                wsPort: REVERB_PORT,
                wssPort: REVERB_PORT,
                forceTLS: FORCE_TLS,
                enabledTransports: ['ws', 'wss'],
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: { 'X-CSRF-TOKEN': token }
                }
            });
        }

        let audio; let audioArmed = false;
        function armAudioOnce() {
            if (audioArmed) return;
            audioArmed = true;
            audio = new Audio('/sounds/notification.mp3');
            audio.preload = 'auto';
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
            }).catch(() => {/* ignore */});
            document.removeEventListener('click', armAudioOnce);
        }
        document.addEventListener('click', armAudioOnce, { once: true });

        function playNotification() {
            if (!audio) return;
            try {
                audio.currentTime = 0;
                audio.play().catch(() => {/* ignored */});
            } catch (e) { /* ignored */ }
        }

        function updateMenuBadge(count) {
            const link = document.getElementById('menu-pendiente-firma');
            if (!link) return;
            const badge = document.getElementById('badge-pendiente-firma');
            if (typeof count === 'number') {
                if (badge) {
                    badge.textContent = count;
                    badge.style.display = count > 0 ? 'inline-block' : 'none';
                }
            }
            link.classList.add('highlight-realtime');
            setTimeout(() => link.classList.remove('highlight-realtime'), 5000);
        }

        ensureEcho().then(() => {
            initEcho();
            if (!window.Echo) return;
            window.Echo.private('pendiente-firma')
                .listen('PendienteFirmaUpdated', (e) => {
                    updateMenuBadge(typeof e.count === 'number' ? e.count : null);
                    playNotification();
                });
        }).catch(() => {
        });
    } catch (err) {
    }
})();
