/**
 * Bridge: city switcher → /{city}/… + leads → WP AJAX.
 * Does not reload when the chosen city is already active.
 */
(function () {
  if (typeof ALBA === "undefined") return;

  var doc = document;
  var citySlugs = (ALBA.cities || []).map(function (c) { return c.id; });
  var LS_KEY = "alba-city";

  function homeSegments() {
    var hp = "";
    try {
      hp = new URL(ALBA.home || "/", location.origin).pathname;
    } catch (e) {
      hp = "/";
    }
    return hp.replace(/\/+/g, "/").split("/").filter(Boolean);
  }

  function pathParts() {
    var parts = location.pathname.replace(/\/+/g, "/").split("/").filter(Boolean);
    var home = homeSegments();
    // Strip WP subdirectory (/alba) so city is the first segment.
    while (home.length && parts.length && parts[0] === home[0]) {
      parts.shift();
      home.shift();
    }
    return parts;
  }

  function currentCityFromUrl() {
    var parts = pathParts();
    if (parts.length && citySlugs.indexOf(parts[0]) !== -1) return parts[0];
    return "";
  }

  function remember(slug) {
    try { localStorage.setItem(LS_KEY, slug); } catch (e) {}
  }

  function closeGeo() {
    var geo = doc.querySelector("[data-geo]");
    if (geo) geo.classList.remove("is-open");
    doc.documentElement.classList.remove("is-lock");
    doc.body.classList.remove("is-lock");
  }

  function applyCityDom(city) {
    if (!city) return;
    var tel = String(city.tel || "+78001001212").replace(/\s+/g, "");
    var phone = city.phone || "8 800 100-12-12";
    doc.querySelectorAll("[data-city-name]").forEach(function (n) { n.textContent = city.name; });
    doc.querySelectorAll("[data-city-prep]").forEach(function (n) { n.textContent = city.prep; });
    doc.querySelectorAll("[data-city-phone]").forEach(function (n) { n.textContent = phone; });
    doc.querySelectorAll("[data-city-address]").forEach(function (n) { n.textContent = city.address || ""; });
    doc.querySelectorAll("[data-city-extra]").forEach(function (n) { n.textContent = city.extra || ""; });
    doc.querySelectorAll("[data-city-license]").forEach(function (n) { n.textContent = city.license || ""; });
    doc.querySelectorAll("[data-city-tel]").forEach(function (a) { a.setAttribute("href", "tel:" + tel); });
    if (city.tg) doc.querySelectorAll("[data-city-tg]").forEach(function (a) { a.setAttribute("href", city.tg); });
    if (city.max) doc.querySelectorAll("[data-city-max]").forEach(function (a) { a.setAttribute("href", city.max); });
  }

  function cityBySlug(slug) {
    var list = ALBA.cities || [];
    for (var i = 0; i < list.length; i++) {
      if (list[i].id === slug) return list[i];
    }
    return null;
  }

  function setCity(slug) {
    if (!slug) return;
    remember(slug);
    applyCityDom(cityBySlug(slug) || (ALBA.city && ALBA.city.slug === slug ? ALBA.city : null));
    closeGeo();

    // Already on this city URL — no reload (fixes infinite refresh on «Да, я из Омска»).
    if (currentCityFromUrl() === slug) {
      return;
    }

    var body = new FormData();
    body.append("action", "alba_set_city");
    body.append("nonce", ALBA.nonce);
    body.append("city", slug);
    body.append("path", location.pathname + location.search);
    fetch(ALBA.ajax, { method: "POST", body: body, credentials: "same-origin" })
      .then(function (r) { return r.json(); })
      .then(function (json) {
        if (json && json.success && json.data && json.data.redirect) {
          var next = json.data.redirect;
          var here = location.href.split("#")[0].replace(/\/?$/, "/");
          var there = String(next).split("#")[0].replace(/\/?$/, "/");
          if (here === there) return;
          location.href = next;
        }
      });
  }

  if (ALBA.cities && ALBA.cities.length) {
    window.ALBA_CITIES = ALBA.cities;
  }

  // Remember server city so legacy geo does not reopen every time.
  if (ALBA.city && ALBA.city.slug) {
    remember(ALBA.city.slug);
  }

  function cityBase() {
    var home = String(ALBA.home || "/").replace(/\/?$/, "/");
    var slug = (ALBA.city && ALBA.city.slug) || currentCityFromUrl() || "omsk";
    // Subdir install: pathname may be /alba/omsk/... — home already includes /alba/
    return home + slug + "/";
  }

  function legacyHrefToPretty(href) {
    if (!href || /^(https?:|\/\/|mailto:|tel:|#)/i.test(href)) return null;
    var hash = "";
    var m = String(href).match(/^(?:\.\/)?([^?#]*?)(\.html?)?(#[\w\-]+)?$/i);
    if (!m) return null;
    var file = m[1].split("/").pop();
    if (!file) return null;
    // Only rewrite .html or known legacy stems without extension.
    if (!m[2] && !/^(service|program|doctor|article)-/i.test(file)) return null;
    hash = m[3] || "";
    var stem = file.replace(/\.(html?)$/i, "");
    var base = cityBase();
    if (!stem || stem === "index") return base + hash;
    if (/^(service|program)-/i.test(stem)) {
      var slug = stem.replace(/^(service|program)-/i, "");
      var bucket = /^zapoy-\d/i.test(slug) ? "program" : "service";
      return base + bucket + "/" + slug + "/" + hash;
    }
    if (/^doctor-/i.test(stem)) {
      return base + "doctor/" + stem.replace(/^doctor-/i, "") + "/" + hash;
    }
    if (/^article-/i.test(stem)) {
      return base + "article/" + stem + "/" + hash;
    }
    return base + stem + hash;
  }

  function rewriteLegacyLinks(root) {
    (root || doc).querySelectorAll("a[href]").forEach(function (a) {
      var next = legacyHrefToPretty(a.getAttribute("href"));
      if (next) a.setAttribute("href", next);
    });
  }

  rewriteLegacyLinks(doc);
  doc.addEventListener("DOMContentLoaded", function () {
    rewriteLegacyLinks(doc);
    // main.js injects mega-menu after load.
    setTimeout(function () { rewriteLegacyLinks(doc); }, 0);
    setTimeout(function () { rewriteLegacyLinks(doc); }, 400);
  });
  if (typeof MutationObserver !== "undefined") {
    var mo = new MutationObserver(function (muts) {
      muts.forEach(function (mu) {
        mu.addedNodes.forEach(function (n) {
          if (n.nodeType === 1) rewriteLegacyLinks(n);
        });
      });
    });
    mo.observe(doc.documentElement, { childList: true, subtree: true });
  }

  doc.addEventListener(
    "click",
    function (e) {
      var yes = e.target.closest("[data-geo-yes]");
      if (yes) {
        e.preventDefault();
        e.stopImmediatePropagation();
        setCity("omsk");
        return;
      }
      var b = e.target.closest("[data-city-id]");
      if (!b) return;
      e.preventDefault();
      e.stopImmediatePropagation();
      setCity(b.getAttribute("data-city-id"));
    },
    true
  );

  doc.addEventListener("DOMContentLoaded", function () {
    doc.querySelectorAll("form[data-alba-lead], form[data-form]").forEach(function (form) {
      form.addEventListener("submit", function () {
        var phone = form.querySelector('[name="phone"]');
        if (!phone || !phone.value) return;
        var fd = new FormData();
        fd.append("action", "alba_lead");
        fd.append("nonce", ALBA.nonce);
        fd.append("phone", phone.value);
        var name = form.querySelector('[name="name"]');
        var prog = form.querySelector('[name="program"]');
        if (name) fd.append("name", name.value);
        if (prog) fd.append("program", prog.value);
        fd.append("page", location.href);
        var score = form.querySelector("[data-test-score-field]");
        var brief = form.querySelector("[data-test-brief-field]");
        if (score && score.value) fd.append("test_score", score.value);
        if (brief && brief.value) fd.append("test_brief", brief.value);
        fetch(ALBA.ajax, { method: "POST", body: fd, credentials: "same-origin" });
      });
    });
  });
})();
