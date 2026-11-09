<div class="col-lg-12">

    {{-- each all error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group mb-3">
        <label for="Nomor kontrak">Nomor Kontrak</label>
        <input name="code" type="text" class="form-control @error('code') is-invalid @enderror" id="code"
            placeholder="Nomor Kontrak" value="{{ old('code') ?? (!isset($contract) ? '' : $contract->code) }}">
        @error('code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3" id="contract-select">
        <label for="Jenis Kontrak">Jenis Kontrak</label>
        <select class="form-select @error('type') is-invalid @enderror" name="type"
            aria-label="Default select example" id="contract_type">

            @isset($contract)
                <option value="" disabled>Pilih jenis kontrak ...</option>
                @foreach ($contractTypes as $type)
                    <option value="{{ $type }}" {{ $type == $contract->type ? 'selected' : '' }}>{{ $type }}
                    </option>
                @endforeach
            @else
                <option value="" disabled selected>Pilih jenis kontrak ...</option>
                @foreach ($contractTypes as $type)
                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}
                    </option>
                @endforeach

            @endisset

        </select>
        @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <hr>

    <div class="form-group mb-3">
        <label for="name">Vendor</label>
        <select class="form-select @error('vendor_id') is-invalid @enderror" name="vendor_id"
            aria-label="Default select example">

            @isset($contract)

                <option value="" disabled>Pilih vendor ...</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ $vendor->id == $contract->vendor_id ? 'selected' : '' }}>
                        {{ $vendor->name }}</option>
                @endforeach
            @else
                <option value="" disabled selected>Pilih vendor ...</option>
                @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                        {{ $vendor->name }}</option>
                @endforeach

            @endisset


        </select>
        @error('vendor_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3" id="status">
        <label for="Status">Status</label>
        <select class="form-select @error('status') is-invalid @enderror" name="status"
            aria-label="Default select example" id="contract_type">

            @isset($contract)
                <option value="" disabled>Pilih status ...</option>
                @foreach ($contractStatus as $status)
                    <option value="{{ $status }}" {{ $status == $contract->status ? 'selected' : '' }}>{{ $status }}
                    </option>
                @endforeach
            @else
                <option value="" disabled selected>Pilih status ...</option>
                @foreach ($contractStatus as $status)
                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>{{ $status }}
                    </option>
                @endforeach

            @endisset

        </select>
        @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="Subject">Subject</label>
        <input name="subject" type="text" class="form-control @error('subject') is-invalid @enderror" id="subject"
            placeholder="Subject Kontrak"
            value="{{ old('subject') ?? (!isset($contract) ? '' : $contract->subject) }}">
        @error('subject')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <hr>
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 mb-3">
            <label for="Mulai masa berlaku kontrak">Mulai masa berlaku kontrak</label>
            <input name="active_date_start" type="date"
                class="form-control @error('active_date_start') is-invalid @enderror" id="active_date_start"
                placeholder="Kode Erp"
                value="{{ old('active_date_start') ?? (!isset($contract) ? '' : $contract->active_date_start) }}">
            @error('active_date_start')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 mb-3">
            <label for="Akhir masa berlaku kontrak">Akhir masa berlaku kontrak</label>
            <input name="active_date_end" type="date"
                class="form-control @error('active_date_end') is-invalid @enderror" id="active_date_end"
                placeholder="Kode Erp"
                value="{{ old('active_date_end') ?? (!isset($contract) ? '' : $contract->active_date_end) }}">
            @error('active_date_end')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3" hidden>
        <div class="col-lg-6 col-sm-6 col-md-6 mb-3">
            <label for="Mulai masa berlaku garansi">Mulai masa berlaku garansi (optional)</label>
            <input name="warranty_date_start" type="date"
                class="form-control @error('warranty_date_start') is-invalid @enderror" id="warranty_date_start"
                placeholder="Kode Erp"
                value="{{ old('warranty_date_start') ?? (!isset($contract) ? '' : $contract->warranty_date_start) }}">
            @error('warranty_date_start')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>


        <div class="col-lg-6 col-sm-6 col-md-6 mb-3">
            <label for="Akhri mas berlaku garansi">Akhir masa berlaku garansi (optional)</label>
            <input name="warranty_date_end" type="date"
                class="form-control @error('warranty_date_end') is-invalid @enderror" id="warranty_date_end"
                placeholder="Kode Erp"
                value="{{ old('warranty_date_end') ?? (!isset($contract) ? '' : $contract->warranty_date_end) }}">
            @error('warranty_date_end')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <label for="Mulai masa berlaku garansi">Masa garansi dalam hari (optional)</label>
            <input name="warranty_in_days" type="number"
                class="form-control @error('warranty_in_days') is-invalid @enderror" id="warranty_in_days"
                placeholder="Input angka"
                value="{{ old('warranty_in_days') ?? (!isset($contract) ? '' : $contract->warranty_in_days) }}"
                min="0">
            @error('warranty_in_days')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-12">
            <label for="Mulai masa berlaku garansi">Masa garansi dalam bulan (optional)</label>
            <input name="warranty_in_month" type="number"
                class="form-control @error('warranty_in_month') is-invalid @enderror" id="warranty_in_month"
                placeholder="Input angka"
                value="{{ old('warranty_in_month') ?? (!isset($contract) ? '' : $contract->warranty_in_month) }}"
                min="0">
            @error('warranty_in_month')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

</div>

@push('scripts')
    <script>
        const contractTypeEl = document.getElementById('contract_type');

        contractTypeEl.addEventListener('change', function() {
            if (this.value == 'Upgrade & Repair') {

                createElement();

            } else {

                removeElement();

            }
        })

        // on load
        if (contractTypeEl.value == 'Upgrade & Repair') {

            createElement();

        } else {

            removeElement();

        }


        function createElement() {
            // create element form-group after this element
            const formGroup = document.createElement('div');
            // add id
            formGroup.id = 'input-price-upgrade';
            formGroup.classList.add('form-group');
            formGroup.classList.add('mb-3');
            formGroup.classList.add('row');
            formGroup.innerHTML = `
                    <div class="col-lg-12">
                        <label for="Mulai masa berlaku garansi">Harga upgrade container</label>
                        <input name="upgrade_price" type="price" class="form-control @error('upgrade_price') is-invalid @enderror" id="upgrade_price" placeholder="Input angka" value="{{ old('upgrade_price') ?? (!isset($contract) ? '' : $contract->upgrade_price) }}" min="0">
                        @error('upgrade_price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                `;

            const parentEl = document.getElementById('contract_type').parentElement;
            parentEl.insertAdjacentElement('afterend', formGroup);
        }

        function removeElement() {
            const formGroup = document.getElementById('input-price-upgrade');
            if (formGroup) {
                formGroup.remove();
            }
        }
    </script>
@endpush
