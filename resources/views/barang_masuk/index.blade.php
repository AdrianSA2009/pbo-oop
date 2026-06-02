@extends('layouts.app')

@section('title', 'Transaksi Barang Masuk')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">Input Barang Masuk</div>
            <div class="card-body">
                <form action="{{ route('barang_masuk.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_transaksi" class="form-label">ID Transaksi / Nomor Invoice</label>
                        <input type="text" class="form-control" id="kode_transaksi" name="kode_transaksi" placeholder="Contoh: BM-20231001" required>
                    </div>
                    <div class="mb-3">
                        <label for="karyawan_id" class="form-label">Petugas Lapangan (User)</label>
                        <select class="form-select" id="karyawan_id" name="karyawan_id" required>
                            <option value="" selected disabled>Pilih Petugas Penerima</option>
                            @if(isset($users))
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama }} ({{ $u->role }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier Pengirim</label>
                        <select class="form-select" id="supplier_id" name="supplier_id" required>
                            <option value="" selected disabled>Pilih Vendor / Supplier</option>
                            @if(isset($suppliers))
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Pilih Barang Elektronik</label>
                        <select class="form-select" id="barang_id" name="barang_id" required>
                            <option value="" selected disabled>Pilih Produk</option>
                            @if(isset($products))
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }} - [Stok: {{ $p->stok }}]</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Unit Masuk (Amount)</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Catat & Tambah Stok</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">Log / Riwayat Barang Masuk Gudang</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" style="font-size: 0.9rem;">
                        <thead>
                            <tr>
                                <th>ID Transaksi</th>
                                <th>Nama Barang</th>
                                <th>Supplier</th>
                                <th>Petugas</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($barang_masuk as $item)
                            <tr>
                                <td><strong>{{ $item->kode_transaksi }}</strong></td>
                                <td>{{ $item->barang->nama ?? 'Produk Dihapus' }}</td>
                                <td>{{ $item->supplier->nama ?? 'N/A' }}</td>
                                <td>{{ $item->pengguna->nama ?? 'N/A' }}</td>
                                <td><span class="badge bg-success">+ {{ $item->jumlah }} Unit</span></td>
                                <td>{{ date('d/m/Y', strtotime($item->tgl_masuk)) }}</td>
                                <td>
                                    <form action="{{ route('barang_masuk.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Membatalkan transaksi ini akan mengurangi stok barang terkait kembali. Lanjutkan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Batal</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">Belum ada riwayat pencatatan barang masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection