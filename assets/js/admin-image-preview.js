/**
 * Admin görsel alanları: mevcut resim + yeni dosya seçince canlı önizleme.
 * Markup: .admin-img-field > img[data-preview-img] + input[data-preview-input|data-preview-url]
 */
(function () {
  'use strict';

  function setPreview(img, emptyEl, src) {
    if (!img) return;
    var has = !!(src && String(src).trim());
    if (has) {
      img.src = src;
      img.hidden = false;
      if (emptyEl) emptyEl.hidden = true;
    } else {
      img.removeAttribute('src');
      img.hidden = true;
      if (emptyEl) emptyEl.hidden = false;
    }
  }

  function initField(field) {
    if (!field || field.getAttribute('data-ready') === '1') return;
    field.setAttribute('data-ready', '1');

    var img = field.querySelector('[data-preview-img]');
    var emptyEl = field.querySelector('[data-preview-empty]');
    var fileInput = field.querySelector('[data-preview-input]');
    var urlInput = field.querySelector('[data-preview-url]');
    var initial = (img && img.getAttribute('src')) || '';

    if (fileInput) {
      fileInput.addEventListener('change', function () {
        var file = fileInput.files && fileInput.files[0];
        if (!file) {
          setPreview(img, emptyEl, initial);
          return;
        }
        if (!file.type || file.type.indexOf('image/') !== 0) {
          setPreview(img, emptyEl, initial);
          return;
        }
        var reader = new FileReader();
        reader.onload = function () {
          setPreview(img, emptyEl, String(reader.result || ''));
        };
        reader.readAsDataURL(file);
      });
    }

    if (urlInput) {
      var syncUrl = function () {
        var v = (urlInput.value || '').trim();
        setPreview(img, emptyEl, v || initial);
      };
      urlInput.addEventListener('input', syncUrl);
      urlInput.addEventListener('change', syncUrl);
    }
  }

  function extractYoutubeId(value) {
    value = String(value || '').trim();
    if (!value) return '';
    if (/^[a-zA-Z0-9_-]{11}$/.test(value)) return value;
    var m = value.match(/(?:youtube\.com\/(?:watch\?.*v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/i);
    return m ? m[1] : '';
  }

  function initYoutubePreview() {
    document.querySelectorAll('[data-youtube-input]').forEach(function (input) {
      var field = input.closest('.admin-img-field');
      var img = null;
      var emptyEl = null;
      if (field) {
        img = field.querySelector('[data-youtube-thumb], [data-preview-img]');
        emptyEl = field.querySelector('[data-preview-empty]');
      }
      if (!img) {
        img = document.querySelector('[data-youtube-thumb]');
      }
      if (!img) return;

      var sync = function () {
        var id = extractYoutubeId(input.value);
        if (id) {
          setPreview(img, emptyEl, 'https://img.youtube.com/vi/' + id + '/hqdefault.jpg');
        }
      };
      input.addEventListener('input', sync);
      input.addEventListener('change', sync);
      sync();
    });
  }

  function initIconClassPreview() {
    var input = document.getElementById('ikon_sinifi');
    var wrap = document.getElementById('ikonCanliOnizleme');
    if (!input || !wrap) return;
    var iconEl = wrap.querySelector('i');
    if (!iconEl) {
      iconEl = document.createElement('i');
      wrap.appendChild(iconEl);
    }
    var sync = function () {
      iconEl.className = String(input.value || '').trim();
    };
    input.addEventListener('input', sync);
    input.addEventListener('change', sync);
    sync();
  }

  function initAll() {
    document.querySelectorAll('.admin-img-field').forEach(initField);
    initYoutubePreview();
    initIconClassPreview();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAll);
  } else {
    initAll();
  }
})();
