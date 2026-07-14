(function () {
    'use strict';

    const form = document.getElementById('resetForm');
    if (!form) {
        return;
    }

    const tcInput = document.getElementById('tcNo');
    const telInput = document.getElementById('telefon');
    const errorDiv = document.getElementById('phpError');
    const successDiv = document.getElementById('phpSuccess');
    const submitBtn = document.getElementById('resetSubmit');
    const resetUrl = form.dataset.resetUrl || 'sifre_unuttum.php';
    const defaultSubmitLabel = 'Şifre Sıfırla';

    function setFieldError(input, messageEl, show) {
        input.classList.toggle('is-invalid', show);
        if (messageEl) {
            messageEl.classList.toggle('is-visible', show);
        }
    }

    function hideAlerts() {
        errorDiv?.classList.remove('is-visible');
        successDiv?.classList.remove('is-visible');
    }

    function showError(message) {
        if (!errorDiv) {
            return;
        }
        errorDiv.textContent = message;
        errorDiv.classList.add('is-visible');
        successDiv?.classList.remove('is-visible');
    }

    function showSuccess(message) {
        if (!successDiv) {
            return;
        }
        successDiv.textContent = message;
        successDiv.classList.add('is-visible');
        errorDiv?.classList.remove('is-visible');
    }

    function setLoading(isLoading) {
        if (!submitBtn) {
            return;
        }

        submitBtn.disabled = isLoading;
        submitBtn.classList.toggle('is-loading', isLoading);
        submitBtn.innerHTML = isLoading
            ? '<span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg></span>İŞLENİYOR...'
            : defaultSubmitLabel;
    }

    [tcInput, telInput].forEach((input) => {
        input?.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });
    });

    form.addEventListener('submit', (event) => {
        event.preventDefault();
        hideAlerts();

        const tcNoError = document.getElementById('tcNoError');
        const telefonError = document.getElementById('telefonError');
        let isValid = true;

        const tcValue = tcInput.value.trim();
        const telValue = telInput.value.trim();

        if (tcValue.length !== 11) {
            setFieldError(tcInput, tcNoError, true);
            isValid = false;
        } else {
            setFieldError(tcInput, tcNoError, false);
        }

        if (telValue.length !== 11 || !telValue.startsWith('05')) {
            setFieldError(telInput, telefonError, true);
            isValid = false;
        } else {
            setFieldError(telInput, telefonError, false);
        }

        if (!isValid) {
            return;
        }

        setLoading(true);

        const formData = new FormData();
        formData.append('tc_no', tcValue);
        formData.append('telefon', telValue);

        fetch(resetUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
        })
            .then((response) => response.json())
            .then((data) => {
                setLoading(false);

                if (data.status === 'success') {
                    showSuccess(data.message || 'Şifreniz sıfırlandı.');
                    form.reset();
                    return;
                }

                showError(data.message || 'İşlem başarısız.');
            })
            .catch(() => {
                setLoading(false);
                showError('Sunucu bağlantı hatası oluştu.');
            });
    });
})();
