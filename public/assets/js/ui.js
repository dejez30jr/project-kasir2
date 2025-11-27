// Minimal UI interactions: page fade-in and reveal on scroll
(function(){
  const onReady = () => {
    document.body.classList.add('is-ready');
    // Reveal animations
    const els = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
      const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('in');
            obs.unobserve(e.target);
          }
        });
      }, { threshold: 0.08, rootMargin: '40px' });
      els.forEach(el => obs.observe(el));
    } else {
      els.forEach(el => el.classList.add('in'));
    }
  };
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onReady);
  } else {
    onReady();
  }
})();
