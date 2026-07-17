/**
 * Dosya sorumluluğu: Personel oturumunun tarayıcı yaşam döngüsü koruması.
 *
 * Bu dosya yalnızca istemci tarafı etkileşimlerini yönetir; kalıcı
 * veri doğrulaması ve yetkilendirme sunucu tarafında yapılmalıdır.
 */
(function () {
    'use strict';

    const body = document.body;
    const endpointRaw = body?.dataset.oturumKapat;

    if (!endpointRaw || body.dataset.portalSession !== '1') {
        return;
    }

    if (window.__ppSessionGuard) {
        return;
    }

    window.__ppSessionGuard = true;

    const endpoint = new URL(endpointRaw, window.location.href).href;
    const NAV_KEY = 'pp_internal_nav';
    const NAV_TTL_MS = 8000;
    let sent = false;

    function markInternalNav() {
        try {
            sessionStorage.setItem(NAV_KEY, String(Date.now()));
        } catch (error) {
            // Sessizce geç
        }
    }

    function isInternalNav() {
        try {
            const raw = sessionStorage.getItem(NAV_KEY);
            if (!raw) {
                return false;
            }

            const timestamp = parseInt(raw, 10);
            if (!timestamp || Number.isNaN(timestamp)) {
                return raw === '1';
            }

            return (Date.now() - timestamp) < NAV_TTL_MS;
        } catch (error) {
            return false;
        }
    }

    function markReloadIfNeeded() {
        try {
            const nav = performance.getEntriesByType('navigation')[0];
            if (nav && nav.type === 'reload') {
                markInternalNav();
            }
        } catch (error) {
            // Sessizce geç
        }
    }

    markReloadIfNeeded();

    window.addEventListener('pageshow', (event) => {
        if (event.persisted) {
            markInternalNav();
        }
        markReloadIfNeeded();
    });

    function sameOriginHref(href) {
        if (!href || href.charAt(0) === '#' || href.indexOf('javascript:') === 0) {
            return false;
        }

        try {
            const url = new URL(href, window.location.href);
            return url.origin === window.location.origin;
        } catch (error) {
            return href.indexOf('http') !== 0;
        }
    }

    function onPossibleNav(event) {
        const anchor = event.target && event.target.closest ? event.target.closest('a[href]') : null;
        if (!anchor) {
            return;
        }

        if (anchor.target && anchor.target !== '' && anchor.target !== '_self') {
            return;
        }

        if (sameOriginHref(anchor.getAttribute('href') || anchor.href || '')) {
            markInternalNav();
        }
    }

    document.addEventListener('mousedown', onPossibleNav, true);
    document.addEventListener('touchstart', onPossibleNav, true);
    document.addEventListener('click', onPossibleNav, true);
    document.addEventListener('submit', () => {
        markInternalNav();
    }, true);

    window.addEventListener('keydown', (event) => {
        if (event.key === 'F5' || ((event.ctrlKey || event.metaKey) && (event.key === 'r' || event.key === 'R'))) {
            markInternalNav();
        }
    });

    function closeSession() {
        if (sent || isInternalNav()) {
            return;
        }

        sent = true;

        try {
            if (navigator.sendBeacon) {
                navigator.sendBeacon(endpoint, new Blob(['1'], { type: 'text/plain' }));
            }
        } catch (error) {
            // sendBeacon desteklenmiyorsa fetch dene
        }

        try {
            fetch(endpoint, {
                method: 'POST',
                keepalive: true,
                credentials: 'same-origin',
                cache: 'no-store',
            });
        } catch (error) {
            // Sessizce geç
        }
    }

    window.addEventListener('pagehide', (event) => {
        if (event.persisted || isInternalNav()) {
            return;
        }

        closeSession();
    });

    window.addEventListener('beforeunload', () => {
        if (!isInternalNav()) {
            closeSession();
        }
    });
})();
