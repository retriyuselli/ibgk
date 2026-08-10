<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.auth.decorative-shapes', ['variant' => 'dark', 'density' => 'rich'])

    <div class="site-container relative z-[2] py-12 sm:py-14 lg:py-16">
        <div class="hero-animate max-w-3xl">
            <p class="text-xs font-semibold tracking-[0.18em] text-gold uppercase">Dashboard Pengguna</p>
            <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight sm:text-4xl">
                Selamat datang, {{ $user->name }}
            </h1>
            <p class="mt-4 text-sm leading-relaxed text-white/80 sm:text-base">
                Kelola akses akun Anda dan lanjutkan ke fitur IBGK Sumsel dari sini.
            </p>
        </div>
    </div>
</section>
