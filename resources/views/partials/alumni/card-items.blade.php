@foreach ($alumni as $person)
    <article class="overflow-hidden border border-navy/8 bg-white shadow-sm transition hover:border-gold/35">
        <div class="relative">
            {!! site_image_or_storage($person->photo, 'images/home/alumni-placeholder.jpg', $person->name, ['class' => 'aspect-[3/4] w-full object-cover']) !!}
            <span class="absolute top-3 right-3 flex h-8 w-8 items-center justify-center rounded-full bg-navy/85 text-gold backdrop-blur-sm" title="{{ $person->gender === 'female' ? 'Gadis' : 'Bujang' }}">
                @if ($person->gender === 'female')
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="5"/><path stroke-linecap="round" d="M14 14l6 6M16 20h4v-4"/></svg>
                @else
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="14" r="5"/><path stroke-linecap="round" d="M14 6l4-4m0 0h-4m4 0v4"/></svg>
                @endif
            </span>
        </div>
        <div class="px-4 py-4">
            <h4 class="font-semibold text-navy">{{ $person->name }}</h4>
            <p class="mt-1 text-xs text-muted">{{ $person->university ?: '—' }}</p>
            <p class="mt-0.5 text-xs font-medium text-navy/70">{{ $person->profession ?: 'Alumni IBGK' }}</p>
            <a href="{{ route('alumni.show', $person) }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold tracking-[0.12em] text-gold uppercase hover:text-navy">
                Lihat Profil
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </article>
@endforeach
