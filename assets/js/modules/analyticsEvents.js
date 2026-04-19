import sidebarMessage from "./sidebarMessage.js";

const analyticsEvents = () => {
  //Scroll

  const pageHeight = Math.max(
      document.body.scrollHeight,
      document.documentElement.scrollHeight,
      document.body.offsetHeight,
      document.documentElement.offsetHeight,
      document.body.clientHeight,
      document.documentElement.clientHeight,
    ),
    doc = document.documentElement;

  const firstScroll = () => {
    gtag("event", "scroll", {
      event_category: "first_scroll",
      event_label: "first_scroll",
    });
    document.removeEventListener("scroll", firstScroll);
  };

  document.addEventListener("scroll", firstScroll);

  let scrollCounter = 0,
    scroll = 0,
    point = 10;

  document.addEventListener("scroll", (e) => {
    if (doc.scrollTop > scrollCounter) {
      scroll = Math.round(
        ((doc.scrollTop + doc.clientHeight) / pageHeight) * 100,
      );
      scrollCounter = doc.scrollTop;

      if (scroll > point) {
        gtag("event", "scroll", {
          event_category: "scroll_counter",
          event_label: `${point}%`,
        });
        point += 10;
      }
    }
  });

  //Click

  //catalog (offers) block

  const catalog = document.querySelector(".catalog");

  let conversion = false,
    conversionCount = 0;

  catalog.addEventListener("click", (e) => {
    const target = e.target.classList;

    if (target.contains("btn_offer-request")) {
      gtag("event", "click_personal", {
        event_category: "click_offer",
        event_label:
          date + "_" + e.target.closest(".offer").getAttribute("data-name"),
      });

      ++conversionCount;

      if (!conversion && conversionCount > 0) {
        sidebarMessage();
        conversion = true;
      }
    }

    // offers detail
    if (target.contains("offer__trigger")) {
      gtag("event", "click_offer_detail", {
        event_category: "click_offer_detail",
      });
    }

    // not work now
    if (target.contains("btn_show-offers")) {
      gtag("event", "click_personal", {
        event_category: "click_show_all",
        event_label: "show_all",
      });
    }
  });

  const offerDetail = document.querySelector(".offer__trigger");

  offerDetail.addEventListener("click", (e) => {
    const target = e.target.classList;

    if (target.contains("btn_offer-request")) {
      gtag("event", "click_personal", {
        event_category: "click_offer",
        event_label:
          date + "_" + e.target.closest(".offer").getAttribute("data-name"),
      });

      ++conversionCount;

      if (!conversion && conversionCount > 2) {
        sidebarMessage();
        conversion = true;
      }
    }

    if (target.contains("btn_show-offers")) {
      gtag("event", "click_personal", {
        event_category: "click_show_all",
        event_label: "show_all",
      });
    }
  });

  //calculator block

  const calculator = document.querySelector(".calculator");

  calculator.addEventListener("click", (e) => {
    gtag("event", "click_calculator", {
      event_category: "click_calculator",
      event_label: e.target.classList.value,
    });
  });

  const steps = document.querySelector(".steps");

  steps.addEventListener("click", (e) => {
    const target = e.target;
    if (
      target.classList.contains("steps__item") ||
      target.closest(".steps__item")
    ) {
      gtag("event", "click_steps", {
        event_category: "click_steps",
        event_label: target.id || target.closest(".steps__item").id,
      });
    }
  });

  //questions block
  const questions = document.querySelector(".questions");

  questions.addEventListener("click", (e) => {
    const target = e.target.closest(".questions__wrapper");
    if (target) {
      document.querySelectorAll(".questions__wrapper").forEach((item, i) => {
        if (target === item) {
          gtag("event", "click_questions", {
            event_category: "click_questions",
            event_label: ++i,
          });
        }
      });
    }
  });

  //sidebar message block

  const sidebarMsgClose = document.querySelector("#sidebar__message-close");

  sidebarMsgClose.addEventListener("click", (e) => {
    gtag("event", "close_sidebarMsg", {
      event_category: "sidebar",
      event_label: "close",
    });
  });

  //Mouse

  calculator.addEventListener("mouseenter", (e) => {
    //variable creat click event
    gtag("event", "mouse", {
      event_category: "calc_transform",
    });
  });

  const stepsItems = document.querySelectorAll(".steps__item");
  stepsItems.forEach((item) => {
    item.addEventListener("mouseenter", (e) => {
      gtag("event", "mouse", {
        event_category: "steps_transform",
        event_label: e.target.id,
      });
    });
  });
};
export default analyticsEvents;
