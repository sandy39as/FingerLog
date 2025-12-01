<x-app-layout>
    <div class="max-w-5xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Log Mentah Finger per Karyawan</h2>

        {{-- Filter --}}
        <form method="GET" action="{{ route('absensi.logMentah') }}" class="mb-6 flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Karyawan</label>
                <select name="karyawan_id" class="border rounded p-1 min-w-[200px]">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($karyawans as $k)
                        <option value="{{ $k->id }}" @selected($selectedId == $k->id)>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $selectedTanggal ?? date('Y-m-d') }}"
                       class="border rounded p-1">
            </div>

            <div>
                <button class="px-4 py-2 bg-emerald-600 text-white rounded">
                    Tampilkan Log
                </button>
            </div>
        </form>

        @if ($logs->count() === 0 && $selectedId && $selectedTanggal)
            <div class="p-3 bg-yellow-100 text-yellow-800 rounded">
                Tidak ada log mentah untuk karyawan & tanggal ini.
            </div>
        @endif

        @if ($logs->count() > 0)
            @if ($absen)
                <div class="mb-4 p-3 bg-blue-50 rounded text-sm">
                    <p><strong>Rekap Dipakai:</strong></p>
                    <p>Masuk: {{ $absen->jam_masuk ?? '-' }},
                       Istirahat: {{ $absen->jam_istirahat_mulai ?? '-' }} - {{ $absen->jam_istirahat_selesai ?? '-' }},
                       Pulang: {{ $absen->jam_pulang ?? '-' }}</p>
                </div>
            @endif

            <div class="bg-white shadow rounded p-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700">
                            <th class="p-2">Waktu Finger</th>
                            <th class="p-2">Jam</th>
                            <th class="p-2">Dipakai Sebagai</th>
                            <th class="p-2">Sumber</th>
                            <th class="p-2">No. Mesin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            @php
                                $time = \Carbon\Carbon::parse($log->waktu_finger)->format('H:i:s');
                                $label = $usedBy[$time] ?? null;
                            @endphp
                            <tr class="border-b {{ $label ? 'bg-emerald-50' : '' }}">
                                <td class="p-2">{{ $log->waktu_finger }}</td>
                                <td class="p-2">{{ $time }}</td>
                                <td class="p-2">
                                    @if ($label)
                                        <span class="px-2 py-1 text-xs rounded
                                            @if ($label === 'Masuk') bg-blue-100 text-blue-800
                                            @elseif (str_contains($label, 'Istirahat')) bg-yellow-100 text-yellow-800
                                            @elseif ($label === 'Pulang') bg-purple-100 text-purple-800
                                            @endif
                                        ">
                                            {{ $label }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">Tidak dipakai</span>
                                    @endif
                                </td>
                                <td class="p-2">{{ $log->sumber ?? '-' }}</td>
                                <td class="p-2">{{ $log->no_mesin ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
