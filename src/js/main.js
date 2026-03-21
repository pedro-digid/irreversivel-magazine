// Styles (Tailwind + custom SASS).
import '../sass/main.sass';

// Smooth scroll.
import Lenis from 'lenis';

// GSAP + ScrollTrigger.
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

// Init Lenis and connect to GSAP.
const lenis = new Lenis();

lenis.on('scroll', ScrollTrigger.update);

gsap.ticker.add((time) => {
  lenis.raf(time * 1000);
});
gsap.ticker.lagSmoothing(0);

// Dark mode toggle.
const toggle = document.querySelector('[data-theme-toggle]');

if (toggle) {
  toggle.addEventListener('click', () => {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
  });
}
