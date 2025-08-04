<h2 class="text-2xl font-semibold mb-6 text-gray-800 border-b pb-3">Detail Transaksi</h2>

<dl class="divide-y divide-gray-200 max-w-full">
    <div class="py-3 flex justify-between items-center">
        <dt class="text-gray-700 text-base font-medium">Nasabah</dt>
        <dd class="text-gray-900 text-base">{{ $transaksi->nasabah->nama ?? '-' }}</dd>
    </div>

    <div class="py-3 flex justify-between items-center">
        <dt class="text-gray-700 text-base font-medium">Jenis Transaksi</dt>
        <dd class="text-gray-900 text-base capitalize">{{ $transaksi->jenis_transaksi }}</dd>
    </div>

    @if ($transaksi->jenis_transaksi === 'masuk')
        <div class="py-3 flex justify-between items-center">
            <dt class="text-gray-700 text-base font-medium">Jenis Sampah</dt>
            <dd class="text-gray-900 text-base">{{ $transaksi->jenisSampah->nama ?? '-' }}</dd>
        </div>
        <div class="py-3 flex justify-between items-center">
            <dt class="text-gray-700 text-base font-medium">Berat (Kg)</dt>
            <dd class="text-gray-900 text-base">{{ $transaksi->berat ?? '-' }}</dd>
        </div>
        <div class="py-3 flex justify-between items-center">
            <dt class="text-gray-700 text-base font-medium">Harga per Kg</dt>
            <dd class="text-gray-900 text-base">Rp {{ number_format($transaksi->harga_per_kg ?? 0, 2, ',', '.') }}</dd>
        </div>
    @endif

    <div class="py-3 flex justify-between items-center">
        <dt class="text-gray-700 text-base font-medium">
            {{ $transaksi->jenis_transaksi === 'keluar' ? 'Jumlah Penarikan' : 'Subtotal' }}
        </dt>
        <dd class="text-gray-900 text-base">
            {{ $transaksi->jenis_transaksi === 'keluar' ? '-' : '' }}
            Rp {{ number_format($transaksi->subtotal, 2, ',', '.') }}
        </dd>
    </div>

    <div class="py-3 flex justify-between items-center">
        <dt class="text-gray-700 text-base font-medium">Tanggal</dt>
        <dd class="text-gray-900 text-base">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</dd>
    </div>
</dl>
