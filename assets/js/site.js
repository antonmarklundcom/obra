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
  const track = (name, params) => { if (typeof window.gtag === 'function') window.gtag('event', name, params || {}); };

  // Formulario: URL de origen, doble envio y restauracion al volver atras
  document.querySelectorAll('[data-page-url]').forEach(input => { input.value = location.href; });
  document.querySelectorAll('[data-form]').forEach(form => {
    const button = form.querySelector('button[type="submit"]');
    const label = button ? button.innerHTML : '';
    form.addEventListener('submit', () => {
      if (!form.checkValidity()) return;
      track('generate_lead', { method: 'form' });
      if (button) { button.disabled = true; button.textContent = 'Enviando…'; }
    });
    addEventListener('pageshow', () => { if (button) { button.disabled = false; button.innerHTML = label; } });
  });

  // WhatsApp: antes de escribir, elegir la respuesta y armar el mensaje segun eso.
  // "thanks" ya contesto estas preguntas en el formulario, se deja como link directo.
  const WA_OPTIONS = [
    { key: 'presupuesto', label: 'Quiero un presupuesto', suffix: 'y quiero un presupuesto por escrito.' },
    { key: 'dudas', label: 'Tengo dudas antes de cotizar', suffix: 'y tengo algunas dudas antes de cotizar.' },
    { key: 'urgente', label: 'Es urgente', suffix: 'y es urgente, necesito una respuesta rápida.' },
  ];
  let waPanel = null;
  const closeWaPanel = () => { waPanel?.remove(); waPanel = null; };
  document.querySelectorAll('a[data-wa]').forEach(link => {
    if (link.dataset.wa === 'thanks') {
      link.addEventListener('click', () => track('whatsapp_click', { placement: link.dataset.wa, page_path: location.pathname }));
      return;
    }
    let url;
    try { url = new URL(link.href); } catch (e) { return; }
    const base = url.searchParams.get('text') || '';
    const intro = base.split(' y quiero ')[0];
    link.setAttribute('aria-haspopup', 'true');
    link.setAttribute('aria-expanded', 'false');
    link.addEventListener('click', event => {
      event.preventDefault();
      const already = waPanel && waPanel.dataset.for === link.dataset.wa;
      closeWaPanel();
      if (already) return;
      const panel = document.createElement('div');
      panel.className = 'wa-picker';
      panel.dataset.for = link.dataset.wa;
      panel.setAttribute('role', 'menu');
      panel.innerHTML = '<p>¿Cómo seguimos?</p>'
        + WA_OPTIONS.map((opt, i) => `<button type="button" role="menuitem" data-i="${i}">${opt.label}</button>`).join('')
        + '<button type="button" class="wa-picker-skip" role="menuitem" data-i="skip">Escribir sin elegir</button>';
      document.body.appendChild(panel);
      const rect = link.getBoundingClientRect();
      const panelWidth = panel.offsetWidth;
      const panelHeight = panel.offsetHeight;
      const left = Math.min(Math.max(8, rect.left), window.innerWidth - panelWidth - 8);
      const spaceBelow = window.innerHeight - rect.bottom;
      const top = spaceBelow > panelHeight + 12 ? rect.bottom + 8 : Math.max(8, rect.top - panelHeight - 8);
      panel.style.left = left + 'px';
      panel.style.top = top + 'px';
      waPanel = panel;
      link.setAttribute('aria-expanded', 'true');
      panel.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', () => {
          const i = btn.dataset.i;
          const message = i === 'skip' ? base : intro + ' ' + WA_OPTIONS[+i].suffix;
          url.searchParams.set('text', message);
          track('whatsapp_click', { placement: link.dataset.wa, page_path: location.pathname, qualified: i === 'skip' ? 'skip' : WA_OPTIONS[+i].key });
          window.open(url.toString(), '_blank', 'noopener');
          closeWaPanel();
          link.setAttribute('aria-expanded', 'false');
        });
      });
      panel.querySelector('button')?.focus();
    });
  });
  document.addEventListener('click', event => { if (waPanel && !event.target.closest('.wa-picker') && !event.target.closest('a[data-wa]')) closeWaPanel(); });
  addEventListener('scroll', closeWaPanel, { passive: true });
  addEventListener('keydown', event => { if (event.key === 'Escape' && waPanel) closeWaPanel(); });
  const thanks = document.querySelector('[data-thanks]');
  if (thanks && /^(enviado|crm-confirmado)$/.test(thanks.dataset.thanks || '')) track('form_confirmed', { state: thanks.dataset.thanks });

  // Consentimiento de cookies
  let consent = null;
  try { consent = localStorage.getItem('obra-cookie-consent'); } catch (e) { consent = null; }
  const remember = value => { try { localStorage.setItem('obra-cookie-consent', value); } catch (e) { /* modo privado */ } };
  const banner = document.querySelector('[data-cookie]');
  const loadAnalytics = () => {
    if (!/^G-[A-Z0-9]+$/.test(analytics) || window.gtag) return;
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', analytics);
    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(analytics)}`;
    document.head.appendChild(script);
  };
  if (consent === 'accepted') loadAnalytics();
  if (!consent && banner && analytics) banner.hidden = false;
  banner?.querySelector('[data-cookie-accept]')?.addEventListener('click', () => { remember('accepted'); banner.hidden = true; loadAnalytics(); });
  banner?.querySelector('[data-cookie-deny]')?.addEventListener('click', () => { remember('necessary'); banner.hidden = true; });
})();
