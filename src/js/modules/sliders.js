import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

// Crónicas slider.
const cronicasSlider = document.querySelector('.swiper-cronicas');

if (cronicasSlider) {
  new Swiper(cronicasSlider, {
    modules: [Pagination, Autoplay],
    loop: true,
    slidesPerView: 2,
    spaceBetween: 16,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-cronicas-pagination',
      clickable: true,
    },
    breakpoints: {
      640: { slidesPerView: 3, spaceBetween: 20 },
      1024: { slidesPerView: 5, spaceBetween: 24 },
    },
  });
}
