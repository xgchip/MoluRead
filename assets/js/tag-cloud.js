/* Accessible rotating link cloud; no library and no external requests. */
(() => {
  'use strict';
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
  document.querySelectorAll('[data-hh-tag-cloud]').forEach(cloud => {
    const links = [...cloud.querySelectorAll('a')];
    const button = cloud.parentElement.querySelector('.hh-tag-toggle');
    if (links.length < 2 || !button) return;
    let frame = 0, angle = 0, last = 0, paused = false, hover = false, focus = false, visible = true;
    const points = links.map((_, i) => {
      const y = 1 - 2 * (i + .5) / links.length;
      const r = Math.sqrt(1 - y * y), phi = i * Math.PI * (3 - Math.sqrt(5));
      return [Math.cos(phi) * r, y, Math.sin(phi) * r];
    });
    function draw() {
      const radius = Math.max(48, Math.min(82, (cloud.clientWidth - 100) / 2));
      links.forEach((link, i) => {
        const [x, y, z] = points[i], rx = x * Math.cos(angle) - z * Math.sin(angle);
        const rz = x * Math.sin(angle) + z * Math.cos(angle), scale = .86 + (rz + 1) * .13;
        link.style.transform = `translate(-50%, -50%) translate(${rx * radius}px, ${y * 82}px) scale(${scale})`;
        link.style.opacity = String(.65 + (rz + 1) * .175);
        link.style.zIndex = String(Math.round((rz + 1) * 20));
      });
    }
    function canRun() { return !reduced.matches && !paused && !hover && !focus && visible && !document.hidden; }
    function tick(now) {
      frame = 0;
      if (!canRun()) { last = 0; return; }
      if (last) angle += Math.min(now - last, 40) * .00009;
      last = now; draw(); frame = requestAnimationFrame(tick);
    }
    function sync() {
      cancelAnimationFrame(frame); frame = 0; last = 0;
      cloud.classList.toggle('is-dynamic', !reduced.matches);
      button.hidden = reduced.matches;
      if (reduced.matches) links.forEach(link => { link.style.transform = ''; link.style.opacity = ''; link.style.zIndex = ''; });
      else { draw(); if (canRun()) frame = requestAnimationFrame(tick); }
    }
    button.addEventListener('click', () => {
      paused = !paused; button.textContent = paused ? '继续动态' : '暂停动态';
      button.setAttribute('aria-pressed', String(paused)); sync();
    });
    cloud.addEventListener('pointerenter', () => { hover = true; sync(); });
    cloud.addEventListener('pointerleave', () => { hover = false; sync(); });
    cloud.addEventListener('focusin', () => { focus = true; sync(); });
    cloud.addEventListener('focusout', event => { focus = cloud.contains(event.relatedTarget); sync(); });
    reduced.addEventListener('change', sync);
    document.addEventListener('visibilitychange', sync);
    if ('IntersectionObserver' in window) new IntersectionObserver(entries => { visible = entries[0].isIntersecting; sync(); }).observe(cloud);
    if ('ResizeObserver' in window) new ResizeObserver(sync).observe(cloud);
    sync();
  });
})();
