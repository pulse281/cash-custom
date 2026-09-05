/* JS для стрілок (горизонтальний скрол літер) */

const initLettersScroll = () => {
  const nextButton = document.querySelector(".letter-next");
  const prevButton = document.querySelector(".letter-prev");
  const lettersScroll = document.querySelector(".letters-scroll");

  if (!nextButton || !prevButton || !lettersScroll) return;

  nextButton.addEventListener("click", () => {
    lettersScroll.scrollBy({
      left: 100,
      behavior: "smooth",
    });
  });

  prevButton.addEventListener("click", () => {
    lettersScroll.scrollBy({
      left: -100,
      behavior: "smooth",
    });
  });
};

document.addEventListener("DOMContentLoaded", initLettersScroll);

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

  const promoId = Date.now().toString();

  offerButtons.forEach((button) => {
    const baseUrl = button.dataset.baseUrl;
    if (!baseUrl) return;

    const campaign = button.dataset.campaign || "";

    const url = new URL(baseUrl);
    url.searchParams.set("source", "ck");
    url.searchParams.set("promo", promoId);

    if (campaign) {
      url.searchParams.set("campaign", campaign);
    }

    button.href = url.toString();

    button.addEventListener("click", () => {
      if (typeof window.gtag !== "function") return;

      window.gtag("event", "click_offer", {
        event_category: "offers",
        event_label: promoId,
      });
    });
  });
};

document.addEventListener("DOMContentLoaded", initOfferClickTracking);

const sendGa4Event = (eventName, params) => {
  if (typeof window.gtag !== "function") return;

  window.gtag("event", eventName, params);
};

const getPromoAnalyticsState = () => {
  const amountInput = document.querySelector(".promo-hero .calculator__area_sum");
  const visibleOffers = Array.from(document.querySelectorAll(".offer")).filter(
    (offer) => !offer.classList.contains("hide"),
  ).length;

  return {
    loan_amount: amountInput ? Number(amountInput.value) : 0,
    visible_offers: visibleOffers,
  };
};

const initPromoAnalytics = () => {
  const promo = document.querySelector(".promo-hero");

  if (!promo) return;

  const selectOffers = promo.querySelector(".promo-hero__submit");
  const helpLink = promo.querySelector(".promo-hero__help");
  const amountInput = promo.querySelector(".calculator__area_sum");
  const rangeInput = promo.querySelector(".calculator__range");
  const calculatorButtons = promo.querySelectorAll(".btnEdit");
  const showAllLink = document.querySelector(".catalog-panel__heading a");

  if (selectOffers) {
    selectOffers.addEventListener("click", () => {
      sendGa4Event("click_promo_select", {
        event_category: "promo",
        event_label: "select_offers",
        ...getPromoAnalyticsState(),
      });
    });
  }

  if (helpLink) {
    helpLink.addEventListener("click", () => {
      sendGa4Event("click_promo_help", {
        event_category: "promo",
        event_label: "how_it_works",
      });
    });
  }

  calculatorButtons.forEach((button) => {
    button.addEventListener("click", () => {
      sendGa4Event("change_calculator", {
        event_category: "calculator",
        event_label: Number(button.value) > 0 ? "increase" : "decrease",
        ...getPromoAnalyticsState(),
      });
    });
  });

  if (amountInput) {
    amountInput.addEventListener("change", () => {
      sendGa4Event("change_calculator", {
        event_category: "calculator",
        event_label: "input",
        ...getPromoAnalyticsState(),
      });
    });
  }

  if (rangeInput) {
    rangeInput.addEventListener("change", () => {
      sendGa4Event("change_calculator", {
        event_category: "calculator",
        event_label: "range",
        ...getPromoAnalyticsState(),
      });
    });
  }

  if (showAllLink) {
    showAllLink.addEventListener("click", () => {
      sendGa4Event("click_show_all", {
        event_category: "catalog",
        event_label: "all_mfo",
      });
    });
  }
};

document.addEventListener("DOMContentLoaded", initPromoAnalytics);
