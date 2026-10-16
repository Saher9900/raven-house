import "./bootstrap";
import { initCart } from "./cart";

document.addEventListener("DOMContentLoaded", () => {
    initCart();

    document.addEventListener("click", (event) => {
        const thumbnail = event.target.closest("[data-gallery-image]");

        if (!thumbnail) {
            return;
        }

        const mainImage = document.getElementById(thumbnail.dataset.galleryTarget);

        if (!mainImage) {
            return;
        }

        mainImage.src = thumbnail.dataset.galleryImage;
        mainImage.alt = thumbnail.dataset.galleryAlt;

        document
            .querySelectorAll(`[data-gallery-target="${thumbnail.dataset.galleryTarget}"]`)
            .forEach((button) => {
                button.setAttribute("aria-pressed", String(button === thumbnail));
            });
    });

    const header = document.getElementById("site-header");
    if (header) {
        const onScroll = () => {
            header.classList.toggle("header-scrolled", window.scrollY > 40);
        };
        onScroll();
        window.addEventListener("scroll", onScroll, { passive: true });
    }

    const revealEls = document.querySelectorAll(".reveal");
    if (
        revealEls.length &&
        !window.matchMedia("(prefers-reduced-motion: reduce)").matches
    ) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: "0px 0px -40px 0px" },
        );
        revealEls.forEach((el) => observer.observe(el));
    } else {
        revealEls.forEach((el) => el.classList.add("is-visible"));
    }
});
