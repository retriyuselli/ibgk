@php
    $membershipTypes = [
        [
            'title' => 'Anggota Tetap',
            'text' => 'Alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan yang menjadi bagian permanen keluarga besar IBGK Sumsel.',
            'icon' => 'group',
        ],
        [
            'title' => 'Anggota Tidak Tetap',
            'text' => 'Peserta aktif dalam pembinaan atau rangkaian program pemilihan yang sedang berjalan pada periode tertentu.',
            'icon' => 'user',
        ],
        [
            'title' => 'Anggota Kehormatan',
            'text' => 'Tokoh atau pihak yang memberikan kontribusi istimewa bagi organisasi dan ditetapkan secara resmi oleh IBGK Sumsel.',
            'icon' => 'star',
        ],
    ];
@endphp

<section class="relative bg-white py-16 sm:py-20 lg:py-24 overflow-hidden">
    <div class="site-container grid gap-6 lg:grid-cols-2 lg:gap-8">
        <div class="rounded-lg bg-navy p-7 text-white sm:p-9">
            <h2 class="font-display text-2xl font-semibold text-gold sm:text-3xl">Jenis Keanggotaan</h2>
            <div class="mt-8 space-y-7">
                @foreach ($membershipTypes as $type)
                    <div class="flex gap-4">
                        <span class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-gold/40 text-gold">
                            @if ($type['icon'] === 'group')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
                            @elseif ($type['icon'] === 'user')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M16 19v-1a3 3 0 00-3-3H7a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/></svg>
                            @else
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5l1.76 3.56 3.93.57-2.84 2.77.67 3.91-3.52-1.85-3.52 1.85.67-3.91-2.84-2.77 3.93-.57L11.48 3.5z"/></svg>
                            @endif
                        </span>
                        <div>
                            <h3 class="font-semibold tracking-wide text-gold">{{ $type['title'] }}</h3>
                            <p class="mt-2 text-sm leading-relaxed text-white/75">{{ $type['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative overflow-hidden rounded-lg border border-gold/25 bg-cream p-7 sm:p-9">
            <div class="pointer-events-none absolute inset-y-0 right-0 w-40 opacity-[0.07] text-gold" aria-hidden="true">
                <svg class="h-full w-full" viewBox="0 0 100 160" fill="currentColor">
                    <path d="M50 8c12 18 28 28 28 52 0 24-16 36-28 52-12-16-28-28-28-52C22 36 38 26 50 8z"/>
                </svg>
            </div>

            <h2 class="font-display text-2xl font-semibold text-navy sm:text-3xl">Anggota Kehormatan</h2>
            <div class="mt-3 h-px w-16 bg-gold"></div>
            <p class="mt-4 text-sm leading-relaxed text-muted">
                Anggota kehormatan ditetapkan atas kontribusi istimewa terhadap perjalanan dan reputasi IBGK Sumatera Selatan.
            </p>

            <ol class="relative mt-8 space-y-4">
                @forelse ($honoraryMembers as $index => $member)
                    <li class="flex items-start gap-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-navy text-xs font-semibold text-gold">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <p class="font-semibold text-navy">{{ $member->name }}</p>
                            <p class="text-xs text-muted sm:text-sm">
                                {{ $member->title ?: ($member->description ?: 'Anggota Kehormatan IBGK Sumsel') }}
                            </p>
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-muted">Data anggota kehormatan belum tersedia.</li>
                @endforelse
            </ol>
        </div>
    </div>
</section>
