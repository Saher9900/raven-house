@extends('website.layout.main')
@section('content')
    <main class="pt-5">
        <section class="hero-glow page-hero py-5 mt-4">
            <div class="container text-center py-3 reveal">
                <p class="section-eyebrow">Get in Touch</p>
                <div class="luxury-divider" aria-hidden="true"><span>◆</span></div>
                <h1 class="font-display display-4 fw-bold text-white mt-3">Contact Us</h1>
                <p class="text-muted-raven col-lg-6 mx-auto mt-2">Questions, orders, or a private fitting — we are here for
                    you.</p>
            </div>
        </section>

        <section class="pb-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-6">
                        <div class="card-raven rounded-4 p-4 p-md-5 mb-4">
                            <h2 class="font-display h3 fw-semibold text-white">Visit the Boutique</h2>
                            <address class="text-muted-raven mt-3 mb-0 lh-lg">
                                42 Luxe Avenue<br>
                                Fashion District<br>
                                Cairo, Egypt
                            </address>
                        </div>
                        <div class="card-raven rounded-4 p-4 mb-4">
                            <h2 class="font-display h3 fw-semibold text-white">Reach Out</h2>
                            <ul class="list-unstyled text-muted-raven mt-3 mb-0">
                                <li class="mb-3">
                                    <span class="text-gold text-uppercase small">Email</span><br>
                                    <a href="mailto:hello@ravenhouse.com"
                                        class="text-muted-raven text-decoration-none">hello@ravenhouse.com</a>
                                </li>
                                <li class="mb-3">
                                    <span class="text-gold text-uppercase small">Phone</span><br>
                                    <a href="tel:+201234567890" class="text-muted-raven text-decoration-none">+20 123 456
                                        7890</a>
                                </li>
                                <li>
                                    <span class="text-gold text-uppercase small">Hours</span><br>
                                    Mon – Sat: 10:00 – 21:00<br>
                                    Sun: 12:00 – 18:00
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex gap-3">
                            <a href="#"
                                class="social-btn rounded-circle d-flex align-items-center justify-content-center"
                                aria-label="Instagram">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="social-btn rounded-circle d-flex align-items-center justify-content-center"
                                aria-label="Facebook">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <form class="card-raven rounded-4 p-4 p-lg-5" action="#" method="post">
                            <h2 class="font-display h3 fw-semibold text-white">Send a Message</h2>
                            <div class="mt-4">
                                <label for="name" class="form-label text-muted-raven small">Full Name</label>
                                <input type="text" class="form-control input-dark rounded-3" id="name"
                                    name="name" required placeholder="Your name">
                            </div>
                            <div class="mt-3">
                                <label for="email" class="form-label text-muted-raven small">Email</label>
                                <input type="email" class="form-control input-dark rounded-3" id="email"
                                    name="email" required placeholder="you@example.com">
                            </div>
                            <div class="mt-3">
                                <label for="subject" class="form-label text-muted-raven small">Subject</label>
                                <select class="form-select input-dark rounded-3" id="subject" name="subject">
                                    <option value="general">General inquiry</option>
                                    <option value="perfumes">Perfumes</option>
                                    <option value="sunglasses">Sunglasses</option>
                                    <option value="appointment">Book appointment</option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="message" class="form-label text-muted-raven small">Message</label>
                                <textarea class="form-control input-dark rounded-3" id="message" name="message" rows="5" required
                                    placeholder="How can we help?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-gold rounded-3 mt-4 px-5 py-2">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
