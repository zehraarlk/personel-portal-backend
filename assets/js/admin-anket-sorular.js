/**
 * Dosya sorumluluğu: Admin anket soru oluşturucusunun istemci tarafı davranışları.
 *
 * Bu dosya yalnızca istemci tarafı etkileşimlerini yönetir; kalıcı
 * veri doğrulaması ve yetkilendirme sunucu tarafında yapılmalıdır.
 */
(function () {
  'use strict';

  function initAnketSorularBuilder() {
    var root = document.getElementById('anketSorularBuilder');
    if (!root || root.getAttribute('data-ready') === '1') return;
    root.setAttribute('data-ready', '1');

    var locked = root.getAttribute('data-locked') === '1';
    var maxSoru = parseInt(root.getAttribute('data-max-soru') || '10', 10) || 10;
    var list = document.getElementById('anketSorularList');
    var countSelect = document.getElementById('soruSayisi');
    var tpl = document.getElementById('anketSoruTemplate');
    var optTpl = document.getElementById('anketSecenekTemplate');

    if (!list || !countSelect || !tpl || !optTpl) return;

    function applyIndex(node, index) {
      node.querySelectorAll('[name]').forEach(function (el) {
        var name = el.getAttribute('name') || '';
        el.setAttribute(
          'name',
          name
            .replace(/__I__/g, String(index))
            .replace(/sorular\[\d+]/g, 'sorular[' + index + ']')
        );
      });
      var title = node.querySelector('[data-soru-title]');
      if (title) title.textContent = 'Soru ' + (index + 1);
    }

    function optionRow(index, value) {
      var frag = optTpl.content.cloneNode(true);
      applyIndex(frag, index);
      var input = frag.querySelector('input');
      if (input && value) input.value = value;
      return frag;
    }

    function syncTip(card) {
      var tipSelect = card.querySelector('[data-soru-tip]');
      var optsWrap = card.querySelector('[data-secenekler]');
      var optList = card.querySelector('[data-secenek-list]');
      var addBtn = card.querySelector('[data-add-secenek]');
      var isChoice = !tipSelect || tipSelect.value === 'coktan_secmeli';

      if (optsWrap) optsWrap.hidden = !isChoice;
      if (addBtn) addBtn.hidden = !isChoice || locked;

      if (isChoice && optList && optList.querySelectorAll('[data-secenek-row]').length < 2) {
        var idx = Array.prototype.indexOf.call(list.querySelectorAll('[data-soru-card]'), card);
        if (idx < 0) idx = 0;
        while (optList.querySelectorAll('[data-secenek-row]').length < 2) {
          optList.appendChild(optionRow(idx, ''));
        }
      }
    }

    function reindex() {
      var cards = list.querySelectorAll('[data-soru-card]');
      cards.forEach(function (card, index) {
        applyIndex(card, index);
        syncTip(card);
      });
      countSelect.value = String(Math.max(1, cards.length));
    }

    function ensureCount(n) {
      n = Math.max(1, Math.min(maxSoru, parseInt(n, 10) || 1));
      var cards = list.querySelectorAll('[data-soru-card]');

      while (cards.length > n) {
        cards[cards.length - 1].remove();
        cards = list.querySelectorAll('[data-soru-card]');
      }

      while (cards.length < n) {
        var frag = tpl.content.cloneNode(true);
        list.appendChild(frag);
        cards = list.querySelectorAll('[data-soru-card]');
      }

      reindex();
    }

    countSelect.addEventListener('change', function () {
      if (locked) {
        countSelect.value = String(list.querySelectorAll('[data-soru-card]').length || 1);
        return;
      }
      ensureCount(countSelect.value);
    });

    root.addEventListener('change', function (e) {
      var tip = e.target.closest('[data-soru-tip]');
      if (!tip || locked) return;
      var card = tip.closest('[data-soru-card]');
      if (card) syncTip(card);
    });

    root.addEventListener('click', function (e) {
      if (locked) return;

      var addBtn = e.target.closest('[data-add-secenek]');
      if (addBtn) {
        e.preventDefault();
        var card = addBtn.closest('[data-soru-card]');
        var optList = card && card.querySelector('[data-secenek-list]');
        if (!optList) return;
        var idx = Array.prototype.indexOf.call(list.querySelectorAll('[data-soru-card]'), card);
        optList.appendChild(optionRow(idx < 0 ? 0 : idx, ''));
        return;
      }

      var remBtn = e.target.closest('[data-remove-secenek]');
      if (remBtn) {
        e.preventDefault();
        var row = remBtn.closest('[data-secenek-row]');
        var optList2 = remBtn.closest('[data-secenek-list]');
        if (!row || !optList2) return;
        if (optList2.querySelectorAll('[data-secenek-row]').length <= 2) return;
        row.remove();
      }
    });

    if (!list.querySelector('[data-soru-card]')) {
      ensureCount(parseInt(countSelect.value, 10) || 1);
    } else {
      reindex();
    }

    if (locked) {
      root.querySelectorAll('button[data-add-secenek], button[data-remove-secenek]').forEach(function (btn) {
        btn.disabled = true;
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAnketSorularBuilder);
  } else {
    initAnketSorularBuilder();
  }
})();
