(function () {
    'use strict';

    const menuToggle = document.querySelector('[data-menu-toggle]');
    const sideMenu = document.querySelector('[data-side-menu]');
    const menuBackdrop = document.querySelector('[data-menu-backdrop]');
    const menuClose = document.querySelector('[data-menu-close]');
    const dropdownItems = document.querySelectorAll('[data-dropdown]');
    const profileDropdown = document.querySelector('[data-profile-dropdown]');

    let openDropdown = null;

    function openMobileMenu() {
        sideMenu?.classList.add('is-open');
        menuBackdrop?.classList.add('is-visible');
        menuToggle?.classList.add('is-active');
        menuToggle?.setAttribute('aria-expanded', 'true');
        menuToggle?.setAttribute('aria-label', 'Menüyü kapat');
        sideMenu?.setAttribute('aria-hidden', 'false');
        menuBackdrop?.setAttribute('aria-hidden', 'false');
        document.body.classList.add('menu-open');
    }

    function closeMobileMenu() {
        sideMenu?.classList.remove('is-open');
        menuBackdrop?.classList.remove('is-visible');
        menuToggle?.classList.remove('is-active');
        menuToggle?.setAttribute('aria-expanded', 'false');
        menuToggle?.setAttribute('aria-label', 'Menüyü aç');
        sideMenu?.setAttribute('aria-hidden', 'true');
        menuBackdrop?.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('menu-open');
    }

    function closeAllDropdowns() {
        dropdownItems.forEach((item) => {
            item.classList.remove('is-open');
            item.querySelector('.nav-link')?.setAttribute('aria-expanded', 'false');
        });
        profileDropdown?.classList.remove('is-open');
        profileDropdown?.querySelector('.profile-trigger')?.setAttribute('aria-expanded', 'false');
        openDropdown = null;
    }

    function alignDropdown(item) {
        const menu = item.querySelector('.nav-dropdown-menu');
        if (!menu) return;

        menu.classList.remove('align-left', 'align-right');
        const rect = menu.getBoundingClientRect();

        if (rect.right > window.innerWidth - 16) {
            menu.classList.add('align-right');
        } else if (rect.left < 16) {
            menu.classList.add('align-left');
        }
    }

    function toggleDropdown(item) {
        const isOpen = item.classList.contains('is-open');
        closeAllDropdowns();

        if (!isOpen) {
            item.classList.add('is-open');
            item.querySelector('.nav-link')?.setAttribute('aria-expanded', 'true');
            alignDropdown(item);
            openDropdown = item;
        }
    }

    menuToggle?.addEventListener('click', (e) => {
        e.stopPropagation();
        if (sideMenu?.classList.contains('is-open')) {
            closeMobileMenu();
        } else {
            closeAllDropdowns();
            openMobileMenu();
        }
    });

    menuClose?.addEventListener('click', closeMobileMenu);
    menuBackdrop?.addEventListener('click', closeMobileMenu);

    sideMenu?.addEventListener('click', (e) => e.stopPropagation());

    dropdownItems.forEach((item) => {
        item.querySelector('.nav-link')?.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown(item);
        });
    });

    profileDropdown?.querySelector('.profile-trigger')?.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = profileDropdown.classList.contains('is-open');
        closeAllDropdowns();
        if (!isOpen) {
            profileDropdown.classList.add('is-open');
            profileDropdown.querySelector('.profile-trigger')?.setAttribute('aria-expanded', 'true');
        }
    });

    document.addEventListener('click', () => {
        closeAllDropdowns();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllDropdowns();
            closeMobileMenu();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1100) {
            closeMobileMenu();
        }
        if (openDropdown) {
            alignDropdown(openDropdown);
        }
    });

    async function copyText(value) {
        if (navigator.clipboard?.writeText) {
            await navigator.clipboard.writeText(value);
            return;
        }

        const input = document.createElement('textarea');
        input.value = value;
        input.setAttribute('readonly', '');
        input.style.position = 'fixed';
        input.style.opacity = '0';
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        input.remove();
    }

    document.querySelectorAll('[data-copy]').forEach((el) => {
        el.addEventListener('click', async () => {
            const value = el.getAttribute('data-copy') || '';
            if (!value) {
                return;
            }

            try {
                await copyText(value);

                let toast = el.querySelector('.footer-copy-toast');
                if (!toast) {
                    toast = document.createElement('span');
                    toast.className = 'footer-copy-toast';
                    toast.setAttribute('role', 'status');
                    el.appendChild(toast);
                }

                toast.textContent = el.getAttribute('data-copy-success') || 'Kopyalandı';
                el.classList.add('is-copied');
                clearTimeout(el._copyTimer);
                el._copyTimer = setTimeout(() => {
                    el.classList.remove('is-copied');
                }, 1800);
            } catch (error) {
                window.alert('Kopyalama başarısız oldu.');
            }
        });
    });

})();