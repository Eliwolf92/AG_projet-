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
