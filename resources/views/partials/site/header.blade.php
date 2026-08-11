@php
    $profile = $profile ?? null;
    $isHome = request()->routeIs('home');
    $isAbout = request()->routeIs('about');
    $isElection = request()->routeIs('election');
    $isAlumni = request()->routeIs('alumni');
    $isActivities = request()->routeIs('activities');
    $isNews = request()->routeIs('news');
    $isGallery = request()->routeIs('gallery');
    $isPartnership = request()->routeIs('partnership', 'partnership.show');
    $isContact = request()->routeIs('contact');
    $isRegister = request()->routeIs('register');
    $isLogin = request()->routeIs('login');
    $isDashboard = request()->routeIs('dashboard');
@endphp

<header class="sticky top-0 z-50 border-b border-white/10 bg-navy/95 backdrop-blur-md">
    <div class="site-container flex h-[4.25rem] items-center justify-between gap-4 lg:h-[4.75rem]">
        <a href="{{ route('home') }}" class="group flex shrink-0 items-center" aria-label="{{ $profile->short_name ?? 'IBGK Sumatera Selatan' }}">
            @if (filled($profile?->logo))
                <img
                    src="{{ asset('storage/'.$profile->logo) }}"
                    alt="{{ $profile->short_name ?? 'IBGK Sumatera Selatan' }}"
                    class="h-10 w-auto max-w-[11rem] object-contain transition group-hover:opacity-90 sm:h-11 sm:max-w-[13rem]"
                >
            @else
                <span class="flex h-10 w-10 items-center justify-center rounded-full border border-gold/50 bg-navy-soft text-gold">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3l2.2 4.4L19 8.2l-3.5 3.4.8 4.7L12 14.2 7.7 16.3l.8-4.7L5 8.2l4.8-.8L12 3z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                        <path d="M7 19h10" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                    </svg>
                </span>
            @endif
        </a>

        <nav class="hidden items-center gap-4 xl:gap-5 lg:flex" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" @class(['nav-link', 'nav-link-active' => $isHome])>Beranda</a>
            <a href="{{ route('about') }}" @class(['nav-link', 'nav-link-active' => $isAbout])>Tentang IBGK</a>
            <a href="{{ route('election') }}" @class(['nav-link', 'nav-link-active' => $isElection])>Pemilihan BGK</a>
            <a href="{{ route('alumni') }}" @class(['nav-link', 'nav-link-active' => $isAlumni])>Alumni</a>
            <a href="{{ route('activities') }}" @class(['nav-link', 'nav-link-active' => $isActivities])>Kegiatan</a>
            <a href="{{ route('news') }}" @class(['nav-link', 'nav-link-active' => $isNews])>Berita</a>
            <a href="{{ route('gallery') }}" @class(['nav-link', 'nav-link-active' => $isGallery])>Galeri</a>
            <a href="{{ route('partnership') }}" @class(['nav-link', 'nav-link-active' => $isPartnership])>Kemitraan</a>
            <a href="{{ route('contact') }}" @class(['nav-link', 'nav-link-active' => $isContact])>Kontak</a>
        </nav>

        <div class="flex items-center gap-2 sm:gap-3">
            @auth
                <a
                    href="{{ route('dashboard') }}"
                    @class(['btn-outline-light-sm hidden lg:inline-flex', 'border-gold text-gold' => $isDashboard])
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    @class(['btn-outline-light-sm hidden lg:inline-flex', 'border-gold text-gold' => $isLogin])
                >
                    Masuk
                </a>
                <a
                    href="{{ route('register') }}"
                    @class(['btn-gold-sm hidden lg:inline-flex', 'ring-2 ring-white/30' => $isRegister])
                >
                    Daftar
                </a>
            @endauth

            <button
                type="button"
                id="mobile-nav-toggle"
                class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-white/20 text-white lg:hidden"
                aria-expanded="false"
                aria-controls="mobile-nav"
                aria-label="Buka menu"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-nav" class="hidden border-t border-white/10 bg-navy lg:hidden">
        <nav class="site-container flex flex-col gap-1 py-4" aria-label="Navigasi mobile">
            <a href="{{ route('home') }}" @class(['rounded-md px-3 py-2.5 text-sm font-medium', $isHome ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Beranda</a>
            <a href="{{ route('about') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isAbout ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Tentang IBGK</a>
            <a href="{{ route('election') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isElection ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Pemilihan BGK</a>
            <a href="{{ route('alumni') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isAlumni ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Alumni</a>
            <a href="{{ route('activities') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isActivities ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Kegiatan</a>
            <a href="{{ route('news') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isNews ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Berita</a>
            <a href="{{ route('gallery') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isGallery ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Galeri</a>
            <a href="{{ route('partnership') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isPartnership ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Kemitraan</a>
            <a href="{{ route('contact') }}" @class(['mobile-nav-link rounded-md px-3 py-2.5 text-sm font-medium', $isContact ? 'text-gold' : 'text-white/90 hover:bg-white/5'])>Kontak</a>
            <div class="mt-3 grid grid-cols-2 gap-2 border-t border-white/10 pt-4">
                @auth
                    <a
                        href="{{ route('dashboard') }}"
                        @class(['rounded-md border px-3 py-2.5 text-center text-sm font-semibold transition sm:col-span-2', $isDashboard ? 'border-gold bg-gold/10 text-gold' : 'border-white/25 text-white hover:border-gold hover:text-gold'])
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        @class(['rounded-md border px-3 py-2.5 text-center text-sm font-semibold transition', $isLogin ? 'border-gold bg-gold/10 text-gold' : 'border-white/25 text-white hover:border-gold hover:text-gold'])
                    >
                        Masuk
                    </a>
                    <a
                        href="{{ route('register') }}"
                        @class(['rounded-md px-3 py-2.5 text-center text-sm font-semibold text-navy-deep', $isRegister ? 'bg-gold-light ring-2 ring-white/30' : 'bg-gold'])
                    >
                        Daftar
                    </a>
                @endauth
            </div>
        </nav>
    </div>
</header>
