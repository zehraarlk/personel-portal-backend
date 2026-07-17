/**
 * Dosya sorumluluğu: Etkinlik arama, durum filtresi ve sayfalama davranışları.
 *
 * Bu dosya yalnızca istemci tarafı etkileşimlerini yönetir; kalıcı
 * veri doğrulaması ve yetkilendirme sunucu tarafında yapılmalıdır.
 */
(function () {
  "use strict";

  const newsData = window.newsData || [];
  const detailBase = window.etDetailBase || "etkinlik_detay.php?id=";
  const ITEMS_PER_PAGE = 8;

  let filteredData = [...newsData];
  let currentPage = 1;
  let sortType = "newest";
  let statusFilter = "all";

  const searchInput = document.getElementById("searchInput");
  const searchBtn = document.getElementById("searchBtn");
  const sortSelect = document.getElementById("sortSelect");
  const newsGrid = document.getElementById("newsGrid");
  const resultsCount = document.getElementById("resultsCount");
  const noResults = document.getElementById("noResults");
  const pagination = document.getElementById("pagination");
  const resultsHeader = document.querySelector(".et-results-header");
  const filterTabs = document.querySelectorAll(".et-filter-tab");

  function esc(text) {
    const el = document.createElement("div");
    el.textContent = text ?? "";
    return el.innerHTML;
  }

  function debounce(fn, wait) {
    let timeout;
    return function debounced(...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => fn.apply(this, args), wait);
    };
  }

  function applyFilters() {
    const query = (searchInput?.value || "").trim().toLowerCase();

    filteredData = newsData.filter((item) => {
      const status = item.status || "aktif";
      if (statusFilter !== "all" && status !== statusFilter) {
        return false;
      }

      if (query === "") {
        return true;
      }

      return (
        item.title.toLowerCase().includes(query) ||
        item.excerpt.toLowerCase().includes(query)
      );
    });
  }

  function applySort() {
    const items = [...filteredData];

    switch (sortType) {
      case "oldest":
        items.sort((a, b) =>
          a.dateSort < b.dateSort ? -1 : a.dateSort > b.dateSort ? 1 : 0,
        );
        break;
      case "most-viewed":
        items.sort((a, b) => b.views - a.views);
        break;
      case "alphabetical":
        items.sort((a, b) => a.title.localeCompare(b.title, "tr"));
        break;
      case "newest":
      default:
        items.sort((a, b) =>
          a.dateSort < b.dateSort ? 1 : a.dateSort > b.dateSort ? -1 : 0,
        );
        break;
    }

    filteredData = items;
  }

  function updateResultsCount() {
    if (!resultsCount) {
      return;
    }

    resultsCount.innerHTML = `<strong>${filteredData.length}</strong> sonuç bulundu`;
  }

  function scrollToResults() {
    resultsHeader?.scrollIntoView({ behavior: "smooth", block: "start" });
  }

  function renderPagination(totalItems) {
    if (!pagination) {
      return;
    }

    const totalPages = Math.max(1, Math.ceil(totalItems / ITEMS_PER_PAGE));
    currentPage = Math.min(currentPage, totalPages);

    if (totalPages <= 1) {
      pagination.innerHTML = "";
      pagination.hidden = true;
      return;
    }

    pagination.hidden = false;
    let html = `<button type="button" data-page="${currentPage - 1}" aria-label="Önceki sayfa"${currentPage <= 1 ? " disabled" : ""}>‹</button>`;

    for (let i = 1; i <= totalPages; i += 1) {
      html += `<button type="button" data-page="${i}" class="${i === currentPage ? "is-active" : ""}" aria-label="Sayfa ${i}"${i === currentPage ? ' aria-current="page"' : ""}>${i}</button>`;
    }

    html += `<button type="button" data-page="${currentPage + 1}" aria-label="Sonraki sayfa"${currentPage >= totalPages ? " disabled" : ""}>›</button>`;
    pagination.innerHTML = html;
  }

  function openDetail(id) {
    if (!id) {
      return;
    }

    window.location.href = `${detailBase}${encodeURIComponent(id)}`;
  }

  function renderNews() {
    if (!newsGrid) {
      return;
    }

    applySort();

    const start = (currentPage - 1) * ITEMS_PER_PAGE;
    const pageItems = filteredData.slice(start, start + ITEMS_PER_PAGE);

    if (pageItems.length === 0) {
      newsGrid.innerHTML = "";
      if (noResults) {
        noResults.hidden = false;
      }
    } else {
      if (noResults) {
        noResults.hidden = true;
      }

      newsGrid.innerHTML = pageItems
        .map(
          (item) => `
                <article class="news-card" data-id="${item.id}" data-status="${esc(item.status || "aktif")}" tabindex="0" role="link" aria-label="${esc(item.title)}">
                    <div class="news-image-wrap">
                        <img src="${esc(item.image)}" alt="${esc(item.title)}" class="news-image" loading="lazy">
                    </div>
                    <div class="news-content">
                        <span class="et-status ${esc(item.statusClass || "is-active")}">${esc(item.statusLabel || "Aktif")}</span>
                        <h3 class="news-title">${esc(item.title)}</h3>
                        <p class="news-excerpt">${esc(item.excerpt)}</p>
                        <div class="news-meta">
                            <span class="news-date">
                                <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zM5 8V6h14v2H5z"/></svg></span>
                                ${esc(item.date)}
                            </span>
                            <span class="news-views">
                                <span class="icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></span>
                                ${item.views}
                            </span>
                        </div>
                    </div>
                </article>
            `,
        )
        .join("");
    }

    updateResultsCount();
    renderPagination(filteredData.length);
  }

  function handleSearch() {
    applyFilters();
    currentPage = 1;
    renderNews();
  }

  function handleSortChange() {
    sortType = sortSelect?.value || "newest";
    currentPage = 1;
    renderNews();
  }

  function handleStatusFilter(event) {
    const tab = event.target.closest(".et-filter-tab");
    if (!tab) {
      return;
    }

    statusFilter = tab.dataset.status || "all";
    filterTabs.forEach((btn) => {
      const active = btn === tab;
      btn.classList.toggle("is-active", active);
      btn.setAttribute("aria-selected", active ? "true" : "false");
    });

    applyFilters();
    currentPage = 1;
    renderNews();
  }

  searchInput?.addEventListener("input", debounce(handleSearch, 300));
  searchBtn?.addEventListener("click", handleSearch);
  searchInput?.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
      event.preventDefault();
      handleSearch();
    }
  });

  sortSelect?.addEventListener("change", handleSortChange);
  document
    .querySelector(".et-filter-tabs")
    ?.addEventListener("click", handleStatusFilter);

  newsGrid?.addEventListener("click", (event) => {
    const card = event.target.closest(".news-card");
    if (!card) {
      return;
    }

    openDetail(card.dataset.id);
  });

  newsGrid?.addEventListener("keydown", (event) => {
    if (event.key !== "Enter" && event.key !== " ") {
      return;
    }

    const card = event.target.closest(".news-card");
    if (!card) {
      return;
    }

    event.preventDefault();
    openDetail(card.dataset.id);
  });

  pagination?.addEventListener("click", (event) => {
    const button = event.target.closest("button[data-page]");
    if (!button || button.disabled) {
      return;
    }

    const page = Number(button.dataset.page);
    if (!Number.isFinite(page) || page < 1) {
      return;
    }

    currentPage = page;
    renderNews();
    scrollToResults();
  });

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", renderNews);
  } else {
    renderNews();
  }
})();
