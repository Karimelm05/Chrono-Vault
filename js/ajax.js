// Shared AJAX helper for forms
(function () {
  function isSameOriginUrl(url) {
    try {
      return new URL(url, window.location.href).origin === window.location.origin;
    } catch (e) {
      return false;
    }
  }

  function getAbsoluteUrl(url) {
    return new URL(url, window.location.href).toString();
  }

  function shouldAjaxNavigate(anchor) {
    if (!(anchor instanceof HTMLAnchorElement)) return false;
    if (anchor.target && anchor.target !== '_self') return false;
    if (anchor.hasAttribute('download')) return false;
    const href = anchor.getAttribute('href') || '';
    if (!href || href.startsWith('#')) return false;
    if (href.startsWith('mailto:') || href.startsWith('tel:')) return false;
    if (!isSameOriginUrl(href)) return false;

    const absoluteHref = getAbsoluteUrl(href);

    return true;
  }

  function collectScripts(container) {
    return Array.from(container.querySelectorAll('script')).map((script) => {
      const replacement = document.createElement('script');
      for (const attribute of script.attributes) {
        replacement.setAttribute(attribute.name, attribute.value);
      }
      if (!script.src) {
        replacement.textContent = script.textContent || '';
      }
      return replacement;
    });
  }

  function updateSidebarFromDocument(doc) {
    const currentSidebar = document.querySelector('#sidebar');
    const nextSidebar = doc.querySelector('#sidebar');
    if (currentSidebar && nextSidebar) {
      currentSidebar.outerHTML = nextSidebar.outerHTML;
    }
  }

  function updateMainContentFromDocument(doc) {
    const currentMainContent = document.querySelector('#main .main-content');
    const nextMainContent = doc.querySelector('#main .main-content');

    if (!currentMainContent || !nextMainContent) {
      return false;
    }

    const scripts = collectScripts(nextMainContent);
    nextMainContent.querySelectorAll('script').forEach((script) => script.remove());

    currentMainContent.innerHTML = nextMainContent.innerHTML;
    scripts.forEach((script) => currentMainContent.appendChild(script));
    return true;
  }

  function syncBodyClasses(doc) {
    const nextBody = doc.body;
    if (!nextBody) return;
    document.body.className = nextBody.className;
  }

  async function loadPage(url, options = {}) {
    const absoluteUrl = getAbsoluteUrl(url);

    try {
      const response = await fetch(absoluteUrl, {
        method: 'GET',
        credentials: 'same-origin',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const html = await response.text();
      const contentType = response.headers.get('content-type') || '';

      if (contentType.includes('application/json')) {
        let json;
        try {
          json = JSON.parse(html);
        } catch (e) {
          window.location.href = response.url || absoluteUrl;
          return;
        }
        handleResponseJson(json);
        return;
      }

      const parser = new DOMParser();
      const doc = parser.parseFromString(html, 'text/html');

      if (!doc.querySelector('#main') || !doc.querySelector('#sidebar')) {
        window.location.href = response.url || absoluteUrl;
        return;
      }

      syncBodyClasses(doc);
      updateSidebarFromDocument(doc);

      const updated = updateMainContentFromDocument(doc);
      if (!updated) {
        window.location.href = response.url || absoluteUrl;
        return;
      }

      if (doc.title) {
        document.title = doc.title;
      }

      if (options.pushState !== false) {
        window.history.pushState({ cvAjax: true, url: response.url || absoluteUrl }, '', response.url || absoluteUrl);
      }

      window.scrollTo({ top: 0, behavior: 'smooth' });
    } catch (e) {
      console.error(e);
      window.location.href = absoluteUrl;
    }
  }

  function handleResponseJson(json) {
    if (json.redirect) {
      loadPage(json.redirect);
      return;
    }

    if (json.success) {
      if (json.message) {
        alert(json.message);
      } else {
        window.location.reload();
      }
      return;
    }

    if (json.errors) {
      if (Array.isArray(json.errors)) {
        alert(json.errors.join('\n'));
      } else if (typeof json.errors === 'string') {
        alert(json.errors);
      }
      return;
    }

    if (json.message) alert(json.message);
  }

  async function submitFormAjax(form) {
    const method = (form.method || 'POST').toUpperCase();
    const action = form.action || window.location.href;
    const fd = new FormData(form);

    try {
      const res = await fetch(action, {
        method,
        body: fd,
        credentials: 'same-origin',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      const txt = await res.text();
      let json;
      try { json = JSON.parse(txt); } catch (e) {
        alert('Réponse invalide du serveur.');
        return;
      }
      handleResponseJson(json);
    } catch (e) {
      console.error(e);
      alert('Erreur réseau lors de la requête.');
    }
  }

  document.addEventListener('click', function (ev) {
    if (ev.defaultPrevented) return;
    if (ev.button !== 0) return;
    if (ev.metaKey || ev.ctrlKey || ev.shiftKey || ev.altKey) return;

    const target = ev.target instanceof Element ? ev.target : null;
    const anchor = target ? target.closest('a') : null;
    if (!(anchor instanceof HTMLAnchorElement)) return;
    if (!shouldAjaxNavigate(anchor)) return;

    ev.preventDefault();
    loadPage(anchor.getAttribute('href') || anchor.href);
  });

  window.addEventListener('popstate', function () {
    loadPage(window.location.href, { pushState: false });
  });

  document.addEventListener('submit', function (ev) {
    const form = ev.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (!form.classList.contains('ajax-form')) return;

    ev.preventDefault();
    submitFormAjax(form);
  }, false);

  // expose helper
  window.CV_AJAX = { submitFormAjax, loadPage };
})();
