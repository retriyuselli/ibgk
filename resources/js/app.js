document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('site-theme-toggle');
    const allowedThemes = ['classic', 'festival'];
    const themeStorageKey = 'ibgk-site-theme';

    const currentSiteTheme = () => {
        const theme = document.documentElement.getAttribute('data-site-theme');

        return allowedThemes.includes(theme) ? theme : 'classic';
    };

    const syncThemeToggle = (theme) => {
        if (! themeToggle) {
            return;
        }

        const nextTheme = theme === 'festival' ? 'classic' : 'festival';
        const nextLabel = nextTheme === 'festival' ? 'Tema Festival' : 'Tema Klasik';

        themeToggle.setAttribute('aria-label', `Ganti ke ${nextLabel}`);
        themeToggle.setAttribute('title', `Ganti ke ${nextLabel}`);
    };

    const applySiteTheme = (theme) => {
        const nextTheme = allowedThemes.includes(theme) ? theme : 'classic';

        document.documentElement.setAttribute('data-site-theme', nextTheme);

        try {
            localStorage.setItem(themeStorageKey, nextTheme);
        } catch (e) {}

        syncThemeToggle(nextTheme);
    };

    syncThemeToggle(currentSiteTheme());

    themeToggle?.addEventListener('click', () => {
        applySiteTheme(currentSiteTheme() === 'festival' ? 'classic' : 'festival');
    });

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

    const scheduleTrack = document.getElementById('schedule-track');
    const schedulePrev = document.getElementById('schedule-prev');
    const scheduleNext = document.getElementById('schedule-next');

    if (scheduleTrack && schedulePrev && scheduleNext) {
        const scrollSchedule = (direction) => {
            const card = scheduleTrack.querySelector('.alumni-card');
            const amount = card ? card.getBoundingClientRect().width + 16 : 208;
            scheduleTrack.scrollBy({ left: direction * amount, behavior: 'smooth' });
        };

        schedulePrev.addEventListener('click', () => scrollSchedule(-1));
        scheduleNext.addEventListener('click', () => scrollSchedule(1));
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

    document.querySelectorAll('.history-section, .journey-section, .stages-section, .participants-section, .footer-section, .board-section, .board-about-section').forEach((section) => {
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

    const alumniGrid = document.getElementById('alumni-grid');
    const alumniLoadMore = document.getElementById('alumni-load-more');
    const alumniLoadMoreWrap = document.getElementById('alumni-load-more-wrap');

    if (alumniGrid && alumniLoadMore) {
        alumniLoadMore.addEventListener('click', async () => {
            const nextPage = alumniLoadMore.dataset.nextPage;

            if (!nextPage) {
                return;
            }

            const originalLabel = alumniLoadMore.textContent;
            alumniLoadMore.disabled = true;
            alumniLoadMore.textContent = 'Memuat...';

            const url = new URL(window.location.href);
            url.searchParams.set('page', nextPage);

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Failed to load alumni');
                }

                const data = await response.json();

                alumniGrid.insertAdjacentHTML('beforeend', data.html);

                if (data.has_more && data.next_page) {
                    alumniLoadMore.dataset.nextPage = String(data.next_page);
                    alumniLoadMore.disabled = false;
                    alumniLoadMore.textContent = originalLabel;
                } else if (alumniLoadMoreWrap) {
                    alumniLoadMoreWrap.remove();
                }
            } catch {
                alumniLoadMore.disabled = false;
                alumniLoadMore.textContent = originalLabel;
            }
        });
    }

    const maxPhotoDimension = 1000;
    const photoQuality = 0.82;

    const compressImageFile = (file, maxDimension, quality) => new Promise((resolve, reject) => {
        if (! file.type.startsWith('image/') || file.type === 'image/svg+xml') {
            resolve(file);
            return;
        }

        const image = new Image();
        const objectUrl = URL.createObjectURL(file);

        image.onload = () => {
            URL.revokeObjectURL(objectUrl);

            const longest = Math.max(image.width, image.height);
            const scale = longest > maxDimension ? maxDimension / longest : 1;
            const width = Math.max(1, Math.round(image.width * scale));
            const height = Math.max(1, Math.round(image.height * scale));
            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;

            const context = canvas.getContext('2d');
            context.fillStyle = '#ffffff';
            context.fillRect(0, 0, width, height);
            context.drawImage(image, 0, 0, width, height);

            canvas.toBlob((blob) => {
                if (! blob) {
                    reject(new Error('Gagal mengompres foto.'));
                    return;
                }

                const name = file.name.replace(/\.[^.]+$/, '.jpg');
                resolve(new File([blob], name, { type: 'image/jpeg', lastModified: Date.now() }));
            }, 'image/jpeg', quality);
        };

        image.onerror = () => {
            URL.revokeObjectURL(objectUrl);
            resolve(file);
        };

        image.src = objectUrl;
    });

    const boardTabs = document.querySelectorAll('[data-board-tab]');
    const boardPanels = document.querySelectorAll('[data-board-panel]');

    if (boardTabs.length > 0 && boardPanels.length > 0) {
        boardTabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.boardTab;

                boardTabs.forEach((item) => {
                    const active = item === tab;
                    item.classList.toggle('is-active', active);
                    item.setAttribute('aria-selected', String(active));
                });

                boardPanels.forEach((panel) => {
                    const active = panel.dataset.boardPanel === target;
                    panel.classList.toggle('hidden', !active);
                    panel.hidden = !active;
                    panel.classList.remove('board-panel-enter');

                    if (active) {
                        void panel.offsetWidth;
                        panel.classList.add('board-panel-enter');
                    }
                });
            });
        });
    }

    const boardMore = document.getElementById('board-more');
    const boardMoreToggle = document.getElementById('board-more-toggle');

    if (boardMore && boardMoreToggle) {
        boardMoreToggle.addEventListener('click', () => {
            const expanded = boardMoreToggle.getAttribute('aria-expanded') === 'true';
            boardMoreToggle.setAttribute('aria-expanded', String(!expanded));
            boardMore.classList.toggle('hidden', expanded);
            boardMore.hidden = expanded;
            boardMore.classList.toggle('is-open', !expanded);

            const label = boardMoreToggle.querySelector('[data-board-more-label]');
            if (label) {
                label.textContent = expanded ? 'Lihat Selengkapnya' : 'Sembunyikan';
            }

            boardMoreToggle.querySelector('[data-board-more-icon]')?.classList.toggle('rotate-180', !expanded);
        });
    }

    document.querySelectorAll('input[data-compress-image]').forEach((input) => {
        input.addEventListener('change', async () => {
            const file = input.files?.[0];
            const status = input.parentElement?.querySelector('[data-compress-status]');

            if (! file) {
                return;
            }

            if (status) {
                status.textContent = 'Mengompres foto...';
            }

            try {
                const compressed = await compressImageFile(file, maxPhotoDimension, photoQuality);
                const transfer = new DataTransfer();
                transfer.items.add(compressed);
                input.files = transfer.files;

                if (status) {
                    const sizeKb = Math.max(1, Math.round(compressed.size / 1024));
                    status.textContent = `Foto dikompres ke ukuran standar (${sizeKb} KB).`;
                }
            } catch {
                if (status) {
                    status.textContent = 'Foto akan dikompres otomatis di server.';
                }
            }
        });
    });
});
