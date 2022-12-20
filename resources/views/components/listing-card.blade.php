@props(['listing'])


<x-card>
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block"
            src="{{ $listing->logo ? asset('storage/' . $listing->logo) : asset('images/card.png') }}" alt="" />
        <div>
            <h3 class="text-2xl underline leading-9 underline-offset-4 font-serif pb-4">
                <a href="/listings/{{ $listing->id }}">{{ $listing->title }}</a>
            </h3>
            <div class="text-xl font-bold mb-4 font-mono">{{ $listing->company }}</div>
            <x-listing-tags :tagsCsv="$listing->tags" />
            <div class="text-lg mt-4 font-sans">
                <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
            </div>
        </div>
    </div>
</x-card>
