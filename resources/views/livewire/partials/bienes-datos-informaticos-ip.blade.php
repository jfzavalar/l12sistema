{{-- <fieldset class="border p-4 rounded">
    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Bien informático</legend> --}}
    <div class="row g-3">
        <div class="col-lg-12 col-sm-12">
            <div class="input-group">
            @can('procesos.informatica.ips.create')
                @if ($btn_guardar_actualizar === "guardar")
                    <button type="button" class="btn btn-{{ $btn_guardar_actualizar_color}} btn-sm" wire:click="buscar_bienes">
                        <i class="fa-brands fa-searchengin"></i> Buscar
                    </button>                                                
                @endif
            @endcan
            <input type="text" id="txt_equipo_detalle" class="form-control form-control-sm bg-light" wire:model="equipo_detalle" readonly>
        </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <label for="txt_cod_pat" class="form-label"><strong>Código patrimonial</strong></label>
            <input type="text" id="txt_cod_pat" class="form-control form-control-sm text-uppercase {{ $cod_pat ? 'bg-light' : '' }}" wire:model="cod_pat" {{ $ip ? 'readonly' : '' }} required>
            @error('cod_pat')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-8 col-sm-12">
            <label for="txt_desc_ubif" class="form-label"><strong>Ubicación física</strong></label>
            <input type="text" id="txt_desc_ubif" class="form-control form-control-sm text-uppercase bg-light" wire:model="desc_ubif" readonly required>
            @error('desc_ubif')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-4 col-sm-12">
            <label for="txt_marca" class="form-label"><strong>Marca</strong></label>
            <input type="text" id="txt_marca" class="form-control form-control-sm text-uppercase" wire:model="marca" required>
            @error('marca')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-4 col-sm-12">
            <label for="txt_modelo" class="form-label"><strong>Modelo</strong></label>
            <input type="text" id="txt_modelo" class="form-control form-control-sm text-uppercase" wire:model="modelo" required>
            @error('modelo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-4 col-sm-12">
            <label for="txt_serie" class="form-label"><strong>SERIE</strong></label>
            <input type="text" id="txt_serie" class="form-control form-control-sm text-uppercase" wire:model="serie" required>
            @error('serie')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
{{-- </fieldset> --}}