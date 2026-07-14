(function () {
    'use strict';

    const linkData = Array.isArray(window.yardimciLinkData) ? window.yardimciLinkData : [];

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const sortSelect = document.getElementById('sortSelect');
    const grid = document.getElementById('linksGrid');
    const resultsCount = document.getElementById('resultsCount');
    const emptyState = document.getElementById('emptyState');
    const emptyStateText = document.getElementById('emptyStateText');

    const EXTERNAL_ICON = 'M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z';

    function esc(text) {
        const el = document.createElement('div');
        el.textContent = text ?? '';
        return el.innerHTML;
    }

    function iconSvg(path) {
        return `<span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="${path}"/></svg></span>`;
    }

    function debounce(fn, wait) {
        let timeout;
        return function debounced(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function filteredItems() {
        const query = (searchInput?.value || '').trim().toLowerCase();
        const category = sortSelect?.value || 'all';

        return linkData.filter((item) => {
            const matchesCategory = category === 'all' || item.category === category;
            const matchesSearch = query === '' || (item.title || '').toLowerCase().includes(query);
            return matchesCategory && matchesSearch;
        });
    }

    function render() {
        if (!grid) {
            return;
        }

        const items = filteredItems();
        const query = (searchInput?.value || '').trim();
        const category = sortSelect?.value || 'all';

        if (resultsCount) {
            resultsCount.innerHTML = `<strong>${items.length}</strong> sonuç bulundu`;
        }

        if (items.length === 0) {
            grid.innerHTML = '';
            if (emptyState) {
                emptyState.hidden = false;
            }
            if (emptyStateText) {
                emptyStateText.textContent = query || category !== 'all'
                    ? 'Aradığınız kriterlere uygun yardımcı link bulunamadı.'
                    : 'Henüz yardımcı link eklenmemiş.';
            }
            return;
        }

        if (emptyState) {
            emptyState.hidden = true;
        }

        grid.innerHTML = items.map((item) => {
            const logoHtml = item.logo
                ? `<img src="${esc(item.logo)}" alt="${esc(item.title)}" width="104" height="104" loading="lazy">`
                : `<span class="yl-card-fallback">${iconSvg(EXTERNAL_ICON)}</span>`;

            return `
                <article class="yl-card" data-category="${esc(item.category || '')}">
                    <div class="yl-card-logo">${logoHtml}</div>
                    <h2 class="yl-card-title">${esc(item.title)}</h2>
                    ${item.categoryName ? `<span class="yl-card-category">${esc(item.categoryName)}</span>` : ''}
                    <a class="yl-card-btn"
                       href="${esc(item.url || '#')}"
                       target="_blank"
                       rel="noopener noreferrer">
                        ${iconSvg(EXTERNAL_ICON)}
                        <span>Siteye Git</span>
                    </a>
                </article>
            `;
        }).join('');
    }

    searchInput?.addEventListener('input', debounce(render, 250));
    searchBtn?.addEventListener('click', render);
    sortSelect?.addEventListener('change', render);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', render);
    } else {
        render();
    }
})();
