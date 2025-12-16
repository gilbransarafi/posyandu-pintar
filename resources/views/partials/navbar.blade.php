<div class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">

    <div>
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
