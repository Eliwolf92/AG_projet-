document.addEventListener("DOMContentLoaded", () => {
    const scrollAmount = 310; 

    document.querySelectorAll(".carousel-next").forEach(button => {
        button.addEventListener("click", () => {
            const target = document.getElementById(button.dataset.target);
            target.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
    });

    document.querySelectorAll(".carousel-prev").forEach(button => {
        button.addEventListener("click", () => {
            const target = document.getElementById(button.dataset.target);
            target.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });
    });
});


document.addEventListener("DOMContentLoaded", () => {
    const scrollPourcentage = 1; 

    document.querySelectorAll(".carousel-suiv").forEach(button => {
        button.addEventListener("click", () => {
            const target = document.getElementById(button.dataset.target);
            const gab = 20;
            const scrollAmount = target.clientWidth * scrollPourcentage + gab ;
            target.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
    });

    document.querySelectorAll(".carousel-prec").forEach(button => {
        button.addEventListener("click", () => {
            const target = document.getElementById(button.dataset.target);
            const scrollAmount = target.clientWidth * scrollPourcentage;
            target.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });
    });
});