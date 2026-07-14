(function (global) {
    'use strict';

    function normalizeMode(mode) {
        return mode === 'contain' ? 'contain' : 'cover';
    }

    function getPhotoFitMode() {
        var attr = document.documentElement.getAttribute('data-photo-fit');
        return attr === 'contain' || attr === 'cover' ? attr : 'cover';
    }

    function syncPhotoFitUi(mode) {
        var current = normalizeMode(mode || getPhotoFitMode());

        document.querySelectorAll('[data-photo-fit-set]').forEach(function (button) {
            var value = normalizeMode(button.getAttribute('data-photo-fit-set'));
            var active = value === current;
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
            button.disabled = false;
        });
    }

    function setButtonsBusy(busy) {
        document.querySelectorAll('[data-photo-fit-set]').forEach(function (button) {
            button.disabled = !!busy;
        });
    }

    function setPhotoFitMode(mode) {
        var next = normalizeMode(mode);
        var previous = getPhotoFitMode();
        var root = document.documentElement;
        var saveUrl = root.getAttribute('data-photo-fit-save');
        var csrf = root.getAttribute('data-photo-fit-csrf');

        root.setAttribute('data-photo-fit', next);
        syncPhotoFitUi(next);

        if (!saveUrl || !csrf) {
            return Promise.resolve(next);
        }

        setButtonsBusy(true);

        var body = new URLSearchParams();
        body.set('csrf', csrf);
        body.set('mode', next);

        return fetch(saveUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                Accept: 'application/json',
            },
            body: body.toString(),
        })
            .then(function (response) {
                return response.json().then(function (data) {
                    if (!response.ok || !data || !data.ok) {
                        throw new Error((data && data.message) || 'Kayıt başarısız.');
                    }
                    var saved = normalizeMode(data.mode);
                    root.setAttribute('data-photo-fit', saved);
                    syncPhotoFitUi(saved);
                    return saved;
                });
            })
            .catch(function () {
                root.setAttribute('data-photo-fit', previous);
                syncPhotoFitUi(previous);
                window.alert('Fotoğraf görünümü kaydedilemedi.');
                return previous;
            })
            .finally(function () {
                setButtonsBusy(false);
            });
    }

    function initPhotoFitControls() {
        syncPhotoFitUi(getPhotoFitMode());

        document.querySelectorAll('[data-photo-fit-set]').forEach(function (button) {
            if (button.dataset.photoFitBound === '1') {
                return;
            }
            button.dataset.photoFitBound = '1';
            button.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                if (button.disabled || button.classList.contains('is-active')) {
                    return;
                }
                setPhotoFitMode(button.getAttribute('data-photo-fit-set'));
            });
        });
    }

    global.PortalPhotoFit = {
        get: getPhotoFitMode,
        set: setPhotoFitMode,
        sync: syncPhotoFitUi,
        init: initPhotoFitControls,
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPhotoFitControls);
    } else {
        initPhotoFitControls();
    }
})(window);
