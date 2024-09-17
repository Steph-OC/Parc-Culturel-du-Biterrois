document.addEventListener('DOMContentLoaded', function() {
    const titles = document.querySelectorAll('.entry-title');

    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target); // Stop observing once the animation is triggered
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, {
        root: null,
        threshold: 0.1 
    });

    titles.forEach(title => {
        observer.observe(title);
    });
});
