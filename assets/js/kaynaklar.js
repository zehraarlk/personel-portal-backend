(function () {
    'use strict';

    const kaynakData = window.kaynakData || [];
    const emptyText = window.kaynakEmptyText || 'Kayıt bulunamadı.';

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const grid = document.getElementById('documentsGrid');
    const resultsCount = document.getElementById('resultsCount');
    const noResults = document.getElementById('noResults');

    const ICON_PATHS = {
        protocol: 'M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm-1 2l5 5h-5V4zM8 12h8v2H8v-2zm0 4h5v2H8v-2z',
        document: 'M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z',
        law: 'M12 3l-7 4v2h14V7l-7-4zm-8 8v2h16v-2H4zm2 4v4h12v-4H6zm2 2h8v2H8v-2z',
        education: 'M12 3 1 9l11 6 9-4.91V17h2V9M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z',
        video: 'M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z',
        calendar: 'M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM5 8V6h14v2H5z',
        documentMeta: 'M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z',
    };

    function esc(text) {
        const el = document.createElement('div');
        el.textContent = text ?? '';
        return el.innerHTML;
    }

    function iconSvg(name) {
        const path = ICON_PATHS[name] || ICON_PATHS.protocol;
        return `<span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="${path}"/></svg></span>`;
    }

    function debounce(fn, wait) {
        let timeout;
        return function debounced(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function previewDocument(url) {
        if (!url) {
            window.alert('Dosya yolu bulunamadı.');
            return;
        }

        const path = String(url).split('?')[0];
        const ext = (path.split('.').pop() || '').toLowerCase();

        if (ext === 'pdf' || /youtube\.com|youtu\.be/i.test(url)) {
            window.open(url, '_blank', 'noopener,noreferrer');
            return;
        }

        if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
            window.open(
                `https://docs.google.com/viewer?url=${encodeURIComponent(url)}&embedded=true`,
                '_blank',
                'noopener,noreferrer'
            );
            return;
        }

        window.open(url, '_blank', 'noopener,noreferrer');
    }

    function filteredItems() {
        const query = (searchInput?.value || '').trim().toLowerCase();

        if (query === '') {
            return [...kaynakData];
        }

        return kaynakData.filter((item) => {
            return (item.title || '').toLowerCase().includes(query)
                || (item.excerpt || '').toLowerCase().includes(query)
                || (item.description || '').toLowerCase().includes(query)
                || (item.categoryName || '').toLowerCase().includes(query);
        });
    }

    function render() {
        if (!grid) {
            return;
        }

        const items = filteredItems();

        if (resultsCount) {
            resultsCount.innerHTML = `<strong>${items.length}</strong> sonuç bulundu`;
        }

        if (items.length === 0) {
            grid.innerHTML = '';
            if (noResults) {
                noResults.hidden = false;
                const text = noResults.querySelector('p');
                if (text) {
                    text.textContent = emptyText;
                }
            }
            return;
        }

        if (noResults) {
            noResults.hidden = true;
        }

        grid.innerHTML = items.map((item) => {
            const metaBits = [];
            if (item.ext || item.size) {
                metaBits.push(`
                    <span>
                        ${iconSvg('documentMeta')}
                        ${esc([item.ext, item.size].filter(Boolean).join(' • '))}
                    </span>
                `);
            }
            if (item.date) {
                metaBits.push(`
                    <span>
                        ${iconSvg('calendar')}
                        ${esc(item.date)}
                    </span>
                `);
            }

            const official = item.officialUrl
                ? `<a class="kr-card-btn is-secondary" href="${esc(item.officialUrl)}" target="_blank" rel="noopener noreferrer">Resmi Sayfa</a>`
                : '';

            return `
                <article class="kr-card">
                    <div class="kr-card-header">
                        <div class="kr-card-icon">${iconSvg(item.icon || 'protocol')}</div>
                        <div class="kr-card-info">
                            <h2 class="kr-card-title">${esc(item.title)}</h2>
                            ${item.categoryName ? `<span class="kr-card-category">${esc(item.categoryName)}</span>` : ''}
                        </div>
                    </div>
                    <p class="kr-card-desc">${esc(item.excerpt || item.description || '')}</p>
                    <div class="kr-card-meta">${metaBits.join('')}</div>
                    <div class="kr-card-actions">
                        <button type="button" class="kr-card-btn" data-preview-url="${esc(item.fileUrl)}">
                            Detaylı Bilgi İçin Tıklayınız
                        </button>
                        ${official}
                    </div>
                </article>
            `;
        }).join('');
    }

    searchInput?.addEventListener('input', debounce(render, 250));
    searchBtn?.addEventListener('click', render);
    searchInput?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            render();
        }
    });

    grid?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-preview-url]');
        if (!button) {
            return;
        }

        previewDocument(button.getAttribute('data-preview-url') || '');
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', render);
    } else {
        render();
    }
})();
