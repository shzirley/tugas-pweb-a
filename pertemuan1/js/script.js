document.addEventListener("scroll", function() {
  const elements = document.querySelectorAll(".reveal");
  const windowHeight = window.innerHeight;
  
  elements.forEach(el => {
    const elementTop = el.getBoundingClientRect().top;
    if (elementTop < windowHeight - 100) {
      el.classList.add("active");
    }
  });
});
