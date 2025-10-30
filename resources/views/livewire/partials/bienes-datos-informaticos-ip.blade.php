{{-- <fieldset class="border p-4 rounded">
    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Bien informático</legend> --}}
    <div class="row g-3">
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <label for="txt_equipo_detalle" class="form-label"><strong>Bien</strong></label>
            <div class="input-group">
                @can('procesos.informatica.ips.create')
                    @if ($btn_guardar_actualizar === "guardar")
                        <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color}} btn-xs" wire:click="buscar_bienes">
                            <i class="fa-brands fa-searchengin"></i>
                        </button>                                                
                    @endif
                @endcan
                <input type="text" id="txt_equipo_detalle" class="form-control form-control-xs bg-light" wire:model="equipo_detalle" readonly>
            </div>
        </div>
        <div class="col-xl-2 col-lg-6 col-sm-12">
            <label for="txt_cod_pat" class="form-label"><strong>CPatrimonial</strong></label>
            <input type="text" id="txt_cod_pat" class="form-control form-control-xs text-uppercase {{ $cod_pat ? 'bg-light' : '' }}" wire:model="cod_pat" {{ $ip ? 'readonly' : '' }} required>
            @error('cod_pat')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-12">
            <label for="txt_desc_ubif" class="form-label"><strong>Ubicación física</strong></label>
            <input type="text" id="txt_desc_ubif" class="form-control form-control-xs text-uppercase bg-light" wire:model="desc_ubif" readonly required>
            @error('desc_ubif')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xl-1 col-lg-6 col-sm-12">
            <label for="txt_marca" class="form-label fw-bold text-danger">Marca</label>
            <input type="text" id="txt_marca" class="form-control form-control-xs text-uppercase" wire:model="marca" required>
            @error('marca')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xl-1 col-lg-6 col-sm-12">
            <label for="txt_modelo" class="form-label fw-bold text-danger">Modelo</label>
            <input type="text" id="txt_modelo" class="form-control form-control-xs text-uppercase" wire:model="modelo" required>
            @error('modelo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xl-1 col-lg-6 col-sm-12">
            <label for="txt_serie" class="form-label fw-bold text-danger">SERIE</label>
            <input type="text" id="txt_serie" class="form-control form-control-xs text-uppercase" wire:model="serie" required>
            @error('serie')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
{{-- </fieldset> --}}