<div class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6">

    <div class="flex items-center gap-3">
        <button id="sidebar-toggle"
                class="inline-flex lg:hidden items-center justify-center h-10 w-10 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50"
                type="button" aria-label="Buka menu">
            <span class="sr-only">Toggle menu</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>

        <p class="text-sm font-semibold">Dashboard</p>
        <p class="text-xs text-gray-500">Ringkasan peserta & indikator layanan</p>
    </div>

    <div class="flex items-center gap-3">
        @php
            $yearsList = $available_years ?? [];
            $currentYear = $selected_year ?? $year ?? request('year', now()->year);
        @endphp

        @if(!empty($yearsList))
            <form method="GET">
                <select name="year"
                        class="h-9 rounded-lg border-gray-300 text-sm"
                        onchange="this.form.submit()">
                    @foreach($yearsList as $y)
                        <option value="{{ $y }}" @selected((int)$y === (int)$currentYear)>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </form>
        @endif
    </div>

</div>
