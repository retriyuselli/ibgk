document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('mobile-nav-toggle');
    const mobileNav = document.getElementById('mobile-nav');

    if (toggle && mobileNav) {
        toggle.addEventListener('click', () => {
            const isOpen = !mobileNav.classList.contains('hidden');
            mobileNav.classList.toggle('hidden', isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
            toggle.setAttribute('aria-label', isOpen ? 'Buka menu' : 'Tutup menu');
        });

        mobileNav.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                mobileNav.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Buka menu');
            });
        });
    }

    const track = document.getElementById('alumni-track');
    const prev = document.getElementById('alumni-prev');
    const next = document.getElementById('alumni-next');

    if (track && prev && next) {
        const scrollByCard = (direction) => {
            const card = track.querySelector('.alumni-card');
            const amount = card ? card.getBoundingClientRect().width + 16 : 240;
            track.scrollBy({ left: direction * amount, behavior: 'smooth' });
        };

        prev.addEventListener('click', () => scrollByCard(-1));
        next.addEventListener('click', () => scrollByCard(1));
    }

    const galleryTrack = document.getElementById('gallery-track');
    const galleryPrev = document.getElementById('gallery-prev');
    const galleryNext = document.getElementById('gallery-next');

    if (galleryTrack && galleryPrev && galleryNext) {
        const scrollGallery = (direction) => {
            const card = galleryTrack.querySelector('.alumni-card');
            const amount = card ? card.getBoundingClientRect().width + 16 : 280;
            galleryTrack.scrollBy({ left: direction * amount, behavior: 'smooth' });
        };

        galleryPrev.addEventListener('click', () => scrollGallery(-1));
        galleryNext.addEventListener('click', () => scrollGallery(1));
    }

    const previewTrack = document.getElementById('preview-track');
    const previewPrev = document.getElementById('preview-prev');
    const previewNext = document.getElementById('preview-next');

    if (previewTrack && previewPrev && previewNext) {
        const scrollPreview = (direction) => {
            const card = previewTrack.querySelector('.alumni-card');
            const amount = card ? card.getBoundingClientRect().width + 16 : 260;
            previewTrack.scrollBy({ left: direction * amount, behavior: 'smooth' });
        };

        previewPrev.addEventListener('click', () => scrollPreview(-1));
        previewNext.addEventListener('click', () => scrollPreview(1));
    }

    const partnerPages = document.querySelectorAll('[data-partner-page]');
    const partnerDots = document.querySelectorAll('[data-partner-dot]');
    const partnerPrev = document.getElementById('partner-prev');
    const partnerNext = document.getElementById('partner-next');

    if (partnerPages.length > 0) {
        let activePartnerPage = 0;

        const showPartnerPage = (index) => {
            activePartnerPage = (index + partnerPages.length) % partnerPages.length;

            partnerPages.forEach((page, pageIndex) => {
                page.classList.toggle('hidden', pageIndex !== activePartnerPage);
            });

            partnerDots.forEach((dot) => {
                const isActive = Number(dot.dataset.partnerDot) === activePartnerPage;
                dot.classList.toggle('bg-gold', isActive);
                dot.classList.toggle('bg-navy/20', !isActive);
            });
        };

        partnerPrev?.addEventListener('click', () => showPartnerPage(activePartnerPage - 1));
        partnerNext?.addEventListener('click', () => showPartnerPage(activePartnerPage + 1));

        partnerDots.forEach((dot) => {
            dot.addEventListener('click', () => showPartnerPage(Number(dot.dataset.partnerDot)));
        });
    }

    document.querySelectorAll('.history-section, .journey-section, .stages-section, .participants-section').forEach((section) => {
        if (section.classList.contains('is-visible')) {
            return;
        }

        const revealSection = () => section.classList.add('is-visible');

        if (!('IntersectionObserver' in window)) {
            revealSection();
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                revealSection();
                observer.unobserve(section);
            });
        }, { threshold: 0.2, rootMargin: '0px 0px -40px 0px' });

        observer.observe(section);
    });
});
