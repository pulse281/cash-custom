/* JS для стрілок (горизонтальний скрол літер) */

try {
  document.querySelector(".letter-next").addEventListener("click", function () {
    document.querySelector(".letters-scroll").scrollBy({
      left: 100,

      behavior: "smooth",
    });
  });

  document.querySelector(".letter-prev").addEventListener("click", function () {
    document.querySelector(".letters-scroll").scrollBy({
      left: -100,

      behavior: "smooth",
    });
  });
} catch (error) {}

const sidebarMessage = () => {
  const sideMessage = document.querySelector(".sidebar__message");

  const closeBtn = document.querySelector("#sidebar__message-close");

  // защита от ошибок

  if (!sideMessage || !closeBtn) return;

  // проверяем, был ли уже показан попап ранее

  if (localStorage.getItem("sidebarMessageShown")) return;

  // показать попап

  sideMessage.classList.add("sidebar__message_active");

  // закрытие по кнопке

  closeBtn.addEventListener("click", () => {
    sideMessage.classList.remove("sidebar__message_active");

    // ставим отметку, что попап был показан

    localStorage.setItem("sidebarMessageShown", "true");
  });
};

document.addEventListener("DOMContentLoaded", sidebarMessage);

const initOfferClickTracking = () => {
  const offerButtons = document.querySelectorAll(".btn_offer");

  if (!offerButtons.length) return;

  offerButtons.forEach((button) => {
    button.addEventListener("click", () => {
      if (typeof window.gtag !== "function") return;

      const eventLabel = button.dataset.eventLabel || "";

      window.gtag("event", "click_offer", {
        event_category: "offers",
        event_label: eventLabel,
      });

      window.gtag("event", "conversion", {
        send_to: "AW-838357114/VssxCOSJ3JEcEPqg4Y8D",
      });
    });
  });
};

document.addEventListener("DOMContentLoaded", initOfferClickTracking);

// Category Filtering Functionality

const initCategoryFilters = () => {
  const categoryButtons = document.querySelectorAll(".category-btn");

  const offers = Array.from(document.querySelectorAll(".offer"));
  const totalOffersCount = offers.length;

  const offersCounter = document.querySelectorAll(".offers-counter-text");

  const catalogSection = document.querySelector(".catalog");

  const batchSize = 5;

  if (!categoryButtons.length || !offers.length || !catalogSection) return;

  let activeCategory = "all";

  let visibleCount = 0;

  let scrollTicking = false;

  const orderFieldByCategory = {
    all: "orderDefault",
    "bez-vidsotkiv": "orderZeroPercent",
    top: "orderTop",
    "bez-dzvinkiv": "orderBezDzvinkiv",
    "pogana-ki": "orderPoganaKi",
    novi: "orderNovi",
  };

  const matchesCategory = (offer, category) => {
    if (category === "all") return true;

    const categories = (offer.dataset.categories || "")

      .split(",")

      .map((item) => item.trim())

      .filter(Boolean);

    return categories.includes(category);
  };

  const applyOffersOrder = (orderedOffers) => {
    const orderedSet = new Set(orderedOffers);
    let orderIndex = 0;

    orderedOffers.forEach((offer) => {
      offer.style.order = orderIndex;
      orderIndex += 1;
    });

    offers.forEach((offer) => {
      if (orderedSet.has(offer)) return;
      offer.style.order = orderIndex;
      orderIndex += 1;
    });
  };

  const getOfferOrderValue = (offer, category) => {
    const dataKey = orderFieldByCategory[category] || orderFieldByCategory.all;
    const rawValue = offer.dataset[dataKey];
    const parsed = Number(rawValue);
    return Number.isFinite(parsed) && parsed > 0 ? parsed : 999999;
  };

  const getMatchingOffers = () =>
    offers
      .filter((offer) => matchesCategory(offer, activeCategory))
      .sort(
        (a, b) =>
          getOfferOrderValue(a, activeCategory) -
          getOfferOrderValue(b, activeCategory),
      );

  const syncActiveCategoryButtons = (category) => {
    categoryButtons.forEach((btn) => {
      btn.classList.toggle("active", btn.dataset.category === category);
    });
  };

  const updateOffersCounter = (shown, total) => {
    if (!offersCounter || offersCounter.length === 0) return;
    offersCounter.forEach(
      (item) => (item.textContent = `Обрано ${shown} з ${total} МФО`),
    );
  };

  const applyCategoryVisibility = () => {
    offers.forEach((offer) => {
      offer.classList.toggle(
        "category-hidden",

        !matchesCategory(offer, activeCategory),
      );
    });
  };

  const showNextBatch = (reset = false, animate = false) => {
    const matchingOffers = getMatchingOffers();

    if (reset) {
      applyOffersOrder(matchingOffers);
    }

    const startIndex = reset ? 0 : visibleCount;

    if (reset) {
      visibleCount = 0;

      applyCategoryVisibility();

      matchingOffers.forEach((offer) => offer.classList.add("batch-hidden"));
    }

    const nextVisibleCount = Math.min(
      visibleCount + batchSize,

      matchingOffers.length,
    );

    for (let index = 0; index < nextVisibleCount; index++) {
      matchingOffers[index].classList.remove("batch-hidden");
    }

    if (animate) {
      for (let index = startIndex; index < nextVisibleCount; index++) {
        const offer = matchingOffers[index];

        offer.classList.remove("offer-stagger-in");

        offer.style.removeProperty("--offer-stagger-delay");

        void offer.offsetWidth;

        offer.style.setProperty(
          "--offer-stagger-delay",

          `${(index - startIndex) * 70}ms`,
        );

        offer.classList.add("offer-stagger-in");
      }
    }

    for (let index = nextVisibleCount; index < matchingOffers.length; index++) {
      const offer = matchingOffers[index];

      offer.classList.add("batch-hidden");

      offer.classList.remove("offer-stagger-in");

      offer.style.removeProperty("--offer-stagger-delay");
    }

    visibleCount = nextVisibleCount;

    updateOffersCounter(matchingOffers.length, totalOffersCount);

    return visibleCount < matchingOffers.length;
  };

  const handleCatalogScroll = () => {
    if (scrollTicking) return;

    scrollTicking = true;

    window.requestAnimationFrame(() => {
      const hasMore = visibleCount < getMatchingOffers().length;

      if (!hasMore) {
        scrollTicking = false;

        return;
      }

      const catalogRect = catalogSection.getBoundingClientRect();

      const reachedCatalogEnd = catalogRect.bottom <= window.innerHeight + 80;

      if (reachedCatalogEnd) {
        showNextBatch(false, false);
      }

      scrollTicking = false;
    });
  };

  categoryButtons.forEach((button) => {
    button.addEventListener("click", () => {
      activeCategory = button.dataset.category;
      const categoryLabel = (button.textContent || "").trim();

      if (typeof window.gtag === "function") {
        window.gtag("event", "offers_category_change", {
          event_category: "offers",
          event_label: categoryLabel,
          category_slug: activeCategory,
          category_name: categoryLabel,
        });
      }

      syncActiveCategoryButtons(activeCategory);

      showNextBatch(true, true);

      window.scrollTo({ top: 0, behavior: "smooth" });

      handleCatalogScroll();
    });
  });

  syncActiveCategoryButtons(activeCategory);

  showNextBatch(true, false);

  window.addEventListener("scroll", handleCatalogScroll, { passive: true });
};

document.addEventListener("DOMContentLoaded", initCategoryFilters);
