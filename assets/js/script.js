!(function () {
  var e = () => {
      const e = document.querySelector(".header-wrapper");
      let t = 0,
        r = 0;
      function s(t, r) {
        (e.classList.add(t), e.classList.remove(r));
      }
      window.innerWidth < 986 &&
        window.addEventListener("scroll", (c) => {
          let o = window.pageYOffset || document.documentElement.scrollTop;
          (25 == r &&
            (o > t
              ? s("animate__slideOutUp", "animate__slideInDown")
              : e.classList.contains("animate__slideOutUp") &&
                s("animate__slideInDown", "animate__slideOutUp"),
            (r = 0)),
            0 == o &&
              e.classList.contains("animate__slideOutUp") &&
              s("animate__slideInDown", "animate__slideOutUp"),
            r++,
            (t = o));
        });
    },
    t = () => {
      const e = document.querySelector(".steps__wrapper"),
        t = e.querySelectorAll(".steps__item"),
        r = e.querySelectorAll(".item-wrapper"),
        s = e.querySelectorAll(".item-wrapper_sec");
      t.forEach((e, t) => {
        e.addEventListener("click", () => {
          (r[t].classList.toggle("show"), s[t].classList.toggle("show"));
        });
      });
    },
    r = () => {
      const e = document.querySelector(".progress__line"),
        t = document.querySelector("body");
      window.addEventListener("scroll", () => {
        let r =
          (window.pageYOffset / (t.scrollHeight - window.innerHeight)) * 100;
        e.style.width = r + "%";
      });
    },
    s = () => {
      const e = document.querySelectorAll(".questions__quest"),
        t = document.querySelectorAll(".questions__ans"),
        r = document.querySelectorAll(".questions__x");
      e.forEach((e, s) => {
        e.addEventListener("click", () => {
          t[s].classList.contains("question__ans_slide")
            ? (t[s].classList.remove("question__ans_slide"),
              (t[s].style.height = 0),
              (t[s].style.borderTop = "none"),
              r[s].classList.remove("hide"))
            : ((t[s].style.height = t[s].scrollHeight + "px"),
              t[s].classList.add("question__ans_slide"),
              (t[s].style.borderTop = "1px solid black"),
              r[s].classList.add("hide"));
        });
      });
    },
    c = () => {
      const e = document.querySelector(".hamburger"),
        t = e.querySelectorAll(".hamburger__item"),
        r = document.querySelector(".menu-mobile"),
        s = document.querySelector(".nav__wrapper");
      (e.addEventListener("click", () => {
        r.classList.contains("menu-mobile_active")
          ? ((document.body.style = "overflow: auto;"),
            r.classList.remove("menu-mobile_active"),
            s.classList.remove("nav__wrapper_active"),
            t[1].classList.remove("hide"),
            t[0].classList.remove("hamburger__item_left"),
            t[2].classList.remove("hamburger__item_right"))
          : (r.classList.add("menu-mobile_active"),
            s.classList.add("nav__wrapper_active"),
            (document.body.style = "overflow: hidden;"),
            t[1].classList.add("hide"),
            t[0].classList.add("hamburger__item_left"),
            t[2].classList.add("hamburger__item_right"));
      }),
        s.addEventListener("click", (e) => {
          e.target.classList.contains("nav__wrapper_active") &&
            ((document.body.style = "overflow: auto;"),
            r.classList.remove("menu-mobile_active"),
            s.classList.remove("nav__wrapper_active"),
            t[1].classList.remove("hide"),
            t[0].classList.remove("hamburger__item_left"),
            t[2].classList.remove("hamburger__item_right"));
        }));
    },
    o = () => {
      const e = document.querySelector(".calculator__area_sum"),
        t = document.querySelectorAll(".btnEdit"),
        r = document.querySelector(".calculator__range"),
        s = document.querySelectorAll(".offer");
      if (!e || !r) return;
      const hero = e.closest(".promo-hero");
      const offersCount = document.querySelector(".catalog-panel__offers-count");
      const normalize = (value) => Math.min(Number(r.max), Math.max(Number(r.min), Math.round(Number(value) / Number(r.step)) * Number(r.step)));
      function c(e, t, updateOffersCount = true) {
        t = normalize(t);
        (e.forEach((e) => {
          e.value = t;
        }),
          o(t, updateOffersCount));
      }
      function o(e, updateOffersCount = true) {
        if (hero) {
          r.style.setProperty("--amount-progress", `${((Number(e) - Number(r.min)) / (Number(r.max) - Number(r.min))) * 100}%`);
          r.setAttribute("aria-valuetext", `${e} гривень`);
        }
        s.forEach((t) => {
          Number(t.getAttribute("data-max")) < Number(e) &&
          !t.classList.contains("hide")
            ? t.classList.add("hide")
            : Number(t.getAttribute("data-max")) >= Number(e) &&
              t.classList.contains("hide") &&
              t.classList.remove("hide");
        });
        if (offersCount && updateOffersCount) {
          offersCount.textContent = Array.from(s).filter((offer) => !offer.classList.contains("hide")).length;
        }
      }
      (e.addEventListener("input", (e) => {
        const t = e.target.value;
        c([r], t);
      }),
        r.addEventListener("input", (t) => {
          const r = t.target.value;
          ((e.value = r), o(r));
        }),
        t.forEach((t) => {
          t.addEventListener("click", (t) => {
            let s = Number(e.value) + Number(t.currentTarget.value);
            s > 0 && c([e, r], s);
          });
        }));
      e.addEventListener("change", () => c([e, r], e.value));
      if (hero) {
        c([e, r], e.value, false);
        hero.querySelectorAll('a[href^="#"]').forEach((link) => {
          link.addEventListener("click", (event) => {
            const target = document.querySelector(link.getAttribute("href"));
            if (!target || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
            event.preventDefault();
            const catalog = target.closest(".catalog");
            const isCatalogLink = link.classList.contains("promo-hero__submit") && catalog;
            const destination = isCatalogLink ? catalog : target;
            const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
            destination.scrollIntoView({ behavior: reduceMotion ? "auto" : "smooth", block: "start" });
          });
        });
      }
    },
    n = () => {
      const e = document.querySelectorAll(".offer__wrapper"),
        t = document.querySelectorAll(".offer__trigger"),
        r = "Детальніше",
        s = "Згорнути";
      t.forEach((t, c) => {
        t.addEventListener("click", () => {
          const o = e[c];
          o.classList.contains("offer__wrapper_active")
            ? (o.classList.remove("offer__wrapper_active"),
              (t.textContent = r),
              t.classList.remove("offer__trigger_down"))
            : (o.classList.add("offer__wrapper_active"),
              (t.textContent = s),
              t.classList.add("offer__trigger_down"));
        });
      });
    };
  /* Временно отключено: шапка не должна двигаться при прокрутке.
  try {
    e();
  } catch (e) {}
  */
  try {
    t();
  } catch (e) {}
  try {
    r();
  } catch (e) {}
  try {
    s();
  } catch (e) {}
  try {
    c();
  } catch (e) {}
  try {
    o();
  } catch (e) {}
  try {
    n();
  } catch (e) {}
})();
