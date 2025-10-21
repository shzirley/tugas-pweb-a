// Carousel scroll function
function scrollCarousel(direction) {
    const container = document.getElementById('menuScroll');
    // Sesuaikan nilai scrollAmount dengan lebar kartu menu + gap
    const scrollAmount = 320; 
    
    if (direction === 'next') {
        container.scrollLeft += scrollAmount;
    } else {
        container.scrollLeft -= scrollAmount;
    }
}

// Event listeners setelah DOM terload
document.addEventListener('DOMContentLoaded', function() {
    // Order button handler
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('order-btn')) {
            const menuName = e.target.closest('.menu-card').querySelector('h4').textContent;
            alert(`Pesanan "${menuName}" ditambahkan! Hubungi kami di 0822-3292-3145 untuk menyelesaikan pesanan.`);
        }
    });

    // Form submission handler
    const reservationForm = document.getElementById('reservationForm');
    if (reservationForm) {
        reservationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Terima kasih! Reservasi Anda telah kami terima. Tim kami akan segera menghubungi Anda.');
            this.reset();
        });
    }

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});