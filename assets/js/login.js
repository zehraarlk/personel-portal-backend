(function () {
    'use strict';

    const form = document.getElementById('loginForm');
    if (!form) {
        return;
    }

    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const errorDiv = document.getElementById('phpError');
    const submitBtn = document.getElementById('loginSubmit');
    const togglePassword = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');
    const redirectUrl = form.dataset.redirect || 'ana_sayfa.php';
    const loginUrl = form.dataset.loginUrl || 'login.php';
    const defaultSubmitLabel = form.dataset.submitLabel || 'Giriş Yap';

    function setFieldError(input, messageEl, show) {
        input.classList.toggle('is-invalid', show);
        if (messageEl) {
            messageEl.classList.toggle('is-visible', show);
        }
    }

    function showServerError(message) {
        if (!errorDiv) {
            return;
        }
        errorDiv.textContent = message;
        errorDiv.classList.add('is-visible');
    }

    function hideServerError() {
        errorDiv?.classList.remove('is-visible');
    }

    function setLoading(isLoading) {
        if (!submitBtn) {
            return;
        }

        submitBtn.disabled = isLoading;
        submitBtn.classList.toggle('is-loading', isLoading);
        submitBtn.innerHTML = isLoading
            ? '<span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg></span>GİRİŞ YAPILIYOR...'
            : defaultSubmitLabel;
    }

    togglePassword?.addEventListener('click', () => {
        const isHidden = password.type === 'password';
        password.type = isHidden ? 'text' : 'password';
        togglePassword.setAttribute('aria-label', isHidden ? 'Şifreyi gizle' : 'Şifreyi göster');
        if (toggleIcon) {
            toggleIcon.innerHTML = isHidden
                ? '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>'
                : '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78 3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z"/></svg>';
        }
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        hideServerError();

        const usernameError = document.getElementById('usernameError');
        const passwordError = document.getElementById('passwordError');
        let isValid = true;

        if (username.value.trim() === '') {
            setFieldError(username, usernameError, true);
            isValid = false;
        } else {
            setFieldError(username, usernameError, false);
        }

        if (password.value.trim() === '') {
            setFieldError(password, passwordError, true);
            isValid = false;
        } else {
            setFieldError(password, passwordError, false);
        }

        if (!isValid) {
            return;
        }

        setLoading(true);

        const formData = new FormData(form);
        form.querySelectorAll('input[name]').forEach((input) => {
            if (input instanceof HTMLInputElement && input.type !== 'hidden') {
                formData.set(input.name, input.value.trim());
            }
        });

        fetch(loginUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    window.location.href = redirectUrl;
                    return;
                }

                showServerError(data.message || 'Giriş başarısız.');
                setLoading(false);
            })
            .catch(() => {
                showServerError('Sunucu bağlantı hatası oluştu.');
                setLoading(false);
            });
    });
})();
