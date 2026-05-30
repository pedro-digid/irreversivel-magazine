import { gsap } from 'gsap';

const panel = document.getElementById('mobile-menu-panel');

if (panel) {
  const overlay = panel.querySelector('[data-mobile-menu-overlay]');
  const drawer = panel.querySelector('.mobile-menu__panel');
  const toggleBtn = document.querySelector('[data-mobile-menu-toggle]');
  const closeBtn = panel.querySelector('[data-mobile-menu-close]');

  let isOpen = false;
  let focusableEls = [];
  let lastFocusedEl = null;

  function open() {
    if (isOpen) return;
    isOpen = true;
    lastFocusedEl = document.activeElement;

    panel.hidden = false;
    toggleBtn.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';

    // Animate in.
    gsap.fromTo(overlay, { opacity: 0 }, { opacity: 1, duration: 0.3, ease: 'power2.out' });
    gsap.fromTo(drawer, { x: '100%' }, {
      x: '0%',
      duration: 0.4,
      ease: 'power3.out',
      onComplete: () => {
        // Focus first menu link.
        focusableEls = panel.querySelectorAll('a, button, [tabindex]:not([tabindex="-1"])');
        if (focusableEls.length) focusableEls[0].focus();
      },
    });
  }

  function close() {
    if (!isOpen) return;
    isOpen = false;
    toggleBtn.setAttribute('aria-expanded', 'false');

    gsap.to(overlay, { opacity: 0, duration: 0.25, ease: 'power2.in' });
    gsap.to(drawer, {
      x: '100%',
      duration: 0.3,
      ease: 'power3.in',
      onComplete: () => {
        panel.hidden = true;
        document.body.style.overflow = '';
        if (lastFocusedEl) lastFocusedEl.focus();
      },
    });
  }

  // Event listeners.
  toggleBtn.addEventListener('click', open);
  closeBtn.addEventListener('click', close);
  overlay.addEventListener('click', close);

  // Close on Escape.
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen) close();
  });

  // Trap focus inside panel.
  panel.addEventListener('keydown', (e) => {
    if (e.key !== 'Tab' || !isOpen) return;

    const first = focusableEls[0];
    const last = focusableEls[focusableEls.length - 1];

    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
    }
  });
}
