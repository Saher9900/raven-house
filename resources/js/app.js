import "./bootstrap";
import { initCart } from "./cart";
import Swiper from "swiper";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

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

    document.querySelectorAll("[data-featured-products-swiper]").forEach((element) => {
        const section = element.closest(".featured-products");
        const originalSlides = [...element.querySelectorAll(".swiper-slide")];
        const productCount = originalSlides.length;
        const maxSlidesPerView = 2;
        const slidesPerGroup = 1;
        const loopAdditionalSlides = productCount > 1 ? 1 : 0;
        const minimumLoopSlides =
            maxSlidesPerView + slidesPerGroup + loopAdditionalSlides;
        const prefersReducedMotion = window.matchMedia(
            "(prefers-reduced-motion: reduce)",
        ).matches;

        if (productCount > 1 && productCount < minimumLoopSlides) {
            originalSlides.forEach((originalSlide) => {
                const clone = originalSlide.cloneNode(true);

                clone.setAttribute("aria-hidden", "true");
                clone.setAttribute("data-featured-loop-copy", "");
                clone
                    .querySelectorAll("a, button, input, select, textarea, [tabindex]")
                    .forEach((interactiveElement) =>
                        interactiveElement.setAttribute("tabindex", "-1"),
                    );
                element.querySelector(".swiper-wrapper").append(clone);
            });
        }

        const swiper = new Swiper(element, {
            modules: [Autoplay, Navigation, Pagination],
            slidesPerView: 1,
            slidesPerGroup,
            centeredSlides: true,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    centeredSlides: false,
                },
            },
            loop: productCount > 1,
            loopAdditionalSlides,
            speed: 700,
            threshold: 8,
            touchAngle: 45,
            autoplay:
                productCount > 1 && !prefersReducedMotion
                    ? {
                          delay: 4000,
                          disableOnInteraction: false,
                          pauseOnMouseEnter: true,
                      }
                    : false,
            navigation: {
                prevEl: section.querySelector('[data-featured-direction="-1"]'),
                nextEl: section.querySelector('[data-featured-direction="1"]'),
            },
            pagination: {
                el: section.querySelector("[data-featured-products-pagination]"),
                clickable: true,
                renderBullet: (index, className) =>
                    index < productCount
                        ? `<span class="${className}" data-featured-page="${index}"></span>`
                        : "",
            },
        });

        const updateActivePage = () => {
            const activePage = swiper.realIndex % productCount;

            section
                .querySelectorAll("[data-featured-page]")
                .forEach((bullet, index) => {
                    bullet.classList.toggle(
                        "swiper-pagination-bullet-active",
                        index === activePage,
                    );
                });
        };

        swiper.on("realIndexChange", updateActivePage);
        updateActivePage();
    });

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
