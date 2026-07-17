/**
 * Dosya sorumluluğu: Kaynak arama, kategori filtresi ve dosya işlemleri.
 *
 * Bu dosya yalnızca istemci tarafı etkileşimlerini yönetir; kalıcı
 * veri doğrulaması ve yetkilendirme sunucu tarafında yapılmalıdır.
 */
(function () {
    'use strict';

    const kaynakData = window.kaynakData || [];
    const emptyText = window.kaynakEmptyText || 'Kayıt bulunamadı.';
    const isDokumanlarPage = window.kaynakActiveKey === 'document';
    const kaynakIcons = window.kaynakIcons || {};
    const previewBase = window.kaynakPreviewBase || 'kaynak_onizleme.php?id=';
    const downloadBase = window.kaynakDownloadBase || 'kaynak_dosya.php?id=';

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const grid = document.getElementById('documentsGrid');
    const resultsCount = document.getElementById('resultsCount');
    const noResults = document.getElementById('noResults');

    function esc(text) {
        const el = document.createElement('div');
        el.textContent = text ?? '';
        return el.innerHTML;
    }

    function iconHtml(name) {
        return kaynakIcons[name]
            || kaynakIcons.protokoller
            || '<span class="icon" aria-hidden="true"></span>';
    }

    function debounce(fn, wait) {
        let timeout;
        return function debounced(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    function toAbsoluteUrl(url) {
        if (!url) {
            return '';
        }

        try {
            return new URL(String(url), window.location.href).href;
        } catch (e) {
            return String(url);
        }
    }

    function openPreview(itemOrUrl, maybeId) {
        const id = typeof itemOrUrl === 'object' && itemOrUrl
            ? Number(itemOrUrl.id || 0)
            : Number(maybeId || 0);

        if (id > 0) {
            window.open(`${previewBase}${encodeURIComponent(String(id))}`, '_blank', 'noopener,noreferrer');
            return;
        }

        const url = typeof itemOrUrl === 'string' ? itemOrUrl : '';
        if (!url) {
            window.alert('Dosya yolu bulunamadı.');
            return;
        }

        window.open(toAbsoluteUrl(url), '_blank', 'noopener,noreferrer');
    }

    function fileNameFromUrl(url) {
        if (!url) {
            return '';
        }
        const path = String(url).split('?')[0].split('#')[0];
        const segments = path.split('/');
        return decodeURIComponent(segments[segments.length - 1] || '');
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
                        ${iconHtml('dokumanlar')}
                        ${esc([item.ext, item.size].filter(Boolean).join(' • '))}
                    </span>
                `);
            }
            if (item.date) {
                metaBits.push(`
                    <span>
                        ${iconHtml('tarih')}
                        ${esc(item.date)}
                    </span>
                `);
            }

            const official = item.officialUrl
                ? `<a class="kr-card-btn is-secondary${isDokumanlarPage ? ' is-full' : ''}" href="${esc(item.officialUrl)}" target="_blank" rel="noopener noreferrer">Resmi Sayfa</a>`
                : '';

            const actions = isDokumanlarPage
                ? `
                    <button type="button" class="kr-card-btn" data-preview-id="${esc(String(item.id || ''))}">
                        ${iconHtml('preview')}
                        Önizle
                    </button>
                    <a class="kr-card-btn is-secondary kr-download-btn" href="${esc(downloadBase + encodeURIComponent(String(item.id || '')))}">
                        ${iconHtml('download')}
                        İndir
                    </a>
                    ${official}
                `
                : `
                    <button type="button" class="kr-card-btn" data-preview-url="${esc(item.fileUrl)}">
                        Detaylı Bilgi İçin Tıklayınız
                    </button>
                    ${official}
                `;

            return `
                <article class="kr-card">
                    <div class="kr-card-header">
                        <div class="kr-card-icon">${iconHtml(item.icon || 'protokoller')}</div>
                        <div class="kr-card-info">
                            <h2 class="kr-card-title">${esc(item.title)}</h2>
                            ${item.categoryName ? `<span class="kr-card-category">${esc(item.categoryName)}</span>` : ''}
                        </div>
                    </div>
                    <p class="kr-card-desc">${esc(item.excerpt || item.description || '')}</p>
                    <div class="kr-card-meta">${metaBits.join('')}</div>
                    <div class="kr-card-actions${isDokumanlarPage ? ' is-split' : ''}">${actions}</div>
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
        const previewIdBtn = event.target.closest('[data-preview-id]');
        if (previewIdBtn) {
            openPreview(null, previewIdBtn.getAttribute('data-preview-id') || '0');
            return;
        }

        const previewBtn = event.target.closest('[data-preview-url]');
        if (previewBtn) {
            openPreview(previewBtn.getAttribute('data-preview-url') || '');
            return;
        }

        const downloadBtn = event.target.closest('.kr-download-btn');
        if (downloadBtn && !downloadBtn.getAttribute('href')) {
            event.preventDefault();
            window.alert('Dosya yolu bulunamadı.');
        }
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', render);
    } else {
        render();
    }
})();
