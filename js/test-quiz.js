/**
 * Alba clinic — quiz driven by ALBA_QUIZ from WordPress admin (CPT alba_quiz).
 */
(() => {
  const doc = document;
  const root = doc.querySelector("[data-test-quiz]");
  if (!root) return;

  const ICONS = {
    alcohol:
      '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M8 3h8l-1.2 4.2a5.8 5.8 0 0 1-5.6 4.1A5.8 5.8 0 0 1 9.2 7.2L8 3Z" stroke="currentColor" stroke-width="1.7"/><path d="M12 11.5V21M9 21h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>',
    drugs:
      '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9.5 4.5 19.5 14.5a2.2 2.2 0 0 1-3.1 3.1L6.4 7.6a2.2 2.2 0 0 1 3.1-3.1Z" stroke="currentColor" stroke-width="1.7"/><path d="M12 8.5 15.5 12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>',
    gambling:
      '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3.5" y="5.5" width="17" height="13" rx="2.5" stroke="currentColor" stroke-width="1.7"/><circle cx="9" cy="12" r="1.4" fill="currentColor"/><circle cx="15" cy="12" r="1.4" fill="currentColor"/></svg>',
    family:
      '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="9" cy="8" r="2.4" stroke="currentColor" stroke-width="1.7"/><circle cx="16" cy="9.2" r="2" stroke="currentColor" stroke-width="1.7"/><path d="M4.5 18.5c.6-3 2.6-4.6 4.5-4.6s3.9 1.6 4.5 4.6M13.2 14.2c1.1-.4 2.4-.4 3.5.2 1.5.8 2.5 2.4 2.8 4.1" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>',
    default:
      '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="8.2" stroke="currentColor" stroke-width="1.7"/><path d="M12 8v5M12 15.5v.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>',
  };

  const cfg = typeof ALBA_QUIZ !== "undefined" && ALBA_QUIZ ? ALBA_QUIZ : {};
  const CATS = Array.isArray(cfg.cats) ? cfg.cats : [];
  const levelCopy = cfg.levels || {
    low: { badge: "Низкий риск", title: "Сигналов немного — но разговор с врачом всё равно полезен", cls: "test-result__badge--low" },
    mid: { badge: "Умеренный риск", title: "Есть признаки, которые стоит обсудить со специалистом", cls: "test-result__badge--mid" },
    high: { badge: "Высокий риск", title: "По ответам нужна помощь врача в ближайшее время", cls: "test-result__badge--high" },
  };
  const disclaimer =
    cfg.disclaimer ||
    "Это не диагноз. Бриф ниже поможет дежурному врачу быстрее сориентироваться в разговоре — анонимно и без ярлыков.";

  const els = {
    cats: root.querySelector("[data-test-cats]"),
    catsWrap: root.querySelector("[data-test-cats-wrap]"),
    board: root.querySelector("[data-test-board]"),
    stage: root.querySelector("[data-test-stage]"),
    result: root.querySelector("[data-test-result]"),
    side: root.querySelector("[data-test-side]"),
    q: root.querySelector("[data-test-q]"),
    opts: root.querySelector("[data-test-opts]"),
    bar: root.querySelector("[data-test-bar]"),
    label: root.querySelector("[data-test-label]"),
    back: root.querySelector("[data-test-back]"),
    restart: root.querySelector("[data-test-restart]"),
    badge: root.querySelector("[data-test-badge]"),
    title: root.querySelector("[data-test-title]"),
    text: root.querySelector("[data-test-text]"),
    brief: root.querySelector("[data-test-brief]"),
    briefHeading: root.querySelector("[data-test-brief-heading]"),
    resultNote: root.querySelector("[data-test-result-note]"),
    catField: root.querySelector("[data-test-cat-field]"),
    scoreField: root.querySelector("[data-test-score-field]"),
    briefField: root.querySelector("[data-test-brief-field]"),
  };

  let cat = null;
  let idx = 0;
  let scores = [];

  const esc = (s) =>
    String(s || "")
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;");

  const levelOf = (sum, max) => {
    const r = max ? sum / max : 0;
    if (r < 0.34) return "low";
    if (r < 0.67) return "mid";
    return "high";
  };

  const renderCats = () => {
    if (!els.cats) return;
    if (!CATS.length) {
      els.cats.innerHTML =
        '<p class="test-empty">Тесты пока не добавлены. Создайте их в админке WordPress → Тесты.</p>';
      return;
    }
    els.cats.innerHTML = CATS.map((c) => {
      const ico = ICONS[c.icon] || ICONS[c.id] || ICONS.default;
      return (
        `<button type="button" class="test-cat" data-cat="${esc(c.id)}">` +
        `<span class="test-cat__ico">${ico}</span>` +
        `<h3>${esc(c.title)}</h3><p>${esc(c.desc)}</p>` +
        `<span class="test-cat__meta">${esc(c.meta || "")}</span></button>`
      );
    }).join("");
  };

  const show = (which) => {
    if (els.catsWrap) els.catsWrap.hidden = which !== "cats";
    else if (els.cats && els.cats.parentElement) els.cats.parentElement.hidden = which !== "cats";

    if (els.board) {
      els.board.hidden = which === "cats";
      els.board.classList.toggle("is-done", which === "result");
      els.board.classList.toggle("is-quiz", which === "stage");
    }

    if (els.stage) els.stage.classList.toggle("is-on", which === "stage");
    if (els.result) els.result.classList.toggle("is-on", which === "result");
    if (els.side) {
      els.side.classList.toggle("is-in", which === "result");
      els.side.setAttribute("aria-hidden", which === "result" ? "false" : "true");
    }
  };

  const renderQ = () => {
    const item = cat.questions[idx];
    const total = cat.questions.length;
    els.q.textContent = item.q;
    els.label.textContent = `${idx + 1} / ${total}`;
    els.bar.style.width = `${((idx + 1) / total) * 100}%`;
    els.back.hidden = idx === 0;
    els.opts.innerHTML = (item.opts || [])
      .map(
        (o, i) =>
          `<button type="button" class="test-opt" data-score="${Number(o.s)}" data-i="${i}">${esc(o.t)}</button>`
      )
      .join("");
    if (typeof scores[idx] === "number") {
      els.opts.querySelectorAll(".test-opt").forEach((btn) => {
        if (Number(btn.getAttribute("data-score")) === scores[idx]) btn.classList.add("is-on");
      });
    }
  };

  const finish = () => {
    const sum = scores.reduce((a, b) => a + b, 0);
    const max = cat.questions.reduce((a, q) => {
      const scoresOpts = (q.opts || []).map((o) => Number(o.s) || 0);
      return a + (scoresOpts.length ? Math.max(...scoresOpts) : 0);
    }, 0);
    const lvl = levelOf(sum, max);
    const copy = levelCopy[lvl] || levelCopy.mid;
    const bullets = (cat.briefs && cat.briefs[lvl]) || [];

    els.badge.className = "test-result__badge " + (copy.cls || "");
    els.badge.textContent = copy.badge || "";
    els.title.textContent = copy.title || "";
    if (els.text) els.text.textContent = disclaimer;
    if (els.briefHeading && cfg.briefHeading) els.briefHeading.textContent = cfg.briefHeading;
    if (els.resultNote && cfg.resultNote) els.resultNote.textContent = cfg.resultNote;
    if (els.restart && cfg.restartLabel) els.restart.textContent = cfg.restartLabel;
    els.brief.innerHTML = bullets.map((b) => `<li>${esc(b)}</li>`).join("");

    if (els.catField) els.catField.value = cat.title;
    if (els.scoreField) els.scoreField.value = `${sum}/${max} · ${copy.badge || ""}`;
    if (els.briefField) els.briefField.value = bullets.join(" | ");

    show("result");
    els.result.scrollIntoView({ behavior: "smooth", block: "start" });
  };

  const start = (id) => {
    cat = CATS.find((c) => c.id === id);
    if (!cat || !cat.questions || !cat.questions.length) return;
    idx = 0;
    scores = [];
    show("stage");
    renderQ();
    els.stage.scrollIntoView({ behavior: "smooth", block: "start" });
  };

  renderCats();
  if (els.board) els.board.hidden = true;
  show("cats");

  if (els.cats) {
    els.cats.addEventListener("click", (e) => {
      const btn = e.target.closest("[data-cat]");
      if (btn) start(btn.getAttribute("data-cat"));
    });
  }

  if (els.opts) {
    els.opts.addEventListener("click", (e) => {
      const btn = e.target.closest("[data-score]");
      if (!btn) return;
      scores[idx] = Number(btn.getAttribute("data-score"));
      els.opts.querySelectorAll(".test-opt").forEach((n) => n.classList.remove("is-on"));
      btn.classList.add("is-on");
      setTimeout(() => {
        if (idx < cat.questions.length - 1) {
          idx += 1;
          renderQ();
        } else {
          finish();
        }
      }, 180);
    });
  }

  if (els.back) {
    els.back.addEventListener("click", () => {
      if (idx === 0) {
        show("cats");
        return;
      }
      idx -= 1;
      renderQ();
    });
  }

  if (els.restart) {
    if (cfg.restartLabel) els.restart.textContent = cfg.restartLabel;
    els.restart.addEventListener("click", () => {
      show("cats");
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  }

  if (els.briefHeading && cfg.briefHeading) els.briefHeading.textContent = cfg.briefHeading;
  if (els.resultNote && cfg.resultNote) els.resultNote.textContent = cfg.resultNote;
})();
