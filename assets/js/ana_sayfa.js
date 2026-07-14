(function () {
    'use strict';

    const haberler = window.veritabanindanGelenHaberler || [];
    const duyurular = window.veritabanindanGelenDuyurular || [];
    const DUYURU_PER_PAGE = 4;
    const DEFAULT_THUMB_VISIBLE = 4;

    let activeHaberIndex = 0;
    let galleryPage = 0;
    let duyuruPage = 1;

    const mainImg = document.getElementById('main-haber-gorsel');
    const mainTitle = document.getElementById('ana-haber-baslik');
    const mainLink = document.getElementById('ana-haber-link');
    const galleryTrack = document.getElementById('gallery-track');
    const galleryWrapper = galleryTrack?.closest('.gallery-wrapper');
    const galleryDots = document.getElementById('gallery-dots');
    const galleryPrev = document.getElementById('gallery-prev-btn');
    const galleryNext = document.getElementById('gallery-next-btn');
    const duyuruList = document.getElementById('duyurular-listesi');
    const duyuruPrev = document.getElementById('prev-page');
    const duyuruNext = document.getElementById('next-page');
    const sayfaBilgi = document.getElementById('sayfa-bilgisi');

    function esc(text) {
        const el = document.createElement('div');
        el.textContent = text ?? '';
        return el.innerHTML;
    }

    const base = window.assetBase || '';

    function etkinlikUrl(id) {
        return `${base}pages/etkinlik_detay.php?id=${id}`;
    }

    function duyuruUrl(id) {
        return `${base}pages/duyuru_detay.php?tip=anasayfa&id=${id}`;
    }

    function getGalleryMetrics() {
        const thumb = galleryTrack?.querySelector('.gallery-thumb');
        if (!thumb || !galleryTrack || !galleryWrapper) {
            return { step: 0, visible: DEFAULT_THUMB_VISIBLE, maxPage: 0 };
        }

        const trackStyle = getComputedStyle(galleryTrack);
        const gap = parseFloat(trackStyle.columnGap || trackStyle.gap) || 0;
        const thumbWidth = thumb.getBoundingClientRect().width;
        const step = thumbWidth + gap;
        const visible = Math.max(1, Math.floor((galleryWrapper.clientWidth + gap) / step));
        const maxPage = Math.max(0, Math.ceil(haberler.length / visible) - 1);

        return { step, visible, maxPage };
    }

    function setMainHaber(index) {
        if (!haberler.length) {
            return;
        }

        activeHaberIndex = index;
        const haber = haberler[index];

        if (mainImg) {
            mainImg.src = haber.resim;
            mainImg.alt = haber.baslik;
        }
        if (mainTitle) {
            mainTitle.textContent = haber.baslik;
        }
        if (mainLink) {
            mainLink.href = etkinlikUrl(haber.id);
        }

        galleryTrack?.querySelectorAll('.gallery-thumb').forEach((thumb, i) => {
            thumb.classList.toggle('is-active', i === index);
        });
    }

    function bindGalleryThumbs() {
        if (!galleryTrack) {
            return;
        }

        galleryTrack.querySelectorAll('.gallery-thumb').forEach((thumb) => {
            thumb.replaceWith(thumb.cloneNode(true));
        });

        galleryTrack.querySelectorAll('.gallery-thumb').forEach((thumb) => {
            thumb.addEventListener('click', () => {
                setMainHaber(Number(thumb.dataset.index));
            });
        });
    }

    function renderGallery() {
        if (!galleryTrack || !haberler.length) {
            return;
        }

        if (!galleryTrack.children.length) {
            galleryTrack.innerHTML = haberler.map((haber, index) => `
                <button type="button" class="gallery-thumb${index === activeHaberIndex ? ' is-active' : ''}" data-index="${index}" aria-label="${esc(haber.baslik)}">
                    <img src="${esc(haber.resim)}" alt="">
                </button>
            `).join('');
        }

        bindGalleryThumbs();
        updateGalleryNavState();
        renderGalleryDots();
        updateGalleryPosition();
    }

    function renderGalleryDots() {
        if (!galleryDots) {
            return;
        }

        const { maxPage } = getGalleryMetrics();
        const totalPages = maxPage + 1;

        galleryDots.innerHTML = Array.from({ length: totalPages }, (_, i) =>
            `<button type="button" class="gallery-dot${i === galleryPage ? ' is-active' : ''}" data-page="${i}" aria-label="Galeri sayfa ${i + 1}"></button>`
        ).join('');

        galleryDots.querySelectorAll('.gallery-dot').forEach((dot) => {
            dot.addEventListener('click', () => {
                galleryPage = Number(dot.dataset.page);
                updateGalleryPosition();
                renderGalleryDots();
                updateGalleryNavState();
            });
        });
    }

    function updateGalleryNavState() {
        const { maxPage } = getGalleryMetrics();

        if (galleryPrev) {
            galleryPrev.disabled = galleryPage <= 0;
        }
        if (galleryNext) {
            galleryNext.disabled = galleryPage >= maxPage;
        }
    }

    function updateGalleryPosition() {
        if (!galleryTrack) {
            return;
        }

        const { step, visible, maxPage } = getGalleryMetrics();

        galleryPage = Math.min(galleryPage, maxPage);
        galleryTrack.style.transform = step > 0
            ? `translateX(-${galleryPage * step * visible}px)`
            : '';

        updateGalleryNavState();
    }

    function renderDuyurular() {
        if (!duyuruList) {
            return;
        }

        const totalPages = Math.max(1, Math.ceil(duyurular.length / DUYURU_PER_PAGE));
        duyuruPage = Math.min(duyuruPage, totalPages);

        const start = (duyuruPage - 1) * DUYURU_PER_PAGE;
        const pageItems = duyurular.slice(start, start + DUYURU_PER_PAGE);

        if (!pageItems.length) {
            duyuruList.innerHTML = '<p class="home-empty">Henüz duyuru bulunmamaktadır.</p>';
        } else {
            duyuruList.innerHTML = pageItems.map((d) => `
                <a href="${duyuruUrl(d.id)}" class="duyuru-item">
                    <img src="${esc(d.resim)}" alt="" class="duyuru-thumb" width="64" height="64">
                    <div class="duyuru-content">
                        <h4>${esc(d.baslik)}</h4>
                        <p>${esc(d.aciklama)}</p>
                    </div>
                </a>
            `).join('');
        }

        if (sayfaBilgi) {
            sayfaBilgi.textContent = `Sayfa ${duyuruPage} / ${totalPages}`;
        }
        if (duyuruPrev) {
            duyuruPrev.disabled = duyuruPage <= 1;
        }
        if (duyuruNext) {
            duyuruNext.disabled = duyuruPage >= totalPages;
        }
    }

    function onGalleryResize() {
        const { maxPage } = getGalleryMetrics();
        galleryPage = Math.min(galleryPage, maxPage);
        updateGalleryPosition();
        renderGalleryDots();
    }

    galleryPrev?.addEventListener('click', () => {
        if (galleryPage > 0) {
            galleryPage -= 1;
            updateGalleryPosition();
            renderGalleryDots();
        }
    });

    galleryNext?.addEventListener('click', () => {
        const { maxPage } = getGalleryMetrics();
        if (galleryPage < maxPage) {
            galleryPage += 1;
            updateGalleryPosition();
            renderGalleryDots();
        }
    });

    duyuruPrev?.addEventListener('click', () => {
        if (duyuruPage > 1) {
            duyuruPage -= 1;
            renderDuyurular();
        }
    });

    duyuruNext?.addEventListener('click', () => {
        const totalPages = Math.ceil(duyurular.length / DUYURU_PER_PAGE);
        if (duyuruPage < totalPages) {
            duyuruPage += 1;
            renderDuyurular();
        }
    });

    if (galleryWrapper && typeof ResizeObserver !== 'undefined') {
        const resizeObserver = new ResizeObserver(onGalleryResize);
        resizeObserver.observe(galleryWrapper);
    } else {
        window.addEventListener('resize', onGalleryResize);
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (haberler.length) {
            setMainHaber(0);
            renderGallery();
        }

        renderDuyurular();
    });
})();
