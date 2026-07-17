/**
 * Dosya sorumluluğu: Anket filtreleme, listeleme ve favori işlemleri.
 *
 * Bu dosya yalnızca istemci tarafı etkileşimlerini yönetir; kalıcı
 * veri doğrulaması ve yetkilendirme sunucu tarafında yapılmalıdır.
 */
(function () {
    'use strict';

    const anketData = Array.isArray(window.anketData) ? window.anketData : [];
    const config = window.anketConfig || {};

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const sortSelect = document.getElementById('sortSelect');
    const grid = document.getElementById('surveyGrid');
    const resultsCount = document.getElementById('resultsCount');
    const emptyState = document.getElementById('emptyState');
    const emptyStateText = document.getElementById('emptyStateText');
    const toastHost = document.getElementById('toastHost');
    const filterTabs = document.querySelectorAll('.ak-filter-tab');

    let activeFilter = 'all';

    const ICON_PATHS = {
        play: 'M8 5v14l11-7z',
        clock: 'M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z',
        check: 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z',
        close: 'M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z',
        calendar: 'M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM5 8V6h14v2H5z',
        star: 'M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z',
        starOutline: 'M22 9.24l-7.19-.62L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21 12 17.27 18.18 21l-1.63-7.03L22 9.24zM12 15.4l-3.76 2.27 1-4.28-3.32-2.88 4.38-.38L12 6.1l1.71 4.04 4.38.38-3.32 2.88 1 4.28L12 15.4z',
        eye: 'M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z',
        edit: 'M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z',
    };

    function esc(text) {
        const el = document.createElement('div');
        el.textContent = text ?? '';
        return el.innerHTML;
    }

    function iconSvg(name) {
        const path = ICON_PATHS[name] || ICON_PATHS.play;
        return `<span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="${path}"/></svg></span>`;
    }

    function debounce(fn, wait) {
        let timeout;
        return function debounced(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function showToast(message, type) {
        if (!toastHost) {
            return;
        }

        const toast = document.createElement('div');
        toast.className = 'ak-toast' + (type === 'error' ? ' is-error' : type === 'warn' ? ' is-warn' : '');
        toast.textContent = message;
        toastHost.appendChild(toast);
        setTimeout(() => toast.remove(), 3200);
    }

    function filteredItems() {
        const query = (searchInput?.value || '').trim().toLowerCase();
        let items = anketData.filter((item) => {
            if (activeFilter === 'favorites') {
                return !!item.favorite;
            }
            if (activeFilter !== 'all' && item.category !== activeFilter) {
                return false;
            }
            return true;
        });

        if (query !== '') {
            items = items.filter((item) => {
                return (item.title || '').toLowerCase().includes(query)
                    || (item.excerpt || '').toLowerCase().includes(query)
                    || (item.description || '').toLowerCase().includes(query);
            });
        }

        const sort = sortSelect?.value || 'newest';
        items = [...items].sort((a, b) => {
            if (sort === 'popular') {
                return (b.percent || 0) - (a.percent || 0);
            }

            const dateA = Date.parse(a.dateSort || '') || 0;
            const dateB = Date.parse(b.dateSort || '') || 0;

            if (sort === 'oldest') {
                return dateA - dateB || a.id - b.id;
            }

            return dateB - dateA || b.id - a.id;
        });

        return items;
    }

    function emptyMessage(query) {
        if (activeFilter === 'favorites') {
            return 'Henüz favori anketiniz bulunmuyor.';
        }
        if (query) {
            return 'Aradığınız kriterlere uygun anket bulunamadı.';
        }
        return 'Bu kategoride anket bulunamadı.';
    }

    function actionButton(item) {
        const joinUrl = item.joinUrl || '#';

        if (item.participated) {
            return `
                <a class="ak-btn is-view" href="${esc(joinUrl)}">
                    ${iconSvg('eye')}
                    <span>Cevaplarınızı Görüntüleyin</span>
                </a>
            `;
        }

        return `
            <a class="ak-btn" href="${esc(joinUrl)}">
                ${iconSvg('edit')}
                <span>Ankete Katıl</span>
            </a>
        `;
    }

    function renderCard(item) {
        return `
            <article class="ak-card" data-id="${esc(String(item.id))}">
                <span class="ak-status ${esc(item.statusClass || 'is-active')}">
                    ${iconSvg(item.statusIcon || 'play')}
                    ${esc(item.statusLabel || 'Aktif')}
                </span>
                <img class="ak-card-image" src="${esc(item.image)}" alt="${esc(item.title)}" loading="lazy" width="640" height="400">
                <div class="ak-card-body">
                    <h2 class="ak-card-title">${esc(item.title)}</h2>
                    <p class="ak-card-desc">${esc(item.excerpt || item.description || '')}</p>
                    ${item.dateLabel ? `<p class="ak-card-date">${iconSvg('calendar')}${esc(item.dateLabel)}</p>` : ''}
                    <div class="ak-progress">
                        <div class="ak-progress-meta">
                            <span>Katılım: ${esc(String(item.participants))}/${esc(String(item.target))} kişi</span>
                            <span>%${esc(String(item.percent))}</span>
                        </div>
                        <div class="ak-progress-track" aria-hidden="true">
                            <div class="ak-progress-bar" data-percent="${esc(String(item.percent))}"></div>
                        </div>
                    </div>
                    <div class="ak-card-actions">
                        ${actionButton(item)}
                        <button type="button"
                                class="ak-btn is-favorite${item.favorite ? ' is-on' : ''}"
                                data-favorite-id="${esc(String(item.id))}"
                                aria-pressed="${item.favorite ? 'true' : 'false'}">
                            ${iconSvg(item.favorite ? 'star' : 'starOutline')}
                            ${item.favorite ? 'Favorilerden Çıkar' : 'Favorilere Ekle'}
                        </button>
                    </div>
                </div>
            </article>
        `;
    }

    function render() {
        if (!grid) {
            return;
        }

        const query = (searchInput?.value || '').trim();
        const items = filteredItems();

        if (resultsCount) {
            resultsCount.innerHTML = `<strong>${items.length}</strong> sonuç bulundu`;
        }

        if (items.length === 0) {
            grid.innerHTML = '';
            if (emptyState) {
                emptyState.hidden = false;
            }
            if (emptyStateText) {
                emptyStateText.textContent = emptyMessage(query);
            }
            return;
        }

        if (emptyState) {
            emptyState.hidden = true;
        }

        grid.innerHTML = items.map(renderCard).join('');
        grid.querySelectorAll('.ak-progress-bar[data-percent]').forEach((bar) => {
            const percent = Math.max(0, Math.min(100, Number(bar.getAttribute('data-percent') || 0)));
            bar.style.width = percent + '%';
        });
    }

    async function toggleFavorite(button) {
        const id = Number(button.getAttribute('data-favorite-id') || 0);
        const item = anketData.find((row) => row.id === id);
        if (!item || !config.favoriUrl) {
            return;
        }

        const nextValue = item.favorite ? 0 : 1;
        button.disabled = true;

        try {
            const body = new FormData();
            body.append('id', String(id));
            body.append('favori', String(nextValue));
            body.append('csrf_token', config.csrfToken || '');

            const response = await fetch(config.favoriUrl, {
                method: 'POST',
                body,
                credentials: 'same-origin',
            });
            const data = await response.json();

            if (!response.ok || !data.ok) {
                throw new Error(data.message || 'Favori güncellenemedi.');
            }

            item.favorite = nextValue === 1;
            render();
            showToast(
                item.favorite ? 'Anket favorilere eklendi.' : 'Anket favorilerden çıkarıldı.',
                item.favorite ? 'warn' : ''
            );
        } catch (error) {
            showToast(error.message || 'Bir hata oluştu.', 'error');
        } finally {
            button.disabled = false;
        }
    }

    filterTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            filterTabs.forEach((el) => el.classList.remove('is-active'));
            tab.classList.add('is-active');
            activeFilter = tab.getAttribute('data-filter') || 'all';
            render();
        });
    });

    searchInput?.addEventListener('input', debounce(render, 250));
    searchBtn?.addEventListener('click', render);
    sortSelect?.addEventListener('change', render);

    grid?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-favorite-id]');
        if (!button) {
            return;
        }
        event.preventDefault();
        toggleFavorite(button);
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', render);
    } else {
        render();
    }
})();
