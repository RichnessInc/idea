function startCoumter(el) {
    let goal = el.dataset.goal;
    if (goal > 0) {
        let count = setInterval(() => {
            el.textContent++;
            if (el.textContent >= goal) {
                clearInterval(count);
            }
        }, 150);
    }
}