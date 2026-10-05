(() => {
  const desktop = () => matchMedia('(min-width: 1024px)').matches;

  // Menu movil
  const toggle = document.querySelector('[data-menu-toggle]');
  const menu = document.querySelector('[data-menu]');
  const closeMenu = () => {
    if (!toggle || !menu) return;
    menu.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Abrir menú');
    document.body.classList.remove('menu-open');
  };
  document.addEventListener('keydown', event => {
    if (event.key !== 'Tab' || desktop() || !menu?.classList.contains('is-open')) return;
    const items = [toggle, ...menu.querySelectorAll('a,button')].filter(el => el && el.getClientRects().length && getComputedStyle(el).visibility !== 'hidden');
    const first = items[0], last = items.at(-1);
    if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last?.focus(); }
    else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first?.focus(); }
  });
  if (toggle && menu) {
    toggle.addEventListener('click', () => {
      const open = toggle.getAttribute('aria-expanded') !== 'true';
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
      menu.classList.toggle('is-open', open);
      document.body.classList.toggle('menu-open', open);
      if (open) menu.querySelector('a')?.focus();
    });
    menu.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
    addEventListener('resize', () => { if (desktop()) closeMenu(); });
  }

  // Desplegables (Servicios, Guias): click en la flecha abre/cierra; en escritorio tambien por hover/foco via CSS.
  const dropdowns = [...document.querySelectorAll('[data-dropdown]')];
  const setOpen = (item, open) => {
    item.classList.toggle('is-open', open);
    item.querySelector('[data-dropdown-toggle]')?.setAttribute('aria-expanded', String(open));
  };
  const closeAll = except => dropdowns.forEach(d => { if (d !== except) setOpen(d, false); });
  dropdowns.forEach(item => {
    const btn = item.querySelector('[data-dropdown-toggle]');
    btn?.addEventListener('click', event => {
      event.preventDefault();
      const open = !item.classList.contains('is-open');
      closeAll(item);
      setOpen(item, open);
    });
    item.addEventListener('focusout', event => {
      if (desktop() && !item.contains(event.relatedTarget)) setOpen(item, false);
    });
  });
  document.addEventListener('click', event => { if (!event.target.closest('[data-dropdown]')) closeAll(null); });
  addEventListener('keydown', event => {
    if (event.key !== 'Escape') return;
    const wasOpen = dropdowns.some(d => d.classList.contains('is-open'));
    closeAll(null);
    if (menu?.classList.contains('is-open')) { closeMenu(); toggle?.focus(); }
    else if (wasOpen) document.activeElement?.blur();
  });

  // Aparicion suave de bloques
  const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const reveals = document.querySelectorAll('[data-reveal]');
  if (reduced || !('IntersectionObserver' in window)) {
    reveals.forEach(item => item.classList.add('is-visible'));
  } else {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
      if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
    }), { threshold: 0.12 });
    reveals.forEach(item => observer.observe(item));
  }

  // Medicion (solo con consentimiento y GA4 configurado)
  const analytics = document.querySelector('meta[name="obra-analytics"]')?.content || '';
  const adsMeta = document.querySelector('meta[name="obra-ads"]');
  const adsId = adsMeta?.content || '';
  const track = (name, params) => { if (typeof window.gtag === 'function') window.gtag('event', name, params || {}); };
  // Conversion de Google Ads (solo con consentimiento y etiqueta configurada en config/local.php)
  const adsConversion = kind => {
    const label = adsMeta?.dataset[kind] || '';
    if (adsId && label && typeof window.gtag === 'function') window.gtag('event', 'conversion', { send_to: adsId + '/' + label });
  };

  // Atribucion de campana: gclid/gbraid/wbraid y utm_* del anuncio viajan al CRM con el formulario.
  // Se guardan en sessionStorage (no es cookie) para sobrevivir a la navegacion dentro del sitio.
  const attribKeys = ['gclid', 'gbraid', 'wbraid', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
  let attrib = {};
  try { attrib = JSON.parse(sessionStorage.getItem('obra-attrib') || '{}') || {}; } catch (e) { attrib = {}; }
  const params = new URLSearchParams(location.search);
  if (attribKeys.some(key => params.get(key))) {
    attrib = {};
    attribKeys.forEach(key => { const v = (params.get(key) || '').slice(0, 200); if (v) attrib[key] = v; });
    attrib.landing_path = location.pathname;
    try { sessionStorage.setItem('obra-attrib', JSON.stringify(attrib)); } catch (e) { /* modo privado */ }
  }
  document.querySelectorAll('[data-attrib]').forEach(input => { input.value = attrib[input.dataset.attrib] || ''; });
  // Medicion propia: sin cookies ni datos personales (t.php guarda evento, ubicacion, pagina y servicio).
  const beacon = (event, placement, service) => {
    try { navigator.sendBeacon('/t.php', JSON.stringify({ e: event, p: placement || '', u: location.pathname, s: service || '' })); } catch (e) { /* medir nunca rompe la pagina */ }
  };
  // Page loads are an anonymous denominator, not unique visitors.
  if (location.pathname !== '/gracias/' && !document.querySelector('meta[name="robots"]')?.content.includes('noindex')) {
    beacon('page_view', '', document.querySelector('[data-wa-service]')?.dataset.waService || '');
  }
  const footerSections = [...document.querySelectorAll('.footer-section')];
  const footerBreakpoint = matchMedia('(max-width:760px)');
  const updateFooter = () => footerSections.forEach(section => { section.open = !footerBreakpoint.matches; });
  updateFooter(); footerBreakpoint.addEventListener('change', updateFooter);

  // Formulario: URL de origen, doble envio y restauracion al volver atras
  document.querySelectorAll('[data-page-url]').forEach(input => { input.value = location.href; });
  document.querySelectorAll('[data-form]').forEach(form => {
    const button = form.querySelector('button[type="submit"]');
    const label = button ? button.innerHTML : '';
    form.addEventListener('submit', () => {
      if (!form.checkValidity()) return;
      track('form_attempt', { method: 'form' });
      if (button) { button.disabled = true; button.textContent = 'Enviando…'; }
    });
    addEventListener('pageshow', () => { if (button) { button.disabled = false; button.innerHTML = label; } });
    const service = form.querySelector('[data-service-select]');
    const specialty = form.querySelector('[name="specialty"]');
    const initialService = service?.value;
    const updateProjectFields = () => {
      const small = ['techos', 'reformas', 'patios', 'muros', 'supervision', 'presupuesto'].includes(service?.value) || ['renovacion', 'refaccion', 'parrillas'].includes(specialty?.value);
      form.querySelectorAll('[name="terrain"],[name="financing"]').forEach(input => { input.required = !small; });
      const details = form.querySelector('[data-project-details]');
      if (details) details.open = !small || !!details.querySelector('[aria-invalid="true"]');
      const status = form.querySelector('[data-details-status]');
      if (status) status.textContent = small ? '(opcional para esta consulta)' : '(para planificar la obra)';
    };
    service?.addEventListener('change', () => {
      if (specialty && service.value !== initialService) { specialty.value = ''; form.querySelector('.form-specialty')?.remove(); }
      updateProjectFields();
    });
    updateProjectFields();
  });

  // WhatsApp: un toque abre WhatsApp con el texto de la pagina (app/wa-messages.php). Solo se mide el clic.
  document.querySelectorAll('a[data-wa]').forEach(link => {
    link.addEventListener('click', () => beacon('whatsapp_click', link.dataset.wa, link.dataset.waService));
    link.addEventListener('click', () => track('whatsapp_click', { placement: link.dataset.wa, page_path: location.pathname, service: link.dataset.waService || '' }));
    link.addEventListener('click', () => adsConversion('wa'));
  });

  document.querySelectorAll('a[href^="tel:"]').forEach(link => link.addEventListener('click', () => { beacon('tel_click', link.dataset.wa || '', ''); adsConversion('tel'); }));

  // Barra fija movil: se oculta mientras el teclado esta abierto (foco en un campo).
  const fieldSelector = 'input:not([type="checkbox"]):not([type="hidden"]), textarea, select';
  document.addEventListener('focusin', event => { if (event.target.matches?.(fieldSelector)) document.body.classList.add('field-focus'); });
  document.addEventListener('focusout', event => { if (event.target.matches?.(fieldSelector)) document.body.classList.remove('field-focus'); });
  const thanks = document.querySelector('[data-thanks]');
  const trackReceipt = () => {
    if (!thanks || !/^(enviado|crm-confirmado)$/.test(thanks.dataset.thanks || '') || !thanks.dataset.receipt || typeof window.gtag !== 'function') return;
    const key = 'obra-confirmed-' + thanks.dataset.receipt;
    try { if (sessionStorage.getItem(key)) return; } catch { /* private browsing */ }
    track('generate_lead', { method: 'form', state: thanks.dataset.thanks });
    track('form_confirmed', { state: thanks.dataset.thanks });
    adsConversion('form');
    try { sessionStorage.setItem(key, '1'); } catch { /* server count remains authoritative */ }
  };

  // Consentimiento de cookies
  let consent = null;
  try { consent = localStorage.getItem('obra-cookie-consent'); } catch (e) { consent = null; }
  const remember = value => { try { localStorage.setItem('obra-cookie-consent', value); } catch (e) { /* modo privado */ } };
  const banner = document.querySelector('[data-cookie]');
  const loadAnalytics = () => {
    const ga4 = /^G-[A-Z0-9]+$/.test(analytics) ? analytics : '';
    const ads = /^AW-[0-9]+$/.test(adsId) ? adsId : '';
    if ((!ga4 && !ads) || window.gtag) return;
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    if (ga4) window.gtag('config', ga4);
    if (ads) window.gtag('config', ads);
    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(ga4 || ads)}`;
    document.head.appendChild(script);
    script.addEventListener('load', trackReceipt, { once: true });
  };
  if (consent === 'accepted') loadAnalytics();
  if (!consent && banner && (analytics || adsId)) banner.hidden = false;
  banner?.querySelector('[data-cookie-accept]')?.addEventListener('click', () => { remember('accepted'); banner.hidden = true; loadAnalytics(); });
  banner?.querySelector('[data-cookie-deny]')?.addEventListener('click', () => { remember('necessary'); banner.hidden = true; });
  trackReceipt();
})();
