        <!--
          Dosya sorumluluğu: Yönetim panelinin içerik alanını kapatır,
          ortak JavaScript dosyalarını yükler ve mobil sidebar ile oturum
          yaşam döngüsü davranışlarını başlatır.
        -->
        </main>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>assets/js/photo-fit.js"></script>
    <script src="<?= htmlspecialchars($assetBase, ENT_QUOTES, 'UTF-8') ?>assets/js/admin-image-preview.js?v=<?= (int) @filemtime(
      __DIR__ . '/../../../assets/js/admin-image-preview.js',
    ) ?>"></script>
    <script>
      (function () {
        var sidebar = document.getElementById("adminSidebar");
        var toggle = document.getElementById("adminMenuToggle");
        var closeBtn = document.getElementById("adminSidebarClose");
        var backdrop = document.getElementById("adminSidebarBackdrop");
        if (!sidebar || !toggle) return;

        function setMenuOpen(open) {
          sidebar.classList.toggle("open", open);
          if (backdrop) {
            backdrop.classList.toggle("show", open);
            backdrop.setAttribute("aria-hidden", open ? "false" : "true");
          }
          document.body.classList.toggle("admin-sidebar-open", open);
          toggle.setAttribute("aria-expanded", open ? "true" : "false");
          toggle.setAttribute("aria-label", open ? "Menüyü kapat" : "Menüyü aç");
        }

        toggle.addEventListener("click", function (e) {
          e.preventDefault();
          e.stopPropagation();
          setMenuOpen(!sidebar.classList.contains("open"));
        });

        if (closeBtn) {
          closeBtn.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            setMenuOpen(false);
          });
        }

        if (backdrop) {
          backdrop.addEventListener("click", function () {
            setMenuOpen(false);
          });
        }

        sidebar.querySelectorAll("a[href]").forEach(function (link) {
          link.addEventListener("click", function () {
            setMenuOpen(false);
          });
        });

        document.addEventListener("keydown", function (e) {
          if (e.key === "Escape" && sidebar.classList.contains("open")) {
            setMenuOpen(false);
          }
        });

        window.addEventListener("resize", function () {
          if (window.innerWidth > 992 && sidebar.classList.contains("open")) {
            setMenuOpen(false);
          }
        });
      })();
    </script>
    <script>
    (function () {
      if (window.__ppAdminSessionGuard) return;
      window.__ppAdminSessionGuard = true;

      var endpoint = <?= json_encode($adminOturumKapatUrl, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
      var NAV_KEY = "pp_admin_internal_nav";
      var NAV_TTL_MS = 8000;
      var sent = false;

      function markInternalNav() {
        try { sessionStorage.setItem(NAV_KEY, String(Date.now())); } catch (e1) {}
      }

      function isInternalNav() {
        try {
          var raw = sessionStorage.getItem(NAV_KEY);
          if (!raw) return false;
          var ts = parseInt(raw, 10);
          if (!ts || isNaN(ts)) return raw === "1";
          return (Date.now() - ts) < NAV_TTL_MS;
        } catch (e2) {
          return false;
        }
      }

      function markReloadIfNeeded() {
        try {
          var nav = performance.getEntriesByType("navigation")[0];
          if (nav && nav.type === "reload") {
            markInternalNav();
          }
        } catch (e3) {}
      }

      markReloadIfNeeded();
      window.addEventListener("pageshow", function (e) {
        if (e.persisted) markInternalNav();
        markReloadIfNeeded();
      });

      function sameOriginHref(href) {
        if (!href || href.charAt(0) === "#" || href.indexOf("javascript:") === 0) return false;
        try {
          var url = new URL(href, window.location.href);
          return url.origin === window.location.origin;
        } catch (e3) {
          return href.indexOf("http") !== 0;
        }
      }

      function onPossibleNav(e) {
        var a = e.target && e.target.closest ? e.target.closest("a[href]") : null;
        if (!a) return;
        if (a.target && a.target !== "" && a.target !== "_self") return;
        if (sameOriginHref(a.getAttribute("href") || a.href || "")) {
          markInternalNav();
        }
      }

      document.addEventListener("mousedown", onPossibleNav, true);
      document.addEventListener("touchstart", onPossibleNav, true);
      document.addEventListener("click", onPossibleNav, true);
      document.addEventListener("submit", function () { markInternalNav(); }, true);
      window.addEventListener("keydown", function (e) {
        if (e.key === "F5" || ((e.ctrlKey || e.metaKey) && (e.key === "r" || e.key === "R"))) {
          markInternalNav();
        }
      });

      function closeSession() {
        if (sent || isInternalNav()) return;
        sent = true;
        try {
          if (navigator.sendBeacon) {
            navigator.sendBeacon(endpoint, new Blob(["1"], { type: "text/plain" }));
            return;
          }
        } catch (e4) {}
        try {
          fetch(endpoint, { method: "POST", keepalive: true, credentials: "same-origin", cache: "no-store" });
        } catch (e5) {}
      }

      window.addEventListener("pagehide", function (e) {
        if (e.persisted || isInternalNav()) return;
        closeSession();
      });
    })();
    </script>
  </body>
</html>
