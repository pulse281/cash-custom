//old script webpack bundle
!(function (e) {
  var t = {};
  function r(s) {
    if (t[s]) return t[s].exports;
    var c = (t[s] = { i: s, l: !1, exports: {} });
    return (e[s].call(c.exports, c, c.exports, r), (c.l = !0), c.exports);
  }
  ((r.m = e),
    (r.c = t),
    (r.d = function (e, t, s) {
      r.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: s });
    }),
    (r.r = function (e) {
      ("undefined" != typeof Symbol &&
        Symbol.toStringTag &&
        Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }),
        Object.defineProperty(e, "__esModule", { value: !0 }));
    }),
    (r.t = function (e, t) {
      if ((1 & t && (e = r(e)), 8 & t)) return e;
      if (4 & t && "object" == typeof e && e && e.__esModule) return e;
      var s = Object.create(null);
      if (
        (r.r(s),
        Object.defineProperty(s, "default", { enumerable: !0, value: e }),
        2 & t && "string" != typeof e)
      )
        for (var c in e)
          r.d(
            s,
            c,
            function (t) {
              return e[t];
            }.bind(null, c),
          );
      return s;
    }),
    (r.n = function (e) {
      var t =
        e && e.__esModule
          ? function () {
              return e.default;
            }
          : function () {
              return e;
            };
      return (r.d(t, "a", t), t);
    }),
    (r.o = function (e, t) {
      return Object.prototype.hasOwnProperty.call(e, t);
    }),
    (r.p = ""),
    r((r.s = 0)));
})([
  function (e, t, r) {
    "use strict";
    r.r(t);
    var s = () => {
      const e = document.querySelector(".header-wrapper");
      parseInt(getComputedStyle(e).getPropertyValue("height"), 10);
      let t = 0,
        r = 0;
      function s(t, r, s) {
        (e.classList.add(t), e.classList.remove(r));
      }
      window.innerWidth < 986 &&
        window.addEventListener("scroll", (c) => {
          let o = window.pageYOffset || document.documentElement.scrollTop;
          (25 == r &&
            (o > t
              ? s("animate__slideOutUp", "animate__slideInDown", o)
              : e.classList.contains("animate__slideOutUp") &&
                s("animate__slideInDown", "animate__slideOutUp", o),
            (r = 0)),
            0 == o &&
              e.classList.contains("animate__slideOutUp") &&
              (s("animate__slideInDown", "animate__slideOutUp", o),
              console.log("scroll 0")),
            r++,
            (t = o));
        });
    };
    var c = () => {
      const e = document.querySelector(".steps__wrapper"),
        t = e.querySelectorAll(".steps__item"),
        r = e.querySelectorAll(".item-wrapper"),
        s = e.querySelectorAll(".item-wrapper_sec");
      t.forEach((e, t) => {
        e.addEventListener("click", (e) => {
          (r[t].classList.toggle("show"), s[t].classList.toggle("show"));
        });
      });
    };
    var o = () => {
      const e = document.querySelector(".progress__line"),
        t = document.querySelector("body");
      window.addEventListener("scroll", () => {
        let r =
          (window.pageYOffset / (t.scrollHeight - window.innerHeight)) * 100;
        e.style.width = r + "%";
      });
    };
    var n = () => {
      const e = document.querySelectorAll(".questions__quest"),
        t = document.querySelectorAll(".questions__ans"),
        r = document.querySelectorAll(".questions__x");
      e.forEach((e, s) => {
        e.addEventListener("click", (e) => {
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
    };
    var a = () => {
      const e = document.querySelector(".hamburger"),
        t = e.querySelectorAll(".hamburger__item"),
        r = document.querySelector(".menu-mobile"),
        s = document.querySelector(".nav__wrapper");
      (e.addEventListener("click", (e) => {
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
    };
    var l = () => {
      const e = document.querySelector(".calculator__area_sum"),
        t = document.querySelectorAll(".btnEdit"),
        r = document.querySelector(".calculator__range"),
        s = document.querySelectorAll(".offer");
      function c(e, t) {
        (e.forEach((e) => {
          e.value = t;
        }),
          o(t));
      }
      function o(e) {
        s.forEach((t) => {
          Number(t.getAttribute("data-max")) < Number(e) &&
          !t.classList.contains("hide")
            ? t.classList.add("hide")
            : Number(t.getAttribute("data-max")) >= Number(e) &&
              t.classList.contains("hide") &&
              t.classList.remove("hide");
        });
      }
      (e.addEventListener("input", (e) => {
        const t = e.target.value;
        e.target.value > 500 ? (c([r], t), o(t)) : (c(500), o(500));
      }),
        r.addEventListener("input", (t) => {
          const r = t.target.value;
          ((e.value = r), o(r));
        }),
        t.forEach((t) => {
          t.addEventListener("click", (t) => {
            let s = Number(e.value) + Number(t.target.value);
            s > 0 && c([e, r], s);
          });
        }));
    };
    var i = () => {
      const e = document.querySelector(".sidebar__message"),
        t =
          (document.querySelector(".sidebar__message-sec"),
          document.querySelector("#sidebar__message-close"));
      let r = !1;
      const s = () => {
        ((r = !0), e.classList.remove("sidebar__message_active"));
      };
      (e.classList.add("sidebar__message_active"),
        gtag("event", "sidebarMsg", {
          event_category: "sidebar",
          event_label: "sidebar_active",
        }),
        t.addEventListener("click", () => {
          s();
        }));
    };
    var d = () => {
      const e = Math.max(
          document.body.scrollHeight,
          document.documentElement.scrollHeight,
          document.body.offsetHeight,
          document.documentElement.offsetHeight,
          document.body.clientHeight,
          document.documentElement.clientHeight,
        ),
        t = document.documentElement,
        r = () => {
          (gtag("event", "scroll", {
            event_category: "first_scroll",
            event_label: "first_scroll",
          }),
            document.removeEventListener("scroll", r));
        };
      document.addEventListener("scroll", r);
      let s = 0,
        c = 0,
        o = 10;
      document.addEventListener("scroll", (r) => {
        t.scrollTop > s &&
          ((c = Math.round(((t.scrollTop + t.clientHeight) / e) * 100)),
          (s = t.scrollTop),
          c > o &&
            (gtag("event", "scroll", {
              event_category: "scroll_counter",
              event_label: o + "%",
            }),
            (o += 10)));
      });
      document
        .querySelector(".offer__trigger")
        .addEventListener("click", (e) => {
          const t = e.target.classList;
          (t.contains("btn_offer-request") &&
            (gtag("event", "click_personal", {
              event_category: "click_offer",
              event_label:
                date +
                "_" +
                e.target.closest(".offer").getAttribute("data-name"),
            }),
            ++conversionCount,
            !conversion && conversionCount > 2 && (i(), (conversion = !0))),
            t.contains("btn_show-offers") &&
              gtag("event", "click_personal", {
                event_category: "click_show_all",
                event_label: "show_all",
              }));
        });
      const n = document.querySelector(".calculator");
      n.addEventListener("click", (e) => {
        gtag("event", "click_calculator", {
          event_category: "click_calculator",
          event_label: e.target.classList.value,
        });
      });
      document.querySelector(".steps").addEventListener("click", (e) => {
        const t = e.target;
        (t.classList.contains("steps__item") || t.closest(".steps__item")) &&
          gtag("event", "click_steps", {
            event_category: "click_steps",
            event_label: t.id || t.closest(".steps__item").id,
          });
      });
      document.querySelector(".questions").addEventListener("click", (e) => {
        const t = e.target.closest(".questions__wrapper");
        t &&
          document.querySelectorAll(".questions__wrapper").forEach((e, r) => {
            t === e &&
              gtag("event", "click_questions", {
                event_category: "click_questions",
                event_label: ++r,
              });
          });
      });
      (document
        .querySelector("#sidebar__message-close")
        .addEventListener("click", (e) => {
          gtag("event", "close_sidebarMsg", {
            event_category: "sidebar",
            event_label: "close",
          });
        }),
        n.addEventListener("mouseenter", (e) => {
          gtag("event", "mouse", { event_category: "calc_transform" });
        }));
      document.querySelectorAll(".steps__item").forEach((e) => {
        e.addEventListener("mouseenter", (e) => {
          gtag("event", "mouse", {
            event_category: "steps_transform",
            event_label: e.target.id,
          });
        });
      });
    };
    var u = () => {
      const e = document.querySelector(".menu__item-lang"),
        t = document.querySelector(".choice-lang");
      (e.addEventListener("mouseover", (e) => {
        t.classList.remove("hide");
      }),
        e.addEventListener("mouseout", (e) => {
          t.classList.add("hide");
        }));
    };
    var _ = () => {
      document.querySelectorAll("a").forEach((e) => {
        e.href === document.location.href &&
          e.addEventListener("click", (e) => {
            e.preventDefault();
          });
      });
    };
    var m = () => {
      const e = document.querySelectorAll(".offer__wrapper"),
        t = document.querySelectorAll(".offer__trigger"),
        r = "Детальніше",
        s = "Згорнути";
      t.forEach((t, c) => {
        t.addEventListener("click", (o) => {
          const n = e[c];
          n.classList.contains("offer__wrapper_active")
            ? (n.classList.remove("offer__wrapper_active"),
              (t.textContent = r),
              t.classList.remove("offer__trigger_down"))
            : (n.classList.add("offer__wrapper_active"),
              (t.textContent = s),
              t.classList.add("offer__trigger_down"));
        });
      });
    };
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
    try {
      a();
    } catch (e) {}
    try {
      l();
    } catch (e) {}
    try {
      d();
    } catch (e) {}
    try {
      u();
    } catch (e) {}
    try {
      _();
    } catch (e) {}
    try {
      m();
    } catch (e) {}
  },
]);
