<div class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">

    <div>
        <p class="text-sm font-semibold">Dashboard</p>
        <p class="text-xs text-gray-500">Ringkasan peserta & indikator layanan</p>
    </div>

    <div class="flex items-center gap-3">
        @if(!empty($available_years))
            <form method="GET">
                <select name="year"
                        class="h-9 rounded-lg border-gray-300 text-sm"
                        onchange="this.form.submit()">
                    @foreach($available_years as $year)
                        <option value="{{ $year }}" @selected($year == $selected_year)>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>
        @endif
    </div>

</div>
