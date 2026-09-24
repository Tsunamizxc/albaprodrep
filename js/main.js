(() => {
  const doc = document;
  const body = doc.body;
  const KEY = "alba-city";

  const CITIES = [
    { id: "omsk", name: "Омск", prep: "в Омске", phone: "8 800 100-12-12", tel: "+78001001212", address: "Омск, ул. Ленина, 12", extra: "Отдельный вход. Трансфер по городу и области.", license: "ЛО-55-01-002891", map: "https://yandex.ru/map-widget/v1/?ll=73.368227%2C54.989342&z=16&text=%D0%9E%D0%BC%D1%81%D0%BA%2C%20%D1%83%D0%BB.%20%D0%9B%D0%B5%D0%BD%D0%B8%D0%BD%D0%B0%2C%2012" },
    { id: "nsk", name: "Новосибирск", prep: "в Новосибирске", phone: "8 800 100-12-12", tel: "+78001001212", address: "Новосибирск, Красный проспект, 52", extra: "Отдельный вход, закрытая парковка.", license: "ЛО-54-01-005412", map: "https://yandex.ru/map-widget/v1/?ll=82.920430%2C55.030204&z=16&text=%D0%9D%D0%BE%D0%B2%D0%BE%D1%81%D0%B8%D0%B1%D0%B8%D1%80%D1%81%D0%BA%2C%20%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D1%8B%D0%B9%20%D0%BF%D1%80%D0%BE%D1%81%D0%BF%D0%B5%D0%BA%D1%82%2C%2052" },
    { id: "tomsk", name: "Томск", prep: "в Томске", phone: "8 800 100-12-12", tel: "+78001001212", address: "Томск, пр. Ленина, 54", extra: "Тихий двор, трансфер по городу.", license: "ЛО-70-01-001904", map: "https://yandex.ru/map-widget/v1/?ll=84.948227%2C56.484640&z=16&text=%D0%A2%D0%BE%D0%BC%D1%81%D0%BA%2C%20%D0%BF%D1%80%D0%BE%D1%81%D0%BF%D0%B5%D0%BA%D1%82%20%D0%9B%D0%B5%D0%BD%D0%B8%D0%BD%D0%B0%2C%2054" },
    { id: "tyumen", name: "Тюмень", prep: "в Тюмени", phone: "8 800 100-12-12", tel: "+78001001212", address: "Тюмень, ул. Республики, 83", extra: "Центр, анонимный подъезд.", license: "ЛО-72-01-003215", map: "https://yandex.ru/map-widget/v1/?ll=65.534328%2C57.152974&z=16&text=%D0%A2%D1%8E%D0%BC%D0%B5%D0%BD%D1%8C%2C%20%D1%83%D0%BB%D0%B8%D1%86%D0%B0%20%D0%A0%D0%B5%D1%81%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B8%2C%2083" },
    { id: "barnaul", name: "Барнаул", prep: "в Барнауле", phone: "8 800 100-12-12", tel: "+78001001212", address: "Барнаул, пр. Ленина, 24", extra: "Отдельный вход со двора.", license: "ЛО-22-01-004118", map: "https://yandex.ru/map-widget/v1/?ll=83.779861%2C53.347847&z=16&text=%D0%91%D0%B0%D1%80%D0%BD%D0%B0%D1%83%D0%BB%2C%20%D0%BF%D1%80%D0%BE%D1%81%D0%BF%D0%B5%D0%BA%D1%82%20%D0%9B%D0%B5%D0%BD%D0%B8%D0%BD%D0%B0%2C%2024" },
    { id: "kemerovo", name: "Кемерово", prep: "в Кемерове", phone: "8 800 100-12-12", tel: "+78001001212", address: "Кемерово, пр. Советский, 54", extra: "Стационар 24/7, трансфер.", license: "ЛО-42-01-002671", map: "https://yandex.ru/map-widget/v1/?ll=86.087314%2C55.354968&z=16&text=%D0%9A%D0%B5%D0%BC%D0%B5%D1%80%D0%BE%D0%B2%D0%BE%2C%20%D0%A1%D0%BE%D0%B2%D0%B5%D1%82%D1%81%D0%BA%D0%B8%D0%B9%20%D0%BF%D1%80%D0%BE%D1%81%D0%BF%D0%B5%D0%BA%D1%82%2C%2054" },
    { id: "nkz", name: "Новокузнецк", prep: "в Новокузнецке", phone: "8 800 100-12-12", tel: "+78001001212", address: "Новокузнецк, пр. Металлургов, 19", extra: "Закрытая территория.", license: "ЛО-42-01-002688", map: "https://yandex.ru/map-widget/v1/?ll=87.136047%2C53.757547&z=16&text=%D0%9D%D0%BE%D0%B2%D0%BE%D0%BA%D1%83%D0%B7%D0%BD%D0%B5%D1%86%D0%BA%2C%20%D0%9C%D0%B5%D1%82%D0%B0%D0%BB%D0%BB%D1%83%D1%80%D0%B3%D0%BE%D0%B2%2C%2019" },
    { id: "krsk", name: "Красноярск", prep: "в Красноярске", phone: "8 800 100-12-12", tel: "+78001001212", address: "Красноярск, ул. Карла Маркса, 78", extra: "Центр, анонимный въезд.", license: "ЛО-24-01-003901", map: "https://yandex.ru/map-widget/v1/?ll=92.852576%2C56.010569&z=16&text=%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D1%8F%D1%80%D1%81%D0%BA%2C%20%D0%9A%D0%B0%D1%80%D0%BB%D0%B0%20%D0%9C%D0%B0%D1%80%D0%BA%D1%81%D0%B0%2C%2078" },
    { id: "surgut", name: "Сургут", prep: "в Сургуте", phone: "8 800 100-12-12", tel: "+78001001212", address: "Сургут, ул. Энтузиастов, 8", extra: "Круглосуточный приём.", license: "ЛО-86-01-001744", map: "https://yandex.ru/map-widget/v1/?ll=73.396713%2C61.254035&z=16&text=%D0%A1%D1%83%D1%80%D0%B3%D1%83%D1%82%2C%20%D0%AD%D0%BD%D1%82%D1%83%D0%B7%D0%B8%D0%B0%D1%81%D1%82%D0%BE%D0%B2%2C%208" },
    { id: "moscow", name: "Москва", prep: "в Москве", phone: "8 800 100-12-12", tel: "+78001001212", address: "Москва, Пресненская наб., 10с2", extra: "Внутренний двор, закрытая парковка.", license: "ЛО-77-01-021458", map: "https://yandex.ru/map-widget/v1/?ll=37.539139%2C55.747231&z=16&text=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%9F%D1%80%D0%B5%D1%81%D0%BD%D0%B5%D0%BD%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BD%D0%B0%D0%B1%D0%B5%D1%80%D0%B5%D0%B6%D0%BD%D0%B0%D1%8F%2C%2010" },
    { id: "spb", name: "Санкт-Петербург", prep: "в Санкт-Петербурге", phone: "8 800 100-12-12", tel: "+78001001212", address: "Санкт-Петербург, Невский пр., 88", extra: "Отдельный вход со двора.", license: "ЛО-78-01-011203", map: "https://yandex.ru/map-widget/v1/?ll=30.360909%2C59.931058&z=16&text=%D0%A1%D0%B0%D0%BD%D0%BA%D1%82-%D0%9F%D0%B5%D1%82%D0%B5%D1%80%D0%B1%D1%83%D1%80%D0%B3%2C%20%D0%9D%D0%B5%D0%B2%D1%81%D0%BA%D0%B8%D0%B9%20%D0%BF%D1%80%D0%BE%D1%81%D0%BF%D0%B5%D0%BA%D1%82%2C%2088" }
  ];

  const byId = Object.fromEntries(CITIES.map((c) => [c.id, c]));

  let scrollLockDepth = 0;
  const lockScroll = () => {
    if (scrollLockDepth === 0) {
      const gap = Math.max(0, window.innerWidth - doc.documentElement.clientWidth);
      doc.documentElement.style.setProperty("--lock-gap", gap + "px");
      doc.documentElement.classList.add("is-lock");
      body.classList.add("is-lock");
    }
    scrollLockDepth += 1;
  };
  const unlockScroll = () => {
    scrollLockDepth = Math.max(0, scrollLockDepth - 1);
    if (scrollLockDepth > 0) return;
    doc.documentElement.classList.remove("is-lock");
    body.classList.remove("is-lock");
    doc.documentElement.style.removeProperty("--lock-gap");
  };

  const applyCity = (city) => {
    if (!city) return;
    try { localStorage.setItem(KEY, city.id || city.slug); } catch (e) {}
    const tel = (city.tel || "+78001001212").replace(/\s+/g, "");
    const phone = city.phone || "8 800 100-12-12";
    doc.querySelectorAll("[data-city-name]").forEach((n) => { n.textContent = city.name; });
    doc.querySelectorAll("[data-city-prep]").forEach((n) => { n.textContent = city.prep; });
    doc.querySelectorAll("[data-city-phone]").forEach((n) => { n.textContent = phone; });
    doc.querySelectorAll("[data-city-address]").forEach((n) => { n.textContent = city.address; });
    doc.querySelectorAll("[data-city-extra]").forEach((n) => { n.textContent = city.extra; });
    doc.querySelectorAll("[data-city-license]").forEach((n) => { n.textContent = city.license; });
    doc.querySelectorAll("[data-city-tel]").forEach((a) => { a.setAttribute("href", "tel:" + tel); });
    const digits = tel.replace(/\D/g, "");
    doc.querySelectorAll("[data-city-max]").forEach((a) => { a.setAttribute("href", city.max || "https://max.ru/"); });
    doc.querySelectorAll("[data-city-tg]").forEach((a) => { a.setAttribute("href", city.tg || ("https://t.me/+" + digits)); });
    const map = doc.querySelector("[data-city-map]");
    if (map && city.map) map.src = city.map;
  };

  const geo = () => {
    const header = doc.querySelector(".header__bar");
    if (header && !doc.querySelector(".city-btn")) {
      const btn = doc.createElement("button");
      btn.type = "button";
      btn.className = "city-btn";
      btn.setAttribute("data-open-city", "");
      btn.innerHTML = '<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 18s6-5.2 6-10a6 6 0 1 0-12 0c0 4.8 6 10 6 10Z" stroke="currentColor" stroke-width="1.6"/><circle cx="10" cy="8" r="2.1" stroke="currentColor" stroke-width="1.6"/></svg><span data-city-name>Омск</span>';
      const logo = header.querySelector(".logo");
      if (logo && logo.nextSibling) header.insertBefore(btn, logo.nextSibling);
      else header.appendChild(btn);
    }

    const mnav = doc.querySelector("[data-mnav]");
    if (mnav) {
      if (!mnav.querySelector("[data-mnav-contact]")) {
        mnav.insertAdjacentHTML("afterbegin",
          '<div class="mnav-contact" data-mnav-contact>' +
            '<a class="mnav-contact__phone" href="tel:+78001001212">8 800 100-12-12</a>' +
            '<span class="mnav-contact__hint">Бесплатно по России</span>' +
            '<p class="mnav-contact__addr">Контакт-центр: ул. Ленина, 12</p>' +
          "</div>");
      } else {
        const contact = mnav.querySelector("[data-mnav-contact]");
        if (contact && mnav.firstElementChild !== contact) mnav.insertBefore(contact, mnav.firstChild);
      }
      // Keep only page links in burger: strip service/extra/messenger/city entries
      mnav.querySelectorAll("[data-extra-mnav]").forEach((n) => n.remove());
      mnav.querySelectorAll("a[data-city-max], a[data-city-tg]").forEach((n) => n.remove());
      mnav.querySelectorAll('a[href^="service-"]').forEach((n) => n.remove());
      mnav.querySelectorAll(".city-btn, [data-open-city]").forEach((n) => n.remove());
    }

    const wrap = doc.createElement("div");
    wrap.className = "geo";
    wrap.setAttribute("data-geo", "");
    wrap.innerHTML = '<div class="geo__box" role="dialog" aria-modal="true" aria-labelledby="geo-title">' +
      '<div class="geo__ask" data-geo-ask>' +
      '<h2 id="geo-title">Вы из Омска?</h2>' +
      '<p>Покажем телефон, адрес и условия вашей клиники.</p>' +
      '<div class="geo__actions">' +
      '<button type="button" class="btn btn--blue" data-geo-yes>Да, я из Омска</button>' +
      '<button type="button" class="btn btn--line" data-geo-other>Выбрать другой город</button>' +
      '</div></div>' +
      '<div class="geo__pick" data-geo-pick hidden>' +
      '<h2>Выберите город</h2>' +
      '<p>Работаем в Сибири и принимаем пациентов из других регионов.</p>' +
      '<input class="geo__search" type="search" placeholder="Найти город" data-geo-search>' +
      '<div class="geo__grid" data-geo-grid></div>' +
      '<button type="button" class="geo__back" data-geo-back>Назад</button>' +
      '</div></div>';
    body.appendChild(wrap);

    const ask = wrap.querySelector("[data-geo-ask]");
    const pick = wrap.querySelector("[data-geo-pick]");
    const grid = wrap.querySelector("[data-geo-grid]");
    const search = wrap.querySelector("[data-geo-search]");

    const renderGrid = (q) => {
      const query = (q || "").trim().toLowerCase();
      grid.innerHTML = CITIES.filter((c) => !query || c.name.toLowerCase().includes(query)).map((c) =>
        '<button type="button" class="geo__city" data-city-id="' + c.id + '">' + c.name + "</button>"
      ).join("") || '<p>Город не найден. Оставьте Омск или позвоните нам.</p>';
    };
    renderGrid("");

    const openGeo = (mode) => {
      if (!wrap.classList.contains("is-open")) lockScroll();
      wrap.classList.add("is-open");
      if (mode === "pick") {
        ask.hidden = true;
        pick.hidden = false;
      } else {
        ask.hidden = false;
        pick.hidden = true;
      }
    };
    const closeGeo = () => {
      if (!wrap.classList.contains("is-open")) return;
      wrap.classList.remove("is-open");
      unlockScroll();
    };
    const choose = (city) => {
      applyCity(city);
      closeGeo();
    };

    wrap.querySelector("[data-geo-yes]").addEventListener("click", () => choose(byId.omsk));
    wrap.querySelector("[data-geo-other]").addEventListener("click", () => {
      ask.hidden = true;
      pick.hidden = false;
      search.focus();
    });
    wrap.querySelector("[data-geo-back]").addEventListener("click", () => {
      pick.hidden = true;
      ask.hidden = false;
    });
    grid.addEventListener("click", (e) => {
      const b = e.target.closest("[data-city-id]");
      if (b) choose(byId[b.getAttribute("data-city-id")]);
    });
    search.addEventListener("input", () => renderGrid(search.value));
    wrap.addEventListener("click", (e) => {
      if (e.target === wrap && localStorage.getItem(KEY)) closeGeo();
    });
    doc.addEventListener("click", (e) => {
      if (e.target.closest("[data-open-city]")) {
        e.preventDefault();
        openGeo("pick");
      }
    });

    let saved = null;
    try { saved = localStorage.getItem(KEY); } catch (e) {}
    if (saved && byId[saved]) applyCity(byId[saved]);
    else setTimeout(() => openGeo("ask"), 1100);
  };

  const preload = () => {
    const el = doc.querySelector(".preloader");
    if (!el) return;
    let finished = false;
    const done = () => {
      if (finished) return;
      finished = true;
      el.classList.add("is-done");
      body.classList.remove("is-lock");
      doc.querySelectorAll(".split").forEach((n, i) => {
        setTimeout(() => n.classList.add("is-in"), 40 + i * 50);
      });
      doc.querySelectorAll(".hero [data-reveal]").forEach((n, i) => {
        setTimeout(() => n.classList.add("is-in"), 120 + i * 70);
      });
    };
    body.classList.add("is-lock");
    window.addEventListener("load", () => setTimeout(done, 200));
    setTimeout(done, 900);
  };

  const splitHeadings = () => {
    doc.querySelectorAll(".split").forEach((el) => {
      if (el.querySelector("[data-city-license], [data-city-prep]")) return;
      const html = el.innerHTML.trim();
      const parts = html.split(/<br\s*\/?>/i);
      el.innerHTML = parts.map((line) =>
        line.trim().split(/\s+/).map((w) => "<span><em>" + w + "&nbsp;</em></span>").join("")
      ).join("<br>");
    });
  };

  const tilt = () => {
    if (matchMedia("(pointer: coarse)").matches) return;
    if (matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    doc.querySelectorAll("[data-tilt]").forEach((card) => {
      let raf = 0;
      let lastX = 0;
      let lastY = 0;
      card.addEventListener("mousemove", (e) => {
        lastX = e.clientX;
        lastY = e.clientY;
        if (raf) return;
        raf = requestAnimationFrame(() => {
          raf = 0;
          const r = card.getBoundingClientRect();
          const px = (lastX - r.left) / r.width;
          const py = (lastY - r.top) / r.height;
          card.style.transform = "perspective(800px) rotateX(" + ((0.5 - py) * 5) + "deg) rotateY(" + ((px - 0.5) * 6) + "deg) translateY(-3px)";
        });
      }, { passive: true });
      card.addEventListener("mouseleave", () => {
        if (raf) cancelAnimationFrame(raf);
        raf = 0;
        card.style.transform = "";
      });
    });
  };

  const header = () => {
    const el = doc.querySelector("[data-header]");
    if (!el) return;
    let ticking = false;
    const onScroll = () => {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(() => {
        el.classList.toggle("is-scrolled", scrollY > 8);
        ticking = false;
      });
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  };

  const mobileNav = () => {
    const burger = doc.querySelector("[data-burger]");
    const nav = doc.querySelector("[data-mnav]");
    if (!burger || !nav) return;
    const close = () => {
      burger.classList.remove("is-open");
      nav.classList.remove("is-open");
      unlockScroll();
    };
    burger.addEventListener("click", () => {
      const willOpen = !burger.classList.contains("is-open");
      burger.classList.toggle("is-open", willOpen);
      nav.classList.toggle("is-open", willOpen);
      if (willOpen) lockScroll();
      else unlockScroll();
    });
    nav.querySelectorAll("a").forEach((a) => a.addEventListener("click", close));
  };

  const reveals = () => {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((en) => {
        if (!en.isIntersecting) return;
        const delay = Number(en.target.dataset.delay || 0);
        setTimeout(() => en.target.classList.add("is-in"), delay);
        io.unobserve(en.target);
      });
    }, { threshold: 0.14, rootMargin: "0px 0px -6% 0px" });
    doc.querySelectorAll("[data-reveal]").forEach((n) => io.observe(n));
  };

  const counters = () => {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((en) => {
        if (!en.isIntersecting) return;
        const el = en.target;
        const to = parseFloat(el.dataset.count);
        const dec = String(to).includes(".") ? 1 : 0;
        const t0 = performance.now();
        const tick = (now) => {
          const p = Math.min(1, (now - t0) / 1200);
          const val = to * (1 - Math.pow(1 - p, 3));
          el.textContent = dec ? val.toFixed(1) : Math.round(val).toLocaleString("ru-RU");
          if (p < 1) requestAnimationFrame(tick);
        };
        requestAnimationFrame(tick);
        io.unobserve(el);
      });
    });
    doc.querySelectorAll("[data-count]").forEach((n) => io.observe(n));
  };

  const accordion = () => {
    doc.querySelectorAll("[data-acc]").forEach((root) => {
      root.querySelectorAll(".acc__item").forEach((item) => {
        item.querySelector(".acc__btn").addEventListener("click", () => {
          const open = item.classList.contains("is-open");
          root.querySelectorAll(".acc__item").forEach((i) => i.classList.remove("is-open"));
          if (!open) item.classList.add("is-open");
        });
      });
    });
  };

  const modal = () => {
    const el = doc.querySelector("[data-modal]");
    if (!el) return;
    const box = el.querySelector(".modal__box");
    const open = () => {
      if (el.classList.contains("is-open")) return;
      el.classList.add("is-open");
      lockScroll();
    };
    const close = () => {
      if (!el.classList.contains("is-open")) return;
      el.classList.remove("is-open");
      unlockScroll();
    };
    doc.querySelectorAll("[data-open-modal]").forEach((b) => b.addEventListener("click", (e) => {
      e.preventDefault();
      open();
    }));
    el.addEventListener("click", (e) => { if (e.target === el) close(); });
    el.querySelectorAll("[data-close-modal]").forEach((b) => b.addEventListener("click", close));
    doc.addEventListener("keydown", (e) => { if (e.key === "Escape") close(); });
    if (box) box.addEventListener("click", (e) => e.stopPropagation());
  };

  const forms = () => {
    doc.addEventListener("submit", (e) => {
      const form = e.target && e.target.closest && e.target.closest("form[data-form]");
      if (!form || form.closest("[data-calc-form]") || form.closest("[data-exit-form]")) return;
      e.preventDefault();
      const wrap = form.closest(".form") || form;
      wrap.classList.add("is-sent");
    });
  };

  const dirsNav = () => {
    const root = doc.querySelector("[data-dirs]");
    if (!root) return;
    const drops = [...root.querySelectorAll("[data-dirs-drop]")];
    if (!drops.length) return;
    const fine = window.matchMedia("(hover: hover) and (pointer: fine)");
    const mobile = window.matchMedia("(max-width: 720px)");

    const pinBar = () => {
      if (mobile.matches) {
        root.classList.remove("is-stuck");
        return;
      }
      const headerH = parseFloat(getComputedStyle(doc.documentElement).getPropertyValue("--header-h")) || 84;
      const top = root.getBoundingClientRect().top;
      root.classList.toggle("is-stuck", top <= headerH + 1);
    };

    pinBar();
    window.addEventListener("scroll", pinBar, { passive: true });
    window.addEventListener("resize", pinBar);

    const closeAll = (except) => {
      drops.forEach((drop) => {
        if (except && drop === except) return;
        drop.classList.remove("is-open");
        const btn = drop.querySelector("[data-dirs-btn]");
        const menu = drop.querySelector("[data-dirs-menu]");
        if (btn) btn.setAttribute("aria-expanded", "false");
        if (menu) menu.hidden = true;
      });
    };

    const open = (drop) => {
      closeAll(drop);
      drop.classList.add("is-open");
      const btn = drop.querySelector("[data-dirs-btn]");
      const menu = drop.querySelector("[data-dirs-menu]");
      if (btn) btn.setAttribute("aria-expanded", "true");
      if (menu) menu.hidden = false;
    };

    const close = (drop) => {
      drop.classList.remove("is-open");
      const btn = drop.querySelector("[data-dirs-btn]");
      const menu = drop.querySelector("[data-dirs-menu]");
      if (btn) btn.setAttribute("aria-expanded", "false");
      if (menu) menu.hidden = true;
    };

    drops.forEach((drop) => {
      const btn = drop.querySelector("[data-dirs-btn]");
      const menu = drop.querySelector("[data-dirs-menu]");
      if (!btn || !menu) return;

      btn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (drop.classList.contains("is-open")) close(drop);
        else open(drop);
      });

      if (fine.matches) {
        let leaveTimer = 0;
        const cancelLeave = () => window.clearTimeout(leaveTimer);
        const scheduleLeave = () => {
          cancelLeave();
          leaveTimer = window.setTimeout(() => close(drop), 160);
        };
        drop.addEventListener("mouseenter", () => { cancelLeave(); open(drop); });
        drop.addEventListener("mouseleave", scheduleLeave);
        menu.addEventListener("mouseenter", cancelLeave);
      }
    });

    doc.addEventListener("click", (e) => {
      if (e.target.closest("[data-dirs-drop]")) return;
      closeAll();
    });
    doc.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeAll();
    });
  };

  const offerDirs = () => {
    const cards = [...doc.querySelectorAll("[data-offer]")];
    if (!cards.length) return;
    const fine = window.matchMedia("(hover: hover) and (pointer: fine)");
    const mobile = window.matchMedia("(max-width: 720px)");
    let openCard = null;
    let scrollLocked = false;

    const setMobileScrollLock = (on) => {
      if (on) {
        if (scrollLocked) return;
        lockScroll();
        scrollLocked = true;
        return;
      }
      if (!scrollLocked) return;
      unlockScroll();
      scrollLocked = false;
    };

    const getPanel = (card) => {
      const group = card.getAttribute("data-offer-group") || "";
      return card.querySelector("[data-offer-panel]") ||
        doc.querySelector('[data-offer-panel][data-owner="' + group + '"]');
    };

    const enhanceHead = (panel) => {
      const strong = panel.querySelector(".offer-dirs__head strong");
      if (!strong || strong.querySelector("small")) return;
      const note = doc.createElement("small");
      note.textContent = "Подберите подходящий формат помощи";
      strong.appendChild(note);
    };

    const place = (card) => {
      const btn = card.querySelector("[data-offer-dirs]");
      const panel = getPanel(card);
      const shell = panel && panel.querySelector(".offer-dirs__panel");
      const list = panel && panel.querySelector(".offer-dirs__list");
      if (!btn || !panel || !shell) return;

      enhanceHead(panel);
      if (panel.parentElement !== doc.body) doc.body.appendChild(panel);

      panel.hidden = false;
      panel.classList.add("is-open");
      panel.classList.remove("is-below", "is-above");

      if (mobile.matches) {
        panel.style.cssText = "position:fixed;inset:0;width:auto;height:100%;min-height:100dvh;z-index:220;";
        if (list) {
          list.style.maxHeight = "none";
          list.style.overflowY = "auto";
          list.style.webkitOverflowScrolling = "touch";
        }
        setMobileScrollLock(true);
        return;
      }

      setMobileScrollLock(false);

      const gap = 12;
      const pad = 12;
      const br = btn.getBoundingClientRect();
      const pw = Math.min(400, window.innerWidth - pad * 2);

      panel.style.position = "fixed";
      panel.style.zIndex = "120";
      panel.style.width = pw + "px";
      panel.style.height = "auto";
      panel.style.minHeight = "";
      panel.style.left = "0";
      panel.style.top = "0";
      panel.style.right = "auto";
      panel.style.bottom = "auto";
      panel.style.inset = "auto";
      if (list) list.style.maxHeight = "min(52vh, 400px)";

      const ph = shell.getBoundingClientRect().height || 300;
      const spaceBelow = window.innerHeight - br.bottom - pad;
      const spaceAbove = br.top - pad;
      const need = Math.min(ph + gap, 420);
      const preferBelow = spaceBelow >= need || spaceBelow >= spaceAbove;

      let left = br.right - pw;
      left = Math.min(Math.max(pad, left), window.innerWidth - pw - pad);

      let top;
      if (preferBelow) {
        panel.classList.add("is-below");
        top = br.bottom + gap;
        const maxH = Math.max(180, window.innerHeight - top - pad);
        if (list && ph > maxH) list.style.maxHeight = Math.max(120, maxH - 72) + "px";
      } else {
        panel.classList.add("is-above");
        const maxH = Math.max(180, spaceAbove - gap);
        if (list && ph > maxH) list.style.maxHeight = Math.max(120, maxH - 72) + "px";
        const h2 = shell.getBoundingClientRect().height || Math.min(ph, maxH);
        top = br.top - h2 - gap;
      }

      top = Math.max(pad, Math.min(top, window.innerHeight - 80));
      panel.style.left = left + "px";
      panel.style.top = top + "px";
    };

    const closeCard = (card) => {
      card.classList.remove("is-dirs-open");
      const btn = card.querySelector("[data-offer-dirs]");
      if (btn) btn.setAttribute("aria-expanded", "false");
      const panel = getPanel(card);
      if (panel) {
        panel.hidden = true;
        panel.classList.remove("is-open", "is-below", "is-above");
        panel.style.cssText = "";
        const list = panel.querySelector(".offer-dirs__list");
        if (list) {
          list.style.maxHeight = "";
          list.style.overflowY = "";
          list.style.webkitOverflowScrolling = "";
        }
        if (panel.parentElement !== card) card.appendChild(panel);
      }
      if (openCard === card) openCard = null;
      if (!openCard) setMobileScrollLock(false);
    };

    const closeAll = (except) => {
      cards.forEach((card) => {
        if (except && card === except) return;
        closeCard(card);
      });
      if (!except) setMobileScrollLock(false);
    };

    const open = (card) => {
      closeAll(card);
      const panel = getPanel(card);
      if (!panel) return;
      panel.setAttribute("data-owner", card.getAttribute("data-offer-group") || "");
      card.classList.add("is-dirs-open");
      const btn = card.querySelector("[data-offer-dirs]");
      if (btn) btn.setAttribute("aria-expanded", "true");
      openCard = card;
      place(card);
    };

    cards.forEach((card) => {
      const btn = card.querySelector("[data-offer-dirs]");
      const panel = card.querySelector("[data-offer-panel]");
      if (!btn || !panel) return;
      panel.setAttribute("data-owner", card.getAttribute("data-offer-group") || "");

      btn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (card.classList.contains("is-dirs-open")) closeCard(card);
        else open(card);
      });

      panel.querySelectorAll("[data-offer-dirs-close]").forEach((c) => {
        c.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
          closeCard(card);
        });
      });

      panel.addEventListener("click", (e) => {
        if (e.target === panel && mobile.matches) closeCard(card);
      });

      if (fine.matches) {
        let leaveTimer = 0;
        const cancelLeave = () => window.clearTimeout(leaveTimer);
        const scheduleLeave = () => {
          cancelLeave();
          leaveTimer = window.setTimeout(() => closeCard(card), 200);
        };
        btn.addEventListener("mouseenter", () => { cancelLeave(); open(card); });
        panel.addEventListener("mouseenter", cancelLeave);
        panel.addEventListener("mouseleave", scheduleLeave);
        card.addEventListener("mouseleave", (e) => {
          const next = e.relatedTarget;
          if (next && (btn.contains(next) || panel.contains(next))) return;
          scheduleLeave();
        });
      }
    });

    doc.addEventListener("click", (e) => {
      if (e.target.closest("[data-offer-dirs], [data-offer-panel]")) return;
      closeAll();
    });
    doc.addEventListener("keydown", (e) => {
      if (e.key === "Escape") closeAll();
    });
    window.addEventListener("resize", () => { if (openCard) place(openCard); });
    window.addEventListener("scroll", () => { if (openCard) place(openCard); }, { passive: true });
  };

  const year = () => {
    doc.querySelectorAll("[data-year]").forEach((n) => {
      n.textContent = String(new Date().getFullYear());
    });
  };

  const marquee = () => {
    const root = doc.querySelector(".marquee");
    const track = root && root.querySelector(".marquee__track");
    const source = track && track.querySelector(".marquee__group");
    if (!root || !track || !source) return;
    const original = source.innerHTML;

    const build = () => {
      source.innerHTML = original;
      const minW = Math.max(root.clientWidth, 1);
      let guard = 0;
      while (source.scrollWidth < minW && guard < 12) {
        source.insertAdjacentHTML("beforeend", original);
        guard += 1;
        if (!source.scrollWidth) break;
      }
      const live = doc.querySelector(".footer [data-city-license]");
      if (live) {
        source.querySelectorAll("[data-city-license]").forEach((n) => {
          n.textContent = live.textContent;
        });
      }
      track.querySelectorAll(".marquee__group").forEach((g, i) => {
        if (i) g.remove();
      });
      track.appendChild(source.cloneNode(true));
      const dist = source.offsetWidth || minW;
      track.style.setProperty("--marquee-duration", Math.max(18, dist / 42).toFixed(1) + "s");
      track.style.animation = "none";
      void track.offsetWidth;
      track.style.animation = "";
    };

    const start = () => build();
    if (doc.fonts && doc.fonts.ready) doc.fonts.ready.then(start);
    else start();
    let timer = 0;
    window.addEventListener("resize", () => {
      window.clearTimeout(timer);
      timer = window.setTimeout(build, 160);
    });
  };

  const cookies = () => {
    try { if (localStorage.getItem("alba-cookie")) return; } catch (e) {}
    const bar = doc.createElement("div");
    bar.className = "cookie";
    bar.innerHTML = "<p>Сайт запоминает выбранный город и использует cookie. К страницам может быть подключена аналитика. Подробнее — в <a href=\"privacy.html\">политике ПДн</a> и <a href=\"consent.html\">согласии</a>.</p><button type=\"button\" class=\"btn btn--blue\">Понятно</button>";
    body.appendChild(bar);
    bar.querySelector("button").addEventListener("click", () => {
      try { localStorage.setItem("alba-cookie", "1"); } catch (e) {}
      bar.remove();
    });
  };

  const catalogNav = () => {
    const drops = [...doc.querySelectorAll(".nav__drop")];
    const clinic = drops.find((d) => d.querySelector(".nav__btn")?.textContent.includes("Клиника"));
    const programs = drops.find((d) => d.querySelector(".nav__btn")?.textContent.includes("Программы"));
    if (clinic) {
      const menu = clinic.querySelector(".nav__menu");
      if (menu && !menu.querySelector("[data-extra-clinic]")) {
        menu.insertAdjacentHTML("beforeend",
          '<a data-extra-clinic href="reviews.html">Отзывы</a>' +
          '<a data-extra-clinic href="methods.html">Методы помощи</a>' +
          '<a data-extra-clinic href="sitemap.html">Карта сайта</a>');
      }
    }
    if (programs) {
      const menu = programs.querySelector(".nav__menu");
      if (menu && !menu.classList.contains("nav__mega")) {
        menu.classList.add("nav__mega");
        menu.innerHTML =
          '<div class="nav__col"><b>Срочно</b>' +
          '<a href="service-zapoy.html">Запой и капельница</a>' +
          '<a href="service-visit.html">Выезд нарколога</a>' +
          '<a href="service-ambulance.html">Наркологическая скорая</a>' +
          '<a href="service-withdrawal.html">Снятие ломки</a>' +
          '<a href="service-ubod.html">УБОД</a></div>' +
          '<div class="nav__col"><b>Лечение</b>' +
          '<a href="service-alcohol.html">Алкоголизм</a>' +
          '<a href="service-drugs.html">Наркомания</a>' +
          '<a href="service-gambling.html">Игровая зависимость</a>' +
          '<a href="service-code.html">Кодирование</a>' +
          '<a href="service-rehab.html">Реабилитация</a></div>' +
          '<div class="nav__col"><b>Клиника</b>' +
          '<a href="service-detox.html">Детокс 24/7</a>' +
          '<a href="service-psychiatry.html">Психиатрия</a>' +
          '<a href="service-psy-therapist.html">Психотерапия</a>' +
          '<a href="service-consult.html">Консультация</a>' +
          '<a href="service-check.html">Диагностика</a>' +
          '<a href="service-family.html">Семья</a></div>' +
          '<div class="nav__col"><b>Ещё</b>' +
          '<a href="service-help.html">Наркологическая помощь</a>' +
          '<a href="service-rehab.html">Реабилитация</a>' +
          '<a href="methods.html">Методы</a>' +
          '<a href="prices.html">Цены</a>' +
          '<a href="programs.html" class="nav__catalog">Весь каталог</a></div>';
        menu.querySelectorAll('a[href="programs.html"]').forEach((a) => a.classList.add("nav__catalog"));
      }
    }

    const mnav = doc.querySelector("[data-mnav]");
    if (mnav) {
      mnav.querySelectorAll("[data-extra-mnav]").forEach((n) => n.remove());
      mnav.querySelectorAll("a[data-city-max], a[data-city-tg]").forEach((n) => n.remove());
      mnav.querySelectorAll('a[href^="service-"]').forEach((n) => n.remove());
      const pageLinks = [
        ["reviews.html", "Отзывы"],
        ["methods.html", "Методы"],
        ["sitemap.html", "Карта сайта"]
      ];
      pageLinks.forEach(([h, t]) => {
        if ([...mnav.querySelectorAll("a")].some((a) => a.getAttribute("href") === h)) return;
        const a = doc.createElement("a");
        a.href = h;
        a.textContent = t;
        a.setAttribute("data-extra-mnav", "");
        const contacts = [...mnav.querySelectorAll("a")].find((x) => x.getAttribute("href") === "contacts.html");
        if (contacts) contacts.before(a);
        else mnav.appendChild(a);
      });
    }

    const foot = doc.querySelector(".footer__grid");
    if (foot && !foot.querySelector("[data-extra-foot]")) {
      const col = doc.createElement("div");
      col.setAttribute("data-extra-foot", "");
      col.innerHTML = "<h4>Направления</h4><ul>" +
        "<li><a href=\"service-alcohol.html\">Алкоголизм</a></li>" +
        "<li><a href=\"service-drugs.html\">Наркомания</a></li>" +
        "<li><a href=\"service-code.html\">Кодирование</a></li>" +
        "<li><a href=\"service-gambling.html\">Игровая зависимость</a></li>" +
        "<li><a href=\"service-help.html\">Помощь 24/7</a></li>" +
        "</ul>";
      const programsCol = [...foot.children].find((n) => n.querySelector("h4")?.textContent.includes("Программы"));
      if (programsCol) programsCol.after(col);
      else foot.appendChild(col);
    }

    const footWrap = doc.querySelector(".footer > .wrap");
    if (footWrap && !footWrap.querySelector("[data-footer-services]")) {
      const services = doc.createElement("div");
      services.className = "footer__services";
      services.setAttribute("data-footer-services", "");
      services.innerHTML =
        "<h4>Все услуги</h4>" +
        '<div class="footer__services-grid">' +
        "<div><b>Срочная помощь</b><ul>" +
        '<li><a href="service-zapoy.html">Запой и капельница</a></li>' +
        '<li><a href="service-visit.html">Выезд нарколога</a></li>' +
        '<li><a href="service-ambulance.html">Наркологическая скорая</a></li>' +
        '<li><a href="service-withdrawal.html">Снятие ломки</a></li>' +
        '<li><a href="service-ubod.html">УБОД</a></li>' +
        '<li><a href="service-sober.html">Частный вытрезвитель</a></li>' +
        '<li><a href="service-detox.html">Детокс 24/7</a></li>' +
        '<li><a href="service-drugtest.html">Тест на наркотики</a></li>' +
        '<li><a href="service-toxicologist.html">Токсиколог</a></li>' +
        '<li><a href="service-help.html">Наркологическая помощь</a></li>' +
        "</ul></div>" +
        "<div><b>Алкоголизм</b><ul>" +
        '<li><a href="service-alcohol.html">Лечение алкоголизма</a></li>' +
        '<li><a href="service-zapoy.html#alko-programs">Программы вывода из запоя</a></li>' +
        '<li><a href="service-zapoy-1day.html">Вывод из запоя 1 день</a></li>' +
        '<li><a href="service-zapoy-2days.html">Курс 2 дня</a></li>' +
        '<li><a href="service-zapoy-3days.html">Курс 3 дня</a></li>' +
        '<li><a href="service-zapoy-5days.html">Курс 5 дней</a></li>' +
        '<li><a href="service-zapoy-7days.html">Курс 7 дней</a></li>' +
        '<li><a href="service-alcohol-women.html">Женский алкоголизм</a></li>' +
        '<li><a href="service-alcohol-men.html">Мужской алкоголизм</a></li>' +
        '<li><a href="service-alcohol-beer.html">Пивной</a></li>' +
        '<li><a href="service-alcohol-wine.html">Винный</a></li>' +
        '<li><a href="service-alcohol-elderly.html">Старческий</a></li>' +
        '<li><a href="service-alcohol-home.html">На дому</a></li>' +
        '<li><a href="service-alcohol-hangover.html">Похмелье</a></li>' +
        '<li><a href="service-alcohol-shot.html">Укол от алкоголизма</a></li>' +
        '<li><a href="service-alcohol-shichko.html">Метод Шичко</a></li>' +
        "</ul></div>" +
        "<div><b>Кодирование</b><ul>" +
        '<li><a href="service-code.html">Кодирование</a></li>' +
        '<li><a href="service-code-dovzhenko.html">По Довженко</a></li>' +
        '<li><a href="service-code-hypnosis.html">Гипноз</a></li>' +
        '<li><a href="service-code-implant.html">Вшивание ампулы</a></li>' +
        '<li><a href="service-code-torpedo.html">Торпедо</a></li>' +
        '<li><a href="service-code-esperal.html">Эспераль</a></li>' +
        '<li><a href="service-code-double.html">Двойной блок</a></li>' +
        '<li><a href="service-code-shot.html">Укол</a></li>' +
        '<li><a href="service-code-needle.html">Иглоукалывание</a></li>' +
        '<li><a href="service-code-aquilong.html">Аквилонг</a></li>' +
        '<li><a href="service-code-vivitrol.html">Вивитрол</a></li>' +
        '<li><a href="service-code-naltrexone.html">Налтрексон</a></li>' +
        '<li><a href="service-code-disulfiram.html">Дисульфирам</a></li>' +
        '<li><a href="service-code-algominal.html">Алгоминал</a></li>' +
        '<li><a href="service-code-sit.html">SIT</a></li>' +
        '<li><a href="service-code-home.html">На дому</a></li>' +
        '<li><a href="service-decode.html">Раскодирование</a></li>' +
        "</ul></div>" +
        "<div><b>Наркомания</b><ul>" +
        '<li><a href="service-drugs.html">Лечение наркомании</a></li>' +
        '<li><a href="service-drugs-code.html">Кодировка от наркозависимости</a></li>' +
        '<li><a href="service-drugs-heroin.html">Лечение от героина</a></li>' +
        '<li><a href="service-drugs-methadone.html">Лечение от метадона</a></li>' +
        '<li><a href="service-drugs-mephedrone.html">Лечение от мефедрона</a></li>' +
        '<li><a href="service-drugs-salts.html">Лечение от солей</a></li>' +
        '<li><a href="service-drugs-spice.html">Лечение от спайса</a></li>' +
        '<li><a href="service-drugs-cocaine.html">Лечение от кокаина</a></li>' +
        '<li><a href="service-drugs-amphetamine.html">Лечение от амфетамина</a></li>' +
        '<li><a href="service-drugs-cannabis.html">Лечение от марихуаны</a></li>' +
        '<li><a href="service-drugs-toxico.html">Лечение от токсикомании</a></li>' +
        '<li><a href="service-drugs-butyrate.html">Лечение от бутирата</a></li>' +
        '<li><a href="service-drugs-ephedrine.html">Лечение от эфедрина</a></li>' +
        "</ul></div>" +
        "<div><b>Реабилитация и семья</b><ul>" +
        '<li><a href="service-rehab.html">Реабилитация</a></li>' +
        '<li><a href="service-rehab-alcohol.html">Реабилитация алкозависимости</a></li>' +
        '<li><a href="service-rehab-12.html">12 шагов</a></li>' +
        '<li><a href="service-rehab-daytop.html">Day Top</a></li>' +
        '<li><a href="service-family.html">Семейная программа</a></li>' +
        '<li><a href="service-consult.html">Консультация</a></li>' +
        '<li><a href="service-check.html">Диагностика</a></li>' +
        '<li><a href="service-gambling.html">Игровая зависимость</a></li>' +
        '<li><a href="service-betting.html">Ставки на спорт</a></li>' +
        "</ul></div>" +
        "<div><b>Психиатрия</b><ul>" +
        '<li><a href="service-psychiatry.html">Психиатрия</a></li>' +
        '<li><a href="service-psy-first.html">Первичная консультация</a></li>' +
        '<li><a href="service-psy-followup.html">Повторная консультация</a></li>' +
        '<li><a href="service-psy-online.html">Онлайн-консультация</a></li>' +
        '<li><a href="service-psy-home.html">Психиатр на дом</a></li>' +
        '<li><a href="service-psy-support.html">Сопровождение</a></li>' +
        '<li><a href="service-psy-psychologist.html">Клинический психолог</a></li>' +
        '<li><a href="service-psy-therapist.html">Психотерапевт</a></li>' +
        '<li><a href="service-psy-counseling.html">Консультирование</a></li>' +
        '<li><a href="service-psy-neurologist.html">Невролог</a></li>' +
        '<li><a href="service-psy-depression.html">Депрессия</a></li>' +
        '<li><a href="service-psy-psychosis.html">Психоз</a></li>' +
        '<li><a href="service-psy-delirium.html">Белая горячка</a></li>' +
        '<li><a href="service-psy-panic.html">Панические атаки</a></li>' +
        '<li><a href="service-psy-anxiety.html">Тревожное расстройство</a></li>' +
        '<li><a href="service-psy-insomnia.html">Бессонница</a></li>' +
        '<li><a href="service-psy-sleep.html">Нарушения сна</a></li>' +
        '<li><a href="service-psy-meds.html">Лекарственная зависимость</a></li>' +
        '<li><a href="service-psy-ocd.html">ОКР</a></li>' +
        '<li><a href="service-psy-ptsd.html">ПТСР</a></li>' +
        '<li><a href="service-psy-bipolar.html">Биполярное</a></li>' +
        '<li><a href="service-psy-schizophrenia.html">Шизофрения</a></li>' +
        '<li><a href="service-psy-elderly.html">Пожилой возраст</a></li>' +
        '<li><a href="service-psy-postcovid.html">Постковид</a></li>' +
        '<li><a href="service-psy-chronic.html">Хронические заболевания</a></li>' +
        '<li><a href="service-psy-somatic.html">Соматические симптомы</a></li>' +
        '<li><a href="service-psy-adhd.html">СДВГ</a></li>' +
        '<li><a href="service-psy-bpd.html">ПРЛ</a></li>' +
        '<li><a href="service-psy-tad.html">Тревожно-депрессивное</a></li>' +
        '<li><a href="service-psy-gad.html">ГТР</a></li>' +
        '<li><a href="service-psy-stress.html">Стресс</a></li>' +
        '<li><a href="service-psy-neurosis.html">Неврозы</a></li>' +
        '<li><a href="service-psy-paranoia.html">Паранойя</a></li>' +
        '<li><a href="service-dementia.html">Лечение деменции</a></li>' +
        '<li><a href="service-alzheimer.html">Лечение альцгеймера</a></li>' +
        '<li><a href="service-psy-dementia.html">Деменция и алкоголь</a></li>' +
        '<li><a href="service-psy-anorexia.html">Анорексия</a></li>' +
        '<li><a href="service-psy-bulimia.html">Булимия</a></li>' +
        '<li><a href="service-psy-dysmorpho.html">Дисморфофобия</a></li>' +
        '<li><a href="service-psy-asthenia.html">Астения</a></li>' +
        '<li><a href="service-psy-apathy.html">Апатия</a></li>' +
        '<li><a href="service-psy-kleptomania.html">Клептомания</a></li>' +
        '<li><a href="service-psy-narcolepsy.html">Нарколепсия</a></li>' +
        '<li><a href="service-psy-tourette.html">Синдром Туретта</a></li>' +
        '<li><a href="service-psy-sociopathy.html">Социопатия</a></li>' +
        '<li><a href="service-psy-somnolence.html">Сонливость</a></li>' +
        '<li><a href="service-psy-hypochondria.html">Ипохондрия</a></li>' +
        '<li><a href="service-psy-autoaggression.html">Аутоагрессия</a></li>' +
        '<li><a href="service-psy-neurasthenia.html">Неврастения</a></li>' +
        '<li><a href="service-psy-autophobia.html">Аутофобия</a></li>' +
        '<li><a href="service-psy-cyclothymia.html">Циклотимия</a></li>' +
        "</ul></div>" +
        "</div>";
      const copy = footWrap.querySelector(".footer__copy");
      if (copy) copy.before(services);
      else footWrap.appendChild(services);
    }

    if (footWrap && !footWrap.querySelector(".footer__disc")) {
      const copy = footWrap.querySelector(".footer__copy");
      if (copy) {
        const disc = doc.createElement("p");
        disc.className = "footer__disc";
        disc.innerHTML = "Медицинские услуги оказываются совершеннолетним пациентам добровольно, по адресу клиники или на дому по месту вызова. Телефонная консультация носит информационный характер и не заменяет осмотр. Сайт не является публичной офертой. 18+. Имеются противопоказания.";
        copy.before(disc);
      }
    }

    doc.querySelectorAll("select[name=\"program\"]").forEach((sel) => {
      if (sel.dataset.enriched) return;
      sel.dataset.enriched = "1";
      const extra = ["Лечение алкоголизма", "Лечение наркомании", "Снятие ломки", "Игровая зависимость", "УБОД", "Рассрочка / точный расчёт"];
      extra.forEach((t) => {
        if ([...sel.options].some((o) => o.textContent === t)) return;
        const o = doc.createElement("option");
        o.textContent = t;
        sel.appendChild(o);
      });
    });
  };

  const calc = () => {
    const root = doc.querySelector("[data-calc]");
    if (!root) return;
    const steps = [
      {
        q: "Какая услуга нужна?",
        short: "Услуга",
        opts: [
          "Кодирование от алкоголизма",
          "Лечение алкоголизма",
          "Наркологическая помощь",
          "Лечение наркомании",
          "Прокапаться от алкоголя в стационаре",
          "Срочный вывод из запоя",
          "Нарколог на дом",
          "Капельница от наркотиков"
        ]
      },
      {
        q: "Пол пациента",
        short: "Пол",
        opts: ["Мужчина", "Женщина"]
      },
      {
        q: "Как долго длится состояние?",
        short: "Длительность",
        opts: ["1–2 дня", "3–7 дней", "Более недели", "Сложно сказать / трезв"]
      },
      {
        q: "Есть согласие на лечение?",
        short: "Согласие",
        opts: ["Да", "Нет", "Иногда / сомневается"]
      },
      {
        q: "Проходил ли ранее лечение?",
        short: "Опыт",
        opts: ["Не лечился", "Детоксикация", "Реабилитация / кодирование"]
      },
      {
        q: "Есть отягощающие факторы?",
        short: "Факторы",
        opts: ["Нет осложнений", "Есть хронические болезни", "Возраст 60+", "Агрессия / спутанность"]
      }
    ];
    let i = 0;
    let busy = false;
    const picks = [];
    const panel = root.querySelector("[data-calc-panel]");
    const q = root.querySelector("[data-calc-q]");
    const opts = root.querySelector("[data-calc-opts]");
    const summary = root.querySelector("[data-calc-summary]");
    const dots = root.querySelector("[data-calc-dots]");
    const back = root.querySelector("[data-calc-back]");
    const form = root.querySelector("[data-calc-form]");

    const estimate = () => {
      let base = 4900;
      const service = picks[0] || "";
      if (/запой|капельн|прокап/i.test(service)) base = 6500;
      if (/код/i.test(service)) base = 12000;
      if (/наркоман|наркотик/i.test(service)) base = 9800;
      if (/нарколог на дом/i.test(service)) base = 7500;
      if (/помощ/i.test(service)) base = 5500;
      if (picks[2] === "Более недели") base += 2500;
      if (picks[2] === "3–7 дней") base += 1200;
      if (picks[5] && picks[5] !== "Нет осложнений") base += 1800;
      if (picks[3] === "Нет") base += 900;
      const hi = Math.round(base * 1.35 / 100) * 100;
      return { lo: base, hi: hi };
    };

    const renderSummary = () => {
      if (!summary) return;
      const price = estimate();
      summary.innerHTML =
        "<p class=\"calc-summary__title\">Краткое резюме</p><ul>" +
        steps.map((step, n) =>
          "<li><span>" + step.short + "</span><b>" + (picks[n] || "—") + "</b></li>"
        ).join("") +
        "<li><span>Ориентир</span><b>от " + price.lo.toLocaleString("ru-RU") + " ₽</b></li>" +
        "</ul><p class=\"calc-summary__note\">Расчёт предварительный. Точную сумму врач подтвердит после короткого опроса по телефону.</p>";
    };

    const fill = () => {
      if (dots) {
        dots.innerHTML = steps.map((_, n) => {
          const on = i >= steps.length || n <= i;
          return "<i class=\"" + (on ? "is-on" : "") + "\"></i>";
        }).join("");
      }

      if (i >= steps.length) {
        if (q) q.textContent = "Расчёт почти готов";
        if (opts) {
          opts.hidden = true;
          opts.innerHTML = "";
          opts.classList.remove("calc-services");
        }
        renderSummary();
        if (summary) summary.hidden = false;
        if (form) form.hidden = false;
        if (back) back.hidden = false;
        return;
      }

      if (form) form.hidden = true;
      if (summary) {
        summary.hidden = true;
        summary.innerHTML = "";
      }
      if (opts) {
        opts.hidden = false;
        opts.classList.toggle("calc-services", i === 0);
        opts.innerHTML = steps[i].opts.map((t) => "<button type=\"button\">" + t + "</button>").join("");
      }
      if (q) q.textContent = steps[i].q;
      if (back) back.hidden = i === 0;
    };

    const paint = (dir = 0) => {
      if (!panel || !dir) {
        fill();
        if (panel) panel.classList.add("is-ready");
        return;
      }
      if (busy) return;
      busy = true;
      panel.classList.remove("is-ready");
      panel.classList.add(dir > 0 ? "is-leave-next" : "is-leave-back");
      window.setTimeout(() => {
        fill();
        panel.classList.remove("is-leave-next", "is-leave-back");
        panel.classList.add(dir > 0 ? "is-enter-next" : "is-enter-back");
        window.requestAnimationFrame(() => {
          window.requestAnimationFrame(() => {
            panel.classList.remove("is-enter-next", "is-enter-back");
            panel.classList.add("is-ready");
            busy = false;
          });
        });
      }, 220);
    };

    if (opts) {
      opts.addEventListener("click", (e) => {
        const b = e.target.closest("button");
        if (!b || opts.hidden || busy) return;
        picks[i] = b.textContent.trim();
        b.classList.add("is-on");
        i += 1;
        paint(1);
      });
    }
    if (back) {
      back.addEventListener("click", (e) => {
        e.preventDefault();
        if (i <= 0 || busy) return;
        i -= 1;
        paint(-1);
      });
    }

    const formEl = form && form.querySelector("form[data-form]");
    if (formEl) {
      formEl.addEventListener("submit", (e) => {
        e.preventDefault();
        if (busy) return;
        form.classList.add("is-sent");
        if (summary) summary.hidden = true;
        if (q) q.textContent = "Заявка отправлена";
        if (back) back.hidden = true;
        busy = true;
        window.setTimeout(() => {
          form.classList.remove("is-sent");
          formEl.reset();
          picks.length = 0;
          i = 0;
          busy = false;
          paint(1);
        }, 3400);
      });
    }

    fill();
    if (panel) panel.classList.add("is-ready");
  };

  const roomsSlider = () => {
    const root = doc.querySelector("[data-rooms]");
    if (!root || typeof window.Swiper === "undefined") return;
    const el = root.querySelector("[data-rooms-swiper]");
    if (!el) return;
    new window.Swiper(el, {
      slidesPerView: 1,
      spaceBetween: 0,
      speed: 550,
      loop: true,
      autoHeight: false,
      navigation: {
        prevEl: root.querySelector("[data-rooms-prev]"),
        nextEl: root.querySelector("[data-rooms-next]")
      },
      pagination: {
        el: root.querySelector("[data-rooms-dots]"),
        clickable: true
      }
    });
  };

  const doctorsSlider = () => {
    const root = doc.querySelector("[data-doctors]");
    if (!root || typeof window.Swiper === "undefined") return;
    const el = root.querySelector("[data-docs-swiper]");
    const wrapper = root.querySelector("[data-docs-track]") || (el && el.querySelector(".swiper-wrapper"));
    const switcher = root.querySelector("[data-docs-switch]");
    const cards = [...root.querySelectorAll("[data-docs-card]")];
    if (!el || !wrapper || !cards.length) return;

    let swiper = null;
    const stash = doc.createDocumentFragment();

    const mount = () => {
      if (swiper) {
        swiper.destroy(true, true);
        swiper = null;
      }
      swiper = new window.Swiper(el, {
        slidesPerView: 1,
        spaceBetween: 18,
        speed: 450,
        watchOverflow: true,
        navigation: {
          prevEl: root.querySelector("[data-docs-prev]"),
          nextEl: root.querySelector("[data-docs-next]")
        },
        pagination: {
          el: root.querySelector("[data-docs-dots]"),
          clickable: true
        },
        breakpoints: {
          721: { slidesPerView: 2 },
          1101: { slidesPerView: 3 }
        }
      });
    };

    const applyFilter = (nextFilter) => {
      const filter = nextFilter || "field";
      cards.forEach((c) => {
        const ok = c.getAttribute("data-spec") === filter;
        c.classList.toggle("is-off", !ok);
        if (ok) wrapper.appendChild(c);
        else stash.appendChild(c);
      });
      if (switcher) {
        switcher.querySelectorAll("[data-docs-filter]").forEach((b) => {
          const on = b.getAttribute("data-docs-filter") === filter;
          b.classList.toggle("is-on", on);
          b.setAttribute("aria-selected", on ? "true" : "false");
        });
      }
      mount();
      if (swiper) swiper.slideTo(0, 0);
    };

    if (switcher) {
      switcher.addEventListener("click", (e) => {
        const b = e.target.closest("[data-docs-filter]");
        if (!b) return;
        applyFilter(b.getAttribute("data-docs-filter") || "field");
      });
    }

    const onTab = switcher && switcher.querySelector(".is-on");
    applyFilter((onTab && onTab.getAttribute("data-docs-filter")) || "field");
  };

  const stickyLead = () => {
    doc.querySelectorAll(".float-call").forEach((n) => n.remove());
    const existing = doc.querySelector("[data-sticky-lead]");
    if (existing) {
      existing.querySelectorAll(".sticky-lead__label").forEach((n) => {
        n.textContent = "Вызвать нарколога на дом";
      });
      existing.querySelectorAll(".sticky-lead__btn > span:not(.sticky-lead__ico)").forEach((n) => n.remove());
      existing.querySelectorAll(".sticky-lead__btn > img.icon-max").forEach((n) => n.remove());
      body.classList.add("has-sticky-lead");
      return;
    }

    const bar = doc.createElement("div");
    bar.className = "sticky-lead";
    bar.setAttribute("data-sticky-lead", "");
    bar.innerHTML =
      '<div class="sticky-lead__inner">' +
        '<a class="sticky-lead__call" href="tel:+78001001212" data-city-tel>' +
          '<span class="sticky-lead__label">Вызвать нарколога на дом</span>' +
          '<strong class="sticky-lead__phone" data-city-phone>8 800 100-12-12</strong>' +
        "</a>" +
        '<div class="sticky-lead__actions">' +
          '<a class="sticky-lead__btn sticky-lead__btn--max" href="https://max.ru/" data-city-max target="_blank" rel="noopener" aria-label="Max">' +
            '<span class="sticky-lead__ico"><img class="icon-max" src="' +
              ((typeof ALBA !== "undefined" && ALBA.home) ? String(ALBA.home).replace(/\/?$/, "/") : "/") +
              'images/Max_logo.svg" alt="" width="20" height="20" decoding="async"></span>' +
          "</a>" +
          '<a class="sticky-lead__btn sticky-lead__btn--tg" href="https://t.me/+78001001212" data-city-tg target="_blank" rel="noopener" aria-label="Telegram">' +
            '<span class="sticky-lead__ico"><svg width="20" height="20" viewBox="0 0 24 24" fill="#2aabee" aria-hidden="true"><path d="M21.43 4.53 3.87 11.32c-1.2.47-1.19 1.13-.22 1.43l4.5 1.4 10.45-6.59c.5-.3.95-.13.58.18l-8.46 7.63-.33 4.72c.48 0 .69-.22.96-.48l2.3-2.24 4.78 3.53c.88.48 1.51.23 1.73-.81l3.13-14.74c.32-1.28-.49-1.86-1.36-1.42Z"/></svg></span>' +
          "</a>" +
          '<a class="sticky-lead__btn sticky-lead__btn--phone" href="tel:+78001001212" data-city-tel aria-label="Позвонить">' +
            '<span class="sticky-lead__ico"><span class="icon-phone" aria-hidden="true"></span></span>' +
          "</a>" +
        "</div>" +
      "</div>";
    body.appendChild(bar);
    body.classList.add("has-sticky-lead");
  };

  const prodoctorov = () => {
    const side = doc.querySelector(".svc .svc-side");
    if (!side || side.querySelector("[data-pd-rec]")) return;
    const path = (location.pathname || "").toLowerCase();
    const file = path.split("/").filter(Boolean).pop() || "";
    const isService = /\/service\//.test(path) || /^service-/i.test(file);
    if (!isService) return;
    const box = doc.createElement("div");
    box.className = "pd-rec";
    box.setAttribute("data-pd-rec", "");
    const logo = (typeof ALBA !== "undefined" && ALBA.home ? ALBA.home.replace(/\/?$/, "/") : "/") + "images/prodoctorov-logo.png";
    box.innerHTML =
      '<div class="pd-rec__top">' +
        '<span class="pd-rec__brand"><img class="pd-rec__logo" src="' + logo + '" alt="ПроДокторов" width="120" height="24"></span>' +
        '<span class="pd-rec__score">4.8 <i>★</i></span>' +
      "</div>" +
      "<p>Рекомендация пациентов на ПроДокторов: клиника Альба — анонимная наркологическая помощь с выездом и стационаром.</p>" +
      '<a href="https://prodoctorov.ru/" target="_blank" rel="noopener">Смотреть рекомендации</a>';
    side.appendChild(box);
  };

  const pageFunnels = () => {
    const parts = (location.pathname || "").toLowerCase().split("/").filter(Boolean);
    const file = (parts[parts.length - 1] || "index").replace(/\.html$/, "");
    const skipList = ["", "index", "omsk", "nsk", "tomsk", "tyumen", "barnaul", "kemerovo", "nkz", "krsk", "surgut", "moscow", "spb", "sitemap", "links", "privacy", "consent", "terms", "legal", "404", "error"];
    // Home: / or /{city}/
    const isHome = parts.length === 0 || (parts.length === 1 && skipList.indexOf(parts[0]) !== -1 && !/\.html$/.test(parts[0]));
    if (isHome && parts.length <= 1) return;
    if (skipList.indexOf(file) !== -1 && parts.length <= 2 && ["sitemap", "links", "privacy", "consent", "terms", "legal", "404", "error"].indexOf(file) !== -1) return;

    const main = doc.querySelector("main");
    if (!main) return;

    const uid = () => "lf-" + Math.random().toString(36).slice(2, 9);
    const LEAD_SEL =
      ".page-funnel, .hub-lead, .cta, .funnel, .svc-rich-lead, [data-page-funnel], [data-home-funnel], [data-page-funnel-top], [data-page-funnel-mid], [data-page-funnel-ask]";

    const isLeadEl = (el) =>
      !!(el && el.nodeType === 1 && el.matches && el.matches(LEAD_SEL) && !el.matches(".lead-bridge, .seo-funnel"));

    const makeCta = (opts) => {
      const section = doc.createElement("section");
      section.className = "page-funnel wrap" + (opts.mod ? " " + opts.mod : "");
      if (opts.mark) section.setAttribute(opts.mark, "");
      section.innerHTML =
        '<div class="page-funnel__box">' +
          "<div>" +
            "<h2>" + opts.title + "</h2>" +
            "<p>" + opts.text + "</p>" +
          "</div>" +
          '<div class="page-funnel__actions">' +
            '<a class="btn btn--blue" href="#" data-open-modal>' + (opts.cta || "Оставить заявку") + "</a>" +
            '<a class="btn btn--line" href="tel:+78001001212" data-city-tel data-no-arr>Позвонить <span data-city-phone>8 800 100-12-12</span></a>' +
          "</div>" +
        "</div>";
      return section;
    };

    const makeForm = (opts) => {
      const id = uid();
      const section = doc.createElement("section");
      section.className = "page-funnel page-funnel--form wrap" + (opts.mod ? " " + opts.mod : "");
      if (opts.mark) section.setAttribute(opts.mark, "");
      section.innerHTML =
        '<div class="page-funnel__box page-funnel__box--form form">' +
          '<div class="page-funnel__copy">' +
            "<h2>" + opts.title + "</h2>" +
            "<p>" + opts.text + "</p>" +
            '<ul class="page-funnel__chips"><li>24/7</li><li>Анонимно</li><li>18+</li></ul>' +
          "</div>" +
          '<form data-form class="page-funnel__form">' +
            '<div class="form__fields page-funnel__fields">' +
              '<label class="visually-hidden" for="' + id + '">Телефон</label>' +
              '<input id="' + id + '" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">' +
              '<button class="btn btn--blue" type="submit">' + (opts.cta || "Жду звонка") + "</button>" +
            "</div>" +
            '<p class="page-funnel__legal">Нажимая кнопку, вы соглашаетесь с <a href="consent.html">обработкой ПДн</a>.</p>' +
            '<div class="form__ok"><strong>Заявка принята.</strong> Дежурный врач перезвонит с номера клиники.</div>' +
          "</form>" +
        "</div>";
      return section;
    };

    const insertAfter = (ref, node) => {
      if (!ref || !ref.parentNode || !node) return false;
      if (ref.nextSibling) ref.parentNode.insertBefore(node, ref.nextSibling);
      else ref.parentNode.appendChild(node);
      return true;
    };

    const insertBefore = (ref, node) => {
      if (!ref || !ref.parentNode || !node) return false;
      ref.parentNode.insertBefore(node, ref);
      return true;
    };

    const isService = /^service-/i.test(file);
    const isDoctorPage = /^doctor-/i.test(file);
    const isDoctor = isDoctorPage || !!doc.querySelector("section.doctor, .doctor");
    const isDoctorsHub = file === "doctors.html";
    const isArticle = /^article-/i.test(file);
    const isAbout = file === "about.html" || !!doc.querySelector("section.about-pillars");
    const isPrograms = file === "programs.html";
    const isContacts = file === "contacts.html";
    const isPrices = file === "prices.html";
    const hasHero = !!doc.querySelector(".page-hero, .page-intro, .doc-hero");
    const hasHubLead = !!doc.querySelector(".hub-lead");
    const hasRichLead = !!doc.querySelector(".svc-rich-lead");
    const hasFinalCta = !!doc.querySelector("section.cta");

    if (!hasHero && !isDoctor) return;

    // Existing mid-page leads already cover the job — don't stack clones next to them
    const hasFaq = !!doc.querySelector("section.faq");
    const skipMid = hasRichLead || hasHubLead || isService || isDoctor || isDoctorsHub;
    const skipAsk =
      !hasFaq ||
      hasHubLead ||
      isService ||
      isDoctor ||
      isDoctorsHub ||
      isPrices ||
      isPrograms;
    const skipEnd = hasFinalCta;

    // 1) Top form — after hero/intro (skip if hub-lead already sits there)
    if (!doc.querySelector("[data-page-funnel-top]") && !hasHubLead && !isService) {
      const top = makeForm({
        mark: "data-page-funnel-top",
        mod: "page-funnel--top",
        title: isDoctor
          ? "Записаться к специалисту"
          : isArticle
            ? "Нужна консультация по теме?"
            : "Перезвоним за 2 минуты",
        text: isDoctor
          ? "Оставьте номер — подберём окно приёма анонимно."
          : "Дежурный врач подскажет формат: дом, стационар или консультация. Имя можно не называть.",
        cta: "Жду звонка"
      });
      if (isAbout) {
        const aboutBlock = doc.querySelector("section.about.wrap, section.about");
        if (!insertAfter(aboutBlock, top)) {
          const pillars = doc.querySelector("section.about-pillars");
          if (!insertBefore(pillars, top)) main.appendChild(top);
        }
      } else if (isDoctor || isDoctorsHub) {
        const core = doc.querySelector("section.doctor, .doctor, section.people, [data-doctors]");
        if (!insertAfter(core, top)) {
          const hero = doc.querySelector("section.page-hero, .page-hero");
          if (!insertAfter(hero, top)) main.appendChild(top);
        }
      } else {
        const hero = doc.querySelector("section.page-hero, section.page-intro, section.doc-hero, .page-hero, .page-intro");
        if (!insertAfter(hero, top)) main.insertBefore(top, main.firstChild);
      }
    }

    // 2) Mid CTA after content core (skip when page already has hub/rich lead)
    if (!skipMid && !doc.querySelector("[data-page-funnel-mid]")) {
      const mid = makeCta({
        mark: "data-page-funnel-mid",
        mod: "page-funnel--mid",
        title: isDoctor
          ? "Нужна именно эта смена?"
          : "Не уверены, куда обращаться?",
        text: "Коротко опишите ситуацию — подскажем следующий шаг без давления.",
        cta: "Оставить заявку"
      });
      if (isAbout) {
        const pillars = doc.querySelector("section.about-pillars.wrap, section.about-pillars");
        if (!insertAfter(pillars, mid)) {
          const steps = doc.querySelector("section.steps");
          if (!insertBefore(steps, mid)) main.appendChild(mid);
        }
      } else {
        const after =
          doc.querySelector("[data-svc-upgrade]") ||
          doc.querySelector("section.doctor, .doctor") ||
          doc.querySelector("section.article, .article-body, .essay") ||
          doc.querySelector("section.info-story, .info-story") ||
          doc.querySelector("section.people, [data-doctors]") ||
          (doc.querySelector(".gallery, .gallery-grid") &&
            doc.querySelector(".gallery, .gallery-grid").closest("section")) ||
          (doc.querySelector(".articles") && doc.querySelector(".articles").closest("section")) ||
          (doc.querySelector(".review-list") && doc.querySelector(".review-list").closest("section")) ||
          (doc.querySelector(".licenses, .license-grid") &&
            doc.querySelector(".licenses, .license-grid").closest("section")) ||
          doc.querySelector("section.contacts, .contacts") ||
          (doc.querySelector(".price-wrap") && doc.querySelector(".price-wrap").closest("section")) ||
          doc.querySelector("section.catalog, .catalog, .programs") ||
          doc.querySelector("section.steps") ||
          doc.querySelector("[data-page-funnel-top]");
        const beforeFaq = doc.querySelector("section.faq, section.cta");
        if (after) {
          if (!insertAfter(after, mid) && !insertBefore(beforeFaq, mid)) main.appendChild(mid);
        } else if (!insertBefore(beforeFaq, mid)) {
          main.appendChild(mid);
        }
      }
    }

    // 3) Ask form before FAQ — skip when hub-lead already sits there
    if (!skipAsk && !doc.querySelector("[data-page-funnel-ask]")) {
      const ask = makeForm({
        mark: "data-page-funnel-ask",
        mod: "page-funnel--ask",
        title: "Остались вопросы?",
        text: "Оставьте телефон — ответим по существу, без скрипта и без навязывания программы.",
        cta: "Получить ответ"
      });
      const before =
        doc.querySelector("section.faq") ||
        doc.querySelector("section.cta") ||
        doc.querySelector("[data-page-funnel]");
      if (!insertBefore(before, ask)) {
        const steps = doc.querySelector("section.steps");
        if (!insertAfter(steps, ask)) main.appendChild(ask);
      }
    }

    // 4) End CTA — skip when page already has final .cta
    if (!skipEnd && !doc.querySelector("[data-page-funnel]:not([data-page-funnel-top]):not([data-page-funnel-mid]):not([data-page-funnel-ask])")) {
      const end = makeCta({
        mark: "data-page-funnel",
        title: "Нужна помощь сегодня?",
        text: "Оставьте номер — перезвоним за несколько минут. Анонимно. 18+, добровольно.",
        cta: "Оставить заявку"
      });
      const finalCta = doc.querySelector("section.cta");
      if (!insertBefore(finalCta, end)) main.appendChild(end);
    }

    // 5) Break consecutive lead stacks with thematic content bridges
    const bridgeVariants = (() => {
      if (isDoctor || isDoctorsHub) {
        return [
          {
            title: "Как проходит запись к врачу",
            items: [
              ["01", "Короткий звонок", "Уточняем состояние и свободные окна приёма."],
              ["02", "Анонимно", "Можно не называть фамилию — достаточно телефона."],
              ["03", "Без давления", "Решение о визите остаётся за вами."]
            ]
          },
          {
            title: "Что важно знать заранее",
            items: [
              ["18+", "Возраст", "Помогаем пациентам старше 18 лет, добровольно."],
              ["24/7", "Связь", "Дежурный врач на линии круглосуточно."],
              ["Ло", "Лицензия", "Работаем по медицинской лицензии."]
            ]
          }
        ];
      }
      if (isService || isPrograms || isPrices) {
        return [
          {
            title: "Перед консультацией полезно знать",
            items: [
              ["01", "Оценка состояния", "Врач уточнит симптомы и противопоказания."],
              ["02", "Формат помощи", "Дом, амбулатория или стационар — по показаниям."],
              ["03", "Ориентир по цене", "Назовём вилку стоимости до начала программы."]
            ]
          },
          {
            title: "Почему семьи выбирают «Альбу»",
            items: [
              ["24/7", "На связи", "Принимаем обращения ночью и в выходные."],
              ["Ло", "Тайна", "Диагноз не уходит третьим лицам без согласия."],
              ["План", "Маршрут", "Понятный путь: от стабилизации до поддержки."]
            ]
          }
        ];
      }
      if (isContacts) {
        return [
          {
            title: "Как быстрее получить ответ",
            items: [
              ["01", "Телефон", "Самый быстрый способ — звонок дежурному врачу."],
              ["02", "Мессенджер", "Можно написать в Max или Telegram."],
              ["03", "Адрес", "Приезжайте по записи — отдельный вход."]
            ]
          }
        ];
      }
      if (isAbout) {
        return [
          {
            title: "Коротко о правилах клиники",
            items: [
              ["18+", "Добровольно", "Лечение только с согласия пациента."],
              ["Тайна", "Конфиденциально", "Соблюдаем врачебную тайну."],
              ["24/7", "Круглосуточно", "Стационар и консультация без выходных."]
            ]
          }
        ];
      }
      return [
        {
          title: "Полезно знать до обращения",
          items: [
            ["01", "Без осуждения", "Говорим спокойно о состоянии и вариантах помощи."],
            ["02", "Анонимно", "Можно обратиться под псевдонимом."],
            ["03", "18+", "Помогаем совершеннолетним пациентам."]
          ]
        },
        {
          title: "Что можно уточнить у врача",
          items: [
            ["?", "Формат", "Дом или стационар — что безопаснее сейчас."],
            ["?", "Сроки", "Сколько длится стабилизация и наблюдение."],
            ["?", "Стоимость", "От чего зависит цена в вашем случае."]
          ]
        }
      ];
    })();

    const makeBridge = (variant) => {
      const section = doc.createElement("section");
      section.className = "lead-bridge wrap";
      section.setAttribute("data-lead-bridge", "");
      const cards = variant.items
        .map(
          (it) =>
            '<article class="lead-bridge__card">' +
              '<div class="lead-bridge__n">' + it[0] + "</div>" +
              "<h3>" + it[1] + "</h3>" +
              "<p>" + it[2] + "</p>" +
            "</article>"
        )
        .join("");
      section.innerHTML =
        '<div class="lead-bridge__box">' +
          '<h2 class="section-title">' + variant.title + "</h2>" +
          '<div class="lead-bridge__grid">' + cards + "</div>" +
        "</div>";
      return section;
    };

    const breakLeadStacks = () => {
      let guard = 0;
      let bridgeIdx = 0;
      while (guard++ < 12) {
        const kids = Array.from(main.children).filter((el) => el.nodeType === 1);
        let inserted = false;
        for (let i = 0; i < kids.length - 1; i++) {
          const a = kids[i];
          const b = kids[i + 1];
          if (!isLeadEl(a) || !isLeadEl(b)) continue;
          // Don't separate sticky pairs that are the same logical block
          if (a.hasAttribute("data-lead-bridge") || b.hasAttribute("data-lead-bridge")) continue;
          const variant = bridgeVariants[bridgeIdx % bridgeVariants.length];
          bridgeIdx += 1;
          insertBefore(b, makeBridge(variant));
          inserted = true;
          break;
        }
        if (!inserted) break;
      }
    };

    breakLeadStacks();
  };

  const homeFunnels = () => {
    const file = ((location.pathname || "").split("/").pop() || "index.html").toLowerCase();
    if (file && file !== "index.html" && file !== "/") return;
    const main = doc.querySelector("main");
    if (!main || doc.querySelector("[data-home-funnel]")) return;

    const uid = () => "hf-" + Math.random().toString(36).slice(2, 9);

    const strip = (opts) => {
      const id = uid();
      const section = doc.createElement("section");
      section.className = "page-funnel page-funnel--form wrap" + (opts.mod ? " " + opts.mod : "");
      section.setAttribute(opts.mark, "");
      section.innerHTML =
        '<div class="page-funnel__box page-funnel__box--form form">' +
          '<div class="page-funnel__copy">' +
            "<h2>" + opts.title + "</h2>" +
            "<p>" + opts.text + "</p>" +
            '<ul class="page-funnel__chips"><li>Отвечает врач</li><li>Анонимно</li><li>24/7</li></ul>' +
          "</div>" +
          '<form data-form class="page-funnel__form">' +
            '<div class="form__fields page-funnel__fields">' +
              '<label class="visually-hidden" for="' + id + '">Телефон</label>' +
              '<input id="' + id + '" name="phone" type="tel" placeholder="+7 (" required autocomplete="tel">' +
              '<button class="btn btn--blue" type="submit">' + opts.cta + "</button>" +
            "</div>" +
            '<p class="page-funnel__legal">Согласие на <a href="consent.html">обработку ПДн</a>.</p>' +
            '<div class="form__ok"><strong>Спасибо!</strong> Дежурный врач скоро перезвонит.</div>' +
          "</form>" +
        "</div>";
      return section;
    };

    const insertAfter = (ref, node) => {
      if (!ref || !ref.parentNode) return;
      if (ref.nextSibling) ref.parentNode.insertBefore(node, ref.nextSibling);
      else ref.parentNode.appendChild(node);
    };

    // Place after guarantee so it doesn't sit next to the static .funnel
    const afterGuarantee = doc.querySelector("section.guarantee");
    const afterPeople = doc.querySelector("section.people[data-doctors], section.people");
    const docsAnchor = afterGuarantee || afterPeople;
    if (docsAnchor && !doc.querySelector("[data-home-funnel-docs]")) {
      insertAfter(docsAnchor, strip({
        mark: "data-home-funnel-docs",
        mod: "page-funnel--top",
        title: "Выберите врача или просто оставьте номер",
        text: "Подскажем, кто дежурит сегодня и какой формат подойдёт: выезд, амбулатория или стационар.",
        cta: "Жду звонка"
      }));
    }

    const afterReviews = doc.querySelector("section.reviews");
    if (afterReviews && !doc.querySelector("[data-home-funnel-reviews]")) {
      insertAfter(afterReviews, strip({
        mark: "data-home-funnel-reviews",
        mod: "page-funnel--ask",
        title: "Хотите такой же спокойный старт?",
        text: "Один звонок — и дежурный врач предложит план без давления и без ярлыков.",
        cta: "Получить план"
      }));
    }

    const afterPrice = doc.querySelector("section.home-price");
    if (afterPrice && !doc.querySelector("[data-home-funnel-price]")) {
      const section = doc.createElement("section");
      section.className = "page-funnel page-funnel--mid wrap";
      section.setAttribute("data-home-funnel-price", "");
      section.setAttribute("data-home-funnel", "");
      section.innerHTML =
        '<div class="page-funnel__box">' +
          "<div>" +
            "<h2>Нужен ориентир по стоимости именно вашего случая?</h2>" +
            "<p>После короткого разговора назовём вилку цены и доступные окна на сегодня.</p>" +
          "</div>" +
          '<div class="page-funnel__actions">' +
            '<a class="btn btn--blue" href="#" data-open-modal>Узнать стоимость</a>' +
            '<a class="btn btn--line" href="#calc">Открыть калькулятор</a>' +
          "</div>" +
        "</div>";
      insertAfter(afterPrice, section);
    }
  };

  const ARR_SVG =
    '<svg viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M3 7h8M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>';

  const ensureBtnArrows = () => {
    doc.querySelectorAll("a.btn, button.btn").forEach((btn) => {
      const href = (btn.getAttribute("href") || "").trim().toLowerCase();
      const skip =
        btn.classList.contains("btn--ghost") ||
        btn.classList.contains("btn--no-arr") ||
        btn.hasAttribute("data-no-arr") ||
        href.startsWith("tel:");
      if (skip) {
        btn.querySelectorAll(".arr").forEach((n) => n.remove());
        return;
      }
      if (btn.querySelector(".arr")) return;
      const arr = doc.createElement("span");
      arr.className = "arr";
      arr.setAttribute("aria-hidden", "true");
      arr.innerHTML = ARR_SVG;
      btn.appendChild(arr);
    });
  };

  const exitModal = () => {
    if (doc.querySelector("[data-exit-modal]")) return;
    const KEY = "alba-exit-modal-shown";
    try {
      if (sessionStorage.getItem(KEY) === "1") return;
    } catch (e) {}

    const el = doc.createElement("div");
    el.className = "exit-modal";
    el.setAttribute("data-exit-modal", "");
    el.setAttribute("role", "dialog");
    el.setAttribute("aria-modal", "true");
    el.setAttribute("aria-label", "Консультация");
    el.innerHTML =
      '<div class="exit-modal__body">' +
        '<div class="exit-modal__top">' +
          '<a class="exit-modal__logo" href="index.html" aria-label="Альба">' +
            '<svg class="logo__mark" viewBox="0 0 32 32"><path fill="currentColor" d="M16 1.8c1.7 5.6 5.8 9.7 11.4 11.4C21.8 15 17.7 19.1 16 24.7 14.3 19.1 10.2 15 4.6 13.2 10.2 11.5 14.3 7.4 16 1.8Z"/></svg>' +
            "<span>Альба</span>" +
          "</a>" +
          '<div class="exit-modal__top-right">' +
            '<ul class="exit-modal__tags">' +
              "<li>Бесплатная консультация</li>" +
              "<li>24/7</li>" +
              '<li><a href="tel:+78001001212" data-city-tel><span data-city-phone>8 800 100-12-12</span></a></li>' +
            "</ul>" +
            '<button class="exit-modal__close" type="button" data-exit-close aria-label="Закрыть">×</button>' +
          "</div>" +
        "</div>" +
        '<div class="exit-modal__wrap">' +
          '<div class="exit-modal__card">' +
            '<div class="exit-modal__text">' +
              '<p class="exit-modal__title">Подскажем, какой формат помощи вам подойдёт</p>' +
              '<p class="exit-modal__subtitle">Можно уточнить выезд врача на дом, стоимость, условия стационара или порядок обращения. 18+, добровольно.</p>' +
              '<div class="exit-modal__btns">' +
                '<a class="btn btn--blue" href="tel:+78001001212" data-city-tel>Вызвать врача</a>' +
                '<a class="btn btn--line" href="index.html#calc">Калькулятор</a>' +
              "</div>" +
            "</div>" +
            '<ul class="exit-modal__items">' +
              "<li>Поможем понять, нужен ли выезд врача</li>" +
              "<li>Сориентируем по цене</li>" +
              "<li>Обращение остаётся анонимным</li>" +
            "</ul>" +
          "</div>" +
          '<div class="exit-modal__card exit-modal__card--form">' +
            '<form class="exit-modal__form" data-exit-form>' +
              '<p class="exit-modal__form-title">Оставьте номер</p>' +
              '<p class="exit-modal__form-subtitle">Администратор свяжется и подскажет ближайший вариант помощи</p>' +
              '<label class="visually-hidden" for="exit-phone">Телефон</label>' +
              '<input id="exit-phone" class="exit-modal__form-input" type="tel" name="phone" required placeholder="+7 (" autocomplete="tel">' +
              '<p class="exit-modal__form-politic">Нажимая на кнопку, вы даёте <a href="consent.html">согласие на обработку персональных данных</a> и соглашаетесь с <a href="privacy.html">политикой конфиденциальности</a></p>' +
              '<button class="btn btn--blue exit-modal__form-btn" type="submit">Получить консультацию</button>' +
              '<div class="exit-modal__thanks" hidden><strong>Спасибо!</strong><p>Мы перезвоним в ближайшие минуты.</p></div>' +
            "</form>" +
            '<div class="exit-modal__networks">' +
              '<p class="exit-modal__networks-text">Или напишите без звонка:</p>' +
              '<div class="exit-modal__networks-wrap">' +
                '<a class="exit-modal__networks-item" href="https://t.me/+78001001212" data-city-tg target="_blank" rel="noopener">Telegram</a>' +
                '<a class="exit-modal__networks-item" href="https://max.ru/" data-city-max target="_blank" rel="noopener">Max</a>' +
              "</div>" +
            "</div>" +
          "</div>" +
        "</div>" +
      "</div>";
    body.appendChild(el);

    const markShown = () => {
      try { sessionStorage.setItem(KEY, "1"); } catch (e) {}
    };

    const open = () => {
      if (el.classList.contains("is-open")) return;
      if (doc.querySelector(".modal.is-open, .geo.is-open, .mnav.is-open")) return;
      el.classList.add("is-open");
      lockScroll();
      markShown();
      ensureBtnArrows();
    };

    const close = () => {
      if (!el.classList.contains("is-open")) return;
      el.classList.remove("is-open");
      unlockScroll();
      markShown();
    };

    el.querySelectorAll("[data-exit-close]").forEach((b) => b.addEventListener("click", close));
    el.addEventListener("click", (e) => { if (e.target === el) close(); });
    doc.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && el.classList.contains("is-open")) close();
    });

    const form = el.querySelector("[data-exit-form]");
    if (form) {
      form.addEventListener("submit", (e) => {
        e.preventDefault();
        form.classList.add("is-sent");
        const thanks = form.querySelector(".exit-modal__thanks");
        if (thanks) thanks.hidden = false;
      });
    }

    let armed = false;
    window.setTimeout(() => { armed = true; }, 4500);

    doc.addEventListener("mouseout", (e) => {
      if (!armed) return;
      try {
        if (sessionStorage.getItem(KEY) === "1") return;
      } catch (err) {}
      if (e.clientY > 12) return;
      if (e.relatedTarget || e.toElement) return;
      if (matchMedia("(pointer: coarse)").matches) return;
      open();
    });

    // Soft fallback for mobile / no mouse: once after long dwell
    window.setTimeout(() => {
      try {
        if (sessionStorage.getItem(KEY) === "1") return;
      } catch (err) {}
      if (matchMedia("(pointer: coarse)").matches && armed) open();
    }, 28000);
  };

  const fixMaxIcons = () => {
    const maxSrc =
      typeof ALBA !== "undefined" && ALBA.home
        ? String(ALBA.home).replace(/\/?$/, "/") + "images/Max_logo.svg"
        : "/images/Max_logo.svg";

    doc.querySelectorAll("img.icon-max").forEach((img) => {
      const src = img.getAttribute("src") || "";
      if (!src || /^(https?:|data:|\/\/)/i.test(src)) return;
      if (src.charAt(0) === "/") return;
      img.src = maxSrc;
    });

    doc.querySelectorAll("a[data-city-max]").forEach((a) => {
      if (a.closest("[data-sticky-lead]") || a.classList.contains("sticky-lead__btn")) return;
      if (!a.querySelector(".icon-max, .icon-max-svg, .sticky-lead__ico")) {
        const icon = doc.createElement("img");
        icon.className = "icon-max";
        icon.src = maxSrc;
        icon.alt = "";
        icon.width = 18;
        icon.height = 18;
        icon.setAttribute("decoding", "async");
        a.prepend(icon);
      }
      if (!a.getAttribute("aria-label")) a.setAttribute("aria-label", "Max");
      if (a.classList.contains("icon-btn") || a.closest(".footer__msg") || a.closest(".header__actions")) {
        [...a.childNodes].forEach((n) => {
          if (n.nodeType === 3 && String(n.textContent || "").trim()) n.remove();
        });
      }
    });
  };

  stickyLead();
  prodoctorov();
  pageFunnels();
  homeFunnels();
  splitHeadings();
  geo();
  catalogNav();
  preload();
  tilt();
  header();
  mobileNav();
  reveals();
  counters();
  accordion();
  modal();
  forms();
  offerDirs();
  dirsNav();
  year();
  cookies();
  marquee();
  calc();
  roomsSlider();
  doctorsSlider();
  ensureBtnArrows();
  exitModal();
  fixMaxIcons();

  doc.addEventListener("visibilitychange", () => {
    body.classList.toggle("is-hidden-tab", doc.hidden);
  });
})();
