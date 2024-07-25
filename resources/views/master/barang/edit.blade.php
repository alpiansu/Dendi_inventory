@extends('adminlte::page')

@section('title', 'Edit Barang')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-4">
                    <div class="card-header">Form Edit Barang</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="barangForm" action="{{ route('master.barang.update', $masterData->KodeBarang) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="KodeBarang">Kode Barang</label>
                                <input type="text" class="form-control @error('KodeBarang') is-invalid @enderror" id="KodeBarang" name="KodeBarang" value="{{ old('KodeBarang', $masterData->KodeBarang) }}" readonly>
                                @error('KodeBarang')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="NamaItem">Nama Item</label>
                                <input type="text" class="form-control @error('NamaItem') is-invalid @enderror" id="NamaItem" name="NamaItem" value="{{ old('NamaItem', $masterData->NamaItem) }}" required>
                                @error('NamaItem')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Harga">Harga</label>
                                <input type="number" class="form-control @error('Harga') is-invalid @enderror" id="Harga" name="Harga" value="{{ old('Harga', $masterData->Harga) }}" required>
                                @error('Harga')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div id="barcode-container">
                                @foreach ($masterBarcodes as $index => $barcode)
                                    <div class="form-group row barcode-row">
                                        <div class="col-md-5">
                                            <label for="JenisBarcode">Jenis Barcode</label>
                                            <select class="form-control @error('JenisBarcode') is-invalid @enderror" name="JenisBarcode[]">
                                                @foreach ($jenisBarcodes as $jenis)
                                                    <option value="{{ $jenis->kodeJenis }}" {{ $jenis->kodeJenis == $barcode->kodeJenis ? 'selected' : '' }}>
                                                        {{ $jenis->JenisBarcode }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="BarcodeBarang">Nilai Barcode</label>
                                            <input type="text" class="form-control @error('BarcodeBarang') is-invalid @enderror" name="BarcodeBarang[]" value="{{ old('BarcodeBarang.' . $index, $barcode->BarcodeBarang) }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Action</label>
                                            <button type="button" class="btn btn-danger remove-barcode">Hapus</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-barcode" class="btn btn-secondary mt-2">Tambah Barcode</button>
                            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                            <button type="button" class="btn btn-warning btnback mt-2">Kembali</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const barcodeContainer = document.getElementById('barcode-container');
            const addBarcodeButton = document.getElementById('add-barcode');
            const barangForm = document.getElementById('barangForm');
            const jenisBarcodes = @json($jenisBarcodes);

            addBarcodeButton.addEventListener('click', function () {
                const barcodeRows = document.querySelectorAll('.barcode-row');
                const usedJenis = Array.from(barcodeRows).map(row => row.querySelector('select').value);
                const availableJenis = jenisBarcodes.filter(jenis => !usedJenis.includes(jenis.kodeJenis));

                if (availableJenis.length === 0) {
                    alert('Semua jenis barcode sudah dipilih.');
                    return;
                }

                const newRow = document.createElement('div');
                newRow.classList.add('form-group', 'row', 'barcode-row');
                newRow.innerHTML = `
                    <div class="col-md-5">
                        <label for="JenisBarcode">Jenis Barcode</label>
                        <select class="form-control" name="JenisBarcode[]">
                            ${availableJenis.map(jenis => `<option value="${jenis.kodeJenis}">${jenis.JenisBarcode}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="BarcodeBarang">Nilai Barcode</label>
                        <input type="text" class="form-control" name="BarcodeBarang[]" required>
                    </div>
                    <div class="col-md-2">
                        <label>Action</label>
                        <button type="button" class="btn btn-danger remove-barcode">Hapus</button>
                    </div>
                `;

                barcodeContainer.appendChild(newRow);
                updateRemoveButtons();
            });

            function updateRemoveButtons() {
                const removeButtons = document.querySelectorAll('.remove-barcode');
                removeButtons.forEach(button => {
                    button.removeEventListener('click', removeBarcodeRow);
                    button.addEventListener('click', removeBarcodeRow);
                });
            }

            function removeBarcodeRow(event) {
                const button = event.target;
                const row = button.closest('.barcode-row');
                row.remove();
                updateRemoveButtons();
            }

            // Pastikan semua input terisi sebelum submit
            barangForm.addEventListener('submit', function (event) {
                const inputs = barangForm.querySelectorAll('input[required], select[required]');
                for (let input of inputs) {
                    if (!input.value) {
                        event.preventDefault();
                        alert('Semua inputan harus terisi.');
                        return;
                    }
                }
            });

            updateRemoveButtons();
        });
    </script>
@stop
