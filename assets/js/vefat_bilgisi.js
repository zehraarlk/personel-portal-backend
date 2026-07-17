/**
 * Dosya sorumluluğu: Vefat bilgisi listeleme ve filtreleme davranışları.
 *
 * Bu dosya yalnızca istemci tarafı etkileşimlerini yönetir; kalıcı
 * veri doğrulaması ve yetkilendirme sunucu tarafında yapılmalıdır.
 */
(function () {
    'use strict';

    const vefatData = Array.isArray(window.vefatData) ? window.vefatData : [];
    const ITEMS_PER_PAGE = 8;

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const grid = document.getElementById('vefatGrid');
    const resultsCount = document.getElementById('resultsCount');
    const emptyState = document.getElementById('emptyState');
    const pagination = document.getElementById('pagination');

    let currentPage = 1;

    const ICONS = window.vefatIcons || {};

    function esc(text) {
        const el = document.createElement('div');
        el.textContent = text ?? '';
        return el.innerHTML;
    }

    function iconHtml(name) {
        return ICONS[name] || ICONS.ribbon || '';
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

        if (query === '') {
            return [...vefatData];
        }

        return vefatData.filter((item) => {
            return (item.name || '').toLowerCase().includes(query)
                || (item.position || '').toLowerCase().includes(query)
                || (item.message || '').toLowerCase().includes(query);
        });
    }

    function renderPagination(totalItems) {
        if (!pagination) {
            return;
        }

        const totalPages = Math.max(1, Math.ceil(totalItems / ITEMS_PER_PAGE));

        if (totalItems <= ITEMS_PER_PAGE) {
            pagination.innerHTML = '';
            pagination.hidden = true;
            return;
        }

        pagination.hidden = false;

        let html = `
            <button type="button" data-page="prev" ${currentPage <= 1 ? 'disabled' : ''} aria-label="Önceki">‹</button>
        `;

        for (let page = 1; page <= totalPages; page += 1) {
            html += `
                <button type="button"
                        data-page="${page}"
                        class="${page === currentPage ? 'is-active' : ''}"
                        aria-label="Sayfa ${page}"
                        ${page === currentPage ? 'aria-current="page"' : ''}>
                    ${page}
                </button>
            `;
        }

        html += `
            <button type="button" data-page="next" ${currentPage >= totalPages ? 'disabled' : ''} aria-label="Sonraki">›</button>
        `;

        pagination.innerHTML = html;
    }

    function render() {
        if (!grid) {
            return;
        }

        const items = filteredItems();
        const totalPages = Math.max(1, Math.ceil(items.length / ITEMS_PER_PAGE));

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        if (resultsCount) {
            resultsCount.innerHTML = `<strong>${items.length}</strong> kayıt listeleniyor`;
        }

        if (items.length === 0) {
            grid.innerHTML = '';
            if (emptyState) {
                emptyState.hidden = false;
            }
            if (pagination) {
                pagination.hidden = true;
                pagination.innerHTML = '';
            }
            return;
        }

        if (emptyState) {
            emptyState.hidden = true;
        }

        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const pageItems = items.slice(start, start + ITEMS_PER_PAGE);

        grid.innerHTML = pageItems.map((item) => `
            <article class="vf-card">
                <div class="vf-card-rail">
                    <div class="vf-card-ribbon"><span class="icon" aria-hidden="true">${iconHtml('ribbon')}</span></div>
                </div>
                <div class="vf-card-body">
                    <h2 class="vf-card-name">${esc(item.name)}</h2>
                    ${item.position ? `<p class="vf-card-position">${esc(item.position)}</p>` : ''}
                    ${item.deathDate ? `<p class="vf-card-date"><span class="icon" aria-hidden="true">${iconHtml('calendar')}</span><span>${esc(item.deathDate)}</span></p>` : ''}
                    ${item.message ? `<p class="vf-card-message">${esc(item.message)}</p>` : ''}
                </div>
            </article>
        `).join('');

        renderPagination(items.length);
    }

    searchInput?.addEventListener('input', debounce(() => {
        currentPage = 1;
        render();
    }, 250));

    searchBtn?.addEventListener('click', () => {
        currentPage = 1;
        render();
    });

    searchInput?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            currentPage = 1;
            render();
        }
    });

    pagination?.addEventListener('click', (event) => {
        const button = event.target.closest('button[data-page]');
        if (!button || button.disabled) {
            return;
        }

        const action = button.getAttribute('data-page');
        const items = filteredItems();
        const totalPages = Math.max(1, Math.ceil(items.length / ITEMS_PER_PAGE));

        if (action === 'prev') {
            currentPage = Math.max(1, currentPage - 1);
        } else if (action === 'next') {
            currentPage = Math.min(totalPages, currentPage + 1);
        } else {
            currentPage = Number(action) || 1;
        }

        render();
        document.querySelector('.vf-toolbar')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', render);
    } else {
        render();
    }
})();
