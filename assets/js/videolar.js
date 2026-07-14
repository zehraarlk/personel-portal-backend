(function () {
    'use strict';

    const videos = window.veritabanindanGelenVideolar || [];
    const ITEMS_PER_PAGE = 8;

    let currentPage = 1;
    let activeCategory = 'all';

    const grid = document.getElementById('video-grid');
    const searchInput = document.getElementById('video-search-input');
    const filterButtons = document.querySelectorAll('.video-filters [data-category]');
    const noResults = document.getElementById('no-results-message');
    const pagination = document.getElementById('video-pagination');
    const modal = document.getElementById('video-modal');
    const iframe = document.getElementById('youtube-iframe');
    const modalClose = document.getElementById('video-modal-close');
    const showAllBtn = document.getElementById('show-all-videos-btn');
    const videoFilters = document.getElementById('video-filters');
    const videoGridAnchor = document.getElementById('video-grid-baslangic');

    function scrollToVideoFilters() {
        (videoFilters || videoGridAnchor || grid)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function esc(text) {
        const el = document.createElement('div');
        el.textContent = text ?? '';
        return el.innerHTML;
    }

    function openVideo(youtubeId) {
        if (!modal || !iframe || !youtubeId) {
            return;
        }

        iframe.src = `https://www.youtube.com/embed/${encodeURIComponent(youtubeId)}?autoplay=1`;
        if (typeof modal.showModal === 'function') {
            modal.showModal();
        }
    }

    function closeVideo() {
        if (!modal || !iframe) {
            return;
        }

        iframe.src = '';
        if (typeof modal.close === 'function') {
            modal.close();
        }
    }

    function getFilteredVideos() {
        const term = (searchInput?.value || '').trim().toLowerCase();

        return videos.filter((video) => {
            const categoryMatch = activeCategory === 'all' || video.kategori === activeCategory;
            const searchMatch = !term || video.baslik.toLowerCase().includes(term);
            return categoryMatch && searchMatch;
        });
    }

    function renderPagination(totalItems) {
        if (!pagination) {
            return;
        }

        const totalPages = Math.max(1, Math.ceil(totalItems / ITEMS_PER_PAGE));
        currentPage = Math.min(currentPage, totalPages);

        if (totalPages <= 1) {
            pagination.innerHTML = '';
            pagination.hidden = true;
            return;
        }

        pagination.hidden = false;
        let html = `<button type="button" data-page="${currentPage - 1}" aria-label="Önceki sayfa"${currentPage <= 1 ? ' disabled' : ''}>‹</button>`;

        for (let i = 1; i <= totalPages; i += 1) {
            html += `<button type="button" data-page="${i}" class="${i === currentPage ? 'is-active' : ''}" aria-label="Sayfa ${i}"${i === currentPage ? ' aria-current="page"' : ''}>${i}</button>`;
        }

        html += `<button type="button" data-page="${currentPage + 1}" aria-label="Sonraki sayfa"${currentPage >= totalPages ? ' disabled' : ''}>›</button>`;
        pagination.innerHTML = html;
    }

    function renderVideos() {
        if (!grid) {
            return;
        }

        const filtered = getFilteredVideos();
        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const pageItems = filtered.slice(start, start + ITEMS_PER_PAGE);

        if (pageItems.length === 0) {
            grid.innerHTML = '';
            if (noResults) {
                noResults.hidden = false;
            }
        } else {
            if (noResults) {
                noResults.hidden = true;
            }

            grid.innerHTML = pageItems.map((video) => `
                <button type="button" class="video-card" data-youtube-id="${esc(video.youtubeId)}" aria-label="${esc(video.baslik)}">
                    <div class="video-card-thumb">
                        <img src="${esc(video.thumb)}" alt="" loading="lazy">
                        <span class="play-icon-overlay" aria-hidden="true">
                            <span class="icon">${window.videoPlayIcon || ''}</span>
                        </span>
                    </div>
                    <div class="video-card-body">
                        <h3>${esc(video.baslik)}</h3>
                        <p>${esc(video.aciklama)}</p>
                    </div>
                    <div class="video-card-footer">
                        <span class="video-card-meta">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58s1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg>
                            ${esc(video.kategoriAd)}
                        </span>
                        <span class="video-card-meta">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                            ${esc(video.sure)}
                        </span>
                    </div>
                </button>
            `).join('');
        }

        renderPagination(filtered.length);
    }

    document.querySelectorAll('.featured-video [data-youtube-id]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            openVideo(trigger.getAttribute('data-youtube-id'));
        });
    });

    showAllBtn?.addEventListener('click', scrollToVideoFilters);

    filterButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            filterButtons.forEach((btn) => {
                btn.classList.remove('is-active');
                btn.setAttribute('aria-selected', 'false');
            });
            button.classList.add('is-active');
            button.setAttribute('aria-selected', 'true');
            activeCategory = button.getAttribute('data-category') || 'all';
            currentPage = 1;
            renderVideos();
        });
    });

    searchInput?.addEventListener('input', () => {
        currentPage = 1;
        renderVideos();
    });

    pagination?.addEventListener('click', (event) => {
        const button = event.target.closest('button[data-page]');
        if (!button || button.disabled || button.classList.contains('is-active')) {
            return;
        }

        currentPage = Number(button.getAttribute('data-page'));
        renderVideos();
        scrollToVideoFilters();
    });

    modalClose?.addEventListener('click', closeVideo);

    modal?.addEventListener('click', (event) => {
        const rect = modal.querySelector('.video-modal-inner')?.getBoundingClientRect();
        if (!rect) {
            return;
        }

        const isOutside =
            event.clientX < rect.left ||
            event.clientX > rect.right ||
            event.clientY < rect.top ||
            event.clientY > rect.bottom;

        if (isOutside) {
            closeVideo();
        }
    });

    modal?.addEventListener('close', () => {
        if (iframe) {
            iframe.src = '';
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal?.open) {
            closeVideo();
        }
    });

    grid?.addEventListener('click', (event) => {
        const card = event.target.closest('.video-card');
        if (!card) {
            return;
        }

        openVideo(card.getAttribute('data-youtube-id'));
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', renderVideos);
    } else {
        renderVideos();
    }

    if (window.location.hash === '#video-filters' || window.location.hash === '#video-grid-baslangic') {
        scrollToVideoFilters();
    }
})();
