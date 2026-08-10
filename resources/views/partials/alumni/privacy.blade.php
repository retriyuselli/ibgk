<div class="mt-10 flex flex-col items-start justify-between gap-4 border border-gold/25 bg-cream-muted px-5 py-5 sm:flex-row sm:items-center sm:px-6">
    <div class="flex items-start gap-3">
        <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-gold/40 text-gold">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-4-6V9a4 4 0 118 0v2m-9 0h10a2 2 0 012 2v6a2 2 0 01-2 2H7a2 2 0 01-2-2v-6a2 2 0 012-2z"/></svg>
        </span>
        <div>
            <p class="text-sm font-semibold text-navy">Privasi Data Alumni</p>
            <p class="mt-1 text-xs leading-relaxed text-muted sm:text-sm">
                Email dan nomor telepon tidak ditampilkan secara publik. Ajukan pembaruan data melalui kanal resmi IBGK Sumsel.
            </p>
        </div>
    </div>

    <a href="{{ route('contact') }}" class="btn-outline-gold shrink-0 whitespace-nowrap">
        Ajukan Pembaruan Data
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
    </a>
</div>
