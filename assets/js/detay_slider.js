/**
 * Dosya sorumluluğu: Detay sayfası görsel galerisi davranışları.
 *
 * Bu dosya yalnızca istemci tarafı etkileşimlerini yönetir; kalıcı
 * veri doğrulaması ve yetkilendirme sunucu tarafında yapılmalıdır.
 */
(function () {
    'use strict';

    const track = document.getElementById('detailSidebarTrack');
    const prevBtn = document.getElementById('detailSidebarPrev');
    const nextBtn = document.getElementById('detailSidebarNext');
    const pageInfo = document.getElementById('detailSidebarPageInfo');

    if (!track) {
        return;
    }

    const pages = track.querySelectorAll('.detail-sidebar-page');
    const totalPages = pages.length;

    if (totalPages <= 1) {
        return;
    }

    let currentPage = 0;
    let autoTimer;

    function updateSlider() {
        track.style.transform = `translateX(-${currentPage * 100}%)`;

        if (prevBtn) {
            prevBtn.disabled = currentPage <= 0;
        }

        if (nextBtn) {
            nextBtn.disabled = currentPage >= totalPages - 1;
        }

        if (pageInfo) {
            pageInfo.textContent = `Sayfa ${currentPage + 1} / ${totalPages}`;
        }
    }

    function goToPage(index) {
        currentPage = Math.max(0, Math.min(index, totalPages - 1));
        updateSlider();
    }

    function startAutoSlide() {
        clearInterval(autoTimer);
        autoTimer = setInterval(() => {
            goToPage(currentPage >= totalPages - 1 ? 0 : currentPage + 1);
        }, 5000);
    }

    prevBtn?.addEventListener('click', () => {
        goToPage(currentPage - 1);
        startAutoSlide();
    });

    nextBtn?.addEventListener('click', () => {
        goToPage(currentPage + 1);
        startAutoSlide();
    });

    track.closest('[data-detail-slider]')?.addEventListener('mouseenter', () => {
        clearInterval(autoTimer);
    });

    track.closest('[data-detail-slider]')?.addEventListener('mouseleave', startAutoSlide);

    updateSlider();
    startAutoSlide();
})();
