function create_slide_show(container, interval) {
    let slides = Array.from(container.querySelectorAll('.slide'));
    let origSlideClassName = slides[0].className;
    let dots = Array.from(container.querySelectorAll('.dots'));
    let origDotClassName = dots[0].className;

    function showSlide(ind = null) {
        if (ind != null) {
            showSlide.index = ind;
        } else {
            showSlide.index = showSlide.index || 0;
        }
        if (showSlide.index == slides.length) showSlide.index = 0;
        if (showSlide.index < 0) showSlide.index = slides.length - 1;
        for(let i = 0; i < slides.length; i++) {
            if (i == showSlide.index) {
                slides[showSlide.index].className += ' active';
                dots[showSlide.index].className += ' active';
            } else {
                slides[i].className = origSlideClassName;
                dots[i].className = origDotClassName;
            }
        }
        showSlide.index++;
    }

    container.querySelector('#prev_slide').addEventListener('click', function(e) {
        clearInterval(resource);
        showSlide(showSlide.index - 2);
        resource = setInterval(showSlide, interval);
    });
    container.querySelector('#next_slide').addEventListener('click', function(e) {
        clearInterval(resource);
        showSlide(showSlide.index);
        resource = setInterval(showSlide, interval);
    });
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
        clearInterval(resource);
        showSlide(i);
        resource = setInterval(showSlide, interval);
        });
    });

    showSlide(0);
    let resource = setInterval(showSlide, interval);
}