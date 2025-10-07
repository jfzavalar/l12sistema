<fieldset class="border p-4 rounded">
    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Detalles</legend>
    <div class="row g-3">
        <div class="col-lg-6 col-sm-12">
            <label for="txt_ip" class="form-label"><strong>IP</strong></label>
            <input type="text" id="txt_ip" class="form-control form-control-sm text-uppercase {{ $ip ? 'bg-light' : '' }}" wire:model="ip" {{ $ip ? 'readonly' : '' }}>
            @error('ip')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-lg-6 col-sm-12">
            <label for="cmb_sistema_operativo" class="form-label"><strong>Sistema operativo</strong></label>
            <select id="cmb_sistema_operativo" class="form-select form-select-sm" wire:model="sistema_operativo">
                <option selected>Seleccionar...</option>
                <option value="WINDOWS_10">WINDOWS_10</option>
                <option value="WINDOWS_11">WINDOWS_11</option>
            </select>
            @error('sistema_operativo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-6 col-sm-12">
            <label for="cmb_user_admin" class="form-label"><strong>Usuario administrador</strong></label>
            <select id="cmb_user_admin" class="form-select form-select-sm" wire:model="user_admin">
                <option selected>Seleccionar...</option>
                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                <option value="FISCALIA">FISCALIA</option>
                <option value="SOPORTE">SOPORTE</option>
            </select>
            @error('user_admin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-lg-6 col-sm-12">
            <label for="cmd_pass_admin" class="form-label"><strong>Password administrador</strong></label>
            <select id="cmd_pass_admin" class="form-select form-select-sm" wire:model="pass_admin">
                <option selected>Seleccionar...</option>
                <option value="informaticajunin@2024">informaticajunin@2024</option>
                <option value="redjunin@10000">redjunin@10000</option>
                <option value="redjunin@20000">redjunin@20000</option>
                <option value="redjunin@30000">redjunin@30000</option>
            </select>
            @error('pass_admin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <hr class="border-1">

    <div class="row g-3">
        <div class="col-lg-4 col-sm-12">
            <label for="cmb_impresora01" class="form-label"><strong>Impresora 01</strong></label>
            <select id="cmb_impresora01" class="form-select form-select-sm" wire:model="impresora01">
                <option selected>Seleccionar...</option>
                <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
            </select>
        </div>
        <div class="col-lg-4 col-sm-12">
            <label for="cmb_impresora02" class="form-label"><strong>Impresora 02</strong></label>
            <select id="cmb_impresora02" class="form-select form-select-sm" wire:model="impresora02">
                <option selected>Seleccionar...</option>
                <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
            </select>
        </div>
        <div class="col-lg-4 col-sm-12">
            <label for="cmb_impresora03" class="form-label"><strong>Impresora 03</strong></label>
            <select id="cmb_impresora03" class="form-select form-select-sm" wire:model="impresora03">
                <option selected>Seleccionar...</option>
                <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
            </select>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-4 col-sm-12">
            <label for="txt_ip_impresora01" class="form-label"><strong>IP Impresora 01</strong></label>
            <input id="txt_ip_impresora01" type="text" class="form-control form-control-sm" wire:model="ip_impresora01">
        </div>
        <div class="col-lg-4 col-sm-12">
            <label for="txt_ip_impresora02" class="form-label"><strong>IP Impresora 02</strong></label>
            <input id="txt_ip_impresora02" type="text" class="form-control form-control-sm" wire:model="ip_impresora02">
        </div>
        <div class="col-lg-4 col-sm-12">
            <label for="txt_ip_impresora03" class="form-label"><strong>IP Impresora 03</strong></label>
            <input id="txt_ip_impresora03" type="text" class="form-control form-control-sm" wire:model="ip_impresora03">
        </div>
    </div>
    <div class="row g-3">
        <div class="col-lg-12 col-sm-12">
            <label for="txt_observacion" class="form-label"><strong>Observación</strong></label>
            <input id="txt_observacion" type="text" class="form-control form-control-sm" wire:model="observacion">
        </div>
    </div>
</fieldset>