{{-- <fieldset class="border p-4 rounded">
    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Bien informático</legend> --}}
    <div class="row g-3">
        <div class="col-lg-3 col-sm-12">
            <label for="txt_pecosa" class="form-label"><strong>N° Pecosa</strong></label>
            <input type="text" id="txt_pecosa" class="form-control form-control-sm text-uppercase " wire:model="nro_pecosa" required>
            @error('nro_pecosa')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="cmd_clase" class="form-label"><strong>Clase</strong></label>
            <select id="cmd_clase" class="form-select form-select-sm" wire:model.change="clase">
                <option value="">Seleccionar...</option>
                @foreach ($lista_clases as $clase)
                    <option value="{{ $clase->clase }}">{{ $clase->clase }}</option>
                @endforeach
            </select>
            @error('clase')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="cmd_famlia" class="form-label"><strong>Familia</strong></label>
            <select id="cmd_famlia" class="form-select form-select-sm" wire:model="familia">
                <option value="">Seleccionar...</option>
                @foreach ($lista_familias as $familia)
                    <option value="{{ $familia->familia }}">{{ $familia->familia }}</option>
                @endforeach
            </select>
            @error('familia')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="txt_cod_pat" class="form-label"><strong>Código patrimonial</strong></label>
            <input type="text" id="txt_cod_pat" class="form-control form-control-sm text-uppercase " wire:model="cod_pat" required>
            @error('cod_pat')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row g-3">       
        <div class="col-lg-3 col-sm-12">
            <label for="txt_cod_barra" class="form-label"><strong>Código de barra</strong></label>
            <input type="text" id="txt_cod_barra" class="form-control form-control-sm text-uppercase" wire:model="cod_barra" required>
            @error('cod_barra')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="txt_bien" class="form-label"><strong>Bien</strong></label>
            <input type="text" id="txt_bien" class="form-control form-control-sm text-uppercase " wire:model="bien" required>
            @error('bien')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="txtmarca" class="form-label"><strong>Marca</strong></label>
            <input type="text" id="txtmarca" class="form-control form-control-sm text-uppercase" wire:model="marca" required>
            @error('marca')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="txtmodelo" class="form-label"><strong>Modelo</strong></label>
            <input type="text" id="txtmodelo" class="form-control form-control-sm text-uppercase" wire:model="modelo" required>
            @error('modelo')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="row g-3">       
        <div class="col-lg-3 col-sm-12">
            <label for="txtserie" class="form-label"><strong>Serie</strong></label>
            <input type="text" id="txtserie" class="form-control form-control-sm text-uppercase" wire:model="serie" required>
            @error('serie')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="txt_medidas" class="form-label"><strong>Medidas</strong></label>
            <input type="text" id="txt_medidas" class="form-control form-control-sm text-uppercase" wire:model="medidas" required>
            @error('medidas')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="txt_modelo" class="form-label"><strong>Color</strong></label>
            <input type="text" id="txt_modelo" class="form-control form-control-sm text-uppercase" wire:model="color" required>
            @error('color')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="txt_estado" class="form-label"><strong>Estado</strong></label>
            <input type="text" id="txt_estado" class="form-control form-control-sm text-uppercase" wire:model="estado" required>
            @error('estado')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
{{-- </fieldset> --}}