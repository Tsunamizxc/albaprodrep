(() => {
  const tabs = document.querySelector("[data-alba-int-tabs]");
  if (tabs) {
    const links = [...tabs.querySelectorAll("a")];
    const setActive = (hash) => {
      links.forEach((a) => a.classList.toggle("is-active", a.getAttribute("href") === hash));
    };
    links.forEach((a) => {
      a.addEventListener("click", () => {
        setActive(a.getAttribute("href"));
      });
    });
    if (location.hash) setActive(location.hash);
  }

  const box = document.querySelector("[data-smtp-test]");
  if (!box || typeof ALBA_INT === "undefined") return;
  const btn = box.querySelector("[data-smtp-send]");
  const input = box.querySelector("[data-smtp-to]");
  const msg = box.querySelector("[data-smtp-msg]");
  if (!btn || !input || !msg) return;

  const show = (ok, text) => {
    msg.hidden = false;
    msg.className = "alba-int__test-msg " + (ok ? "is-ok" : "is-err");
    msg.textContent = text;
  };

  btn.addEventListener("click", () => {
    const to = (input.value || "").trim();
    if (!to) {
      show(false, "Укажите email для теста.");
      return;
    }
    btn.disabled = true;
    show(false, "Отправляем…");
    msg.className = "alba-int__test-msg";

    const body = new URLSearchParams();
    body.set("action", "alba_smtp_test");
    body.set("nonce", ALBA_INT.nonce || "");
    body.set("to", to);

    const controller = new AbortController();
    const timer = window.setTimeout(() => controller.abort(), 20000);

    fetch(ALBA_INT.ajax, {
      method: "POST",
      credentials: "same-origin",
      headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
      body: body.toString(),
      signal: controller.signal
    })
      .then(async (r) => {
        const text = await r.text();
        let data = null;
        try {
          data = JSON.parse(text);
        } catch (e) {
          throw new Error(text ? text.slice(0, 180) : "Пустой ответ сервера (HTTP " + r.status + ")");
        }
        if (!r.ok && !(data && typeof data.success !== "undefined")) {
          throw new Error("HTTP " + r.status);
        }
        return data;
      })
      .then((data) => {
        if (data && data.success) {
          show(true, (data.data && data.data.message) || "Тестовое письмо отправлено.");
        } else {
          const errMsg =
            (data && data.data && data.data.message) ||
            (data && data.message) ||
            "Не удалось отправить письмо. Проверьте SMTP.";
          show(false, errMsg);
        }
      })
      .catch((err) => {
        if (err && err.name === "AbortError") {
          show(false, "Таймаут 20 с: сервер не ответил. Обычно это недоступный SMTP-хост (исходящие порты закрыты).");
          return;
        }
        show(false, "Ошибка: " + ((err && err.message) || "сеть / ответ сервера"));
      })
      .finally(() => {
        window.clearTimeout(timer);
        btn.disabled = false;
      });
  });
})();
