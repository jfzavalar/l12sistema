{{-- <fieldset class="border p-4 rounded">
    <legend class="float-none w-outo px-3 fs-6 fw-bold text-muted">Detalles</legend> --}}
    <div class="row g-3">
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <label for="txt_ip" class="form-label fw-bold text-danger">IP</label>
            <input type="text" id="txt_ip" class="form-control form-control-xs text-uppercase {{ $ip ? 'bg-light' : '' }}" wire:model="ip" {{ $ip ? 'readonly' : '' }}>
            @error('ip')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <label for="cmb_sistema_operativo" class="form-label fw-bold text-danger">Sistema operativo</label>
            <select id="cmb_sistema_operativo" class="form-select form-select-xs" wire:model="sistema_operativo">
                <option selected>Seleccionar...</option>
                <option value="WINDOWS_10">WINDOWS_10</option>
                <option value="WINDOWS_11">WINDOWS_11</option>
            </select>
            @error('sistema_operativo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <label for="cmb_user_admin" class="form-label fw-bold text-danger">Usuario administrador</label>
            <select id="cmb_user_admin" class="form-select form-select-xs" wire:model="user_admin">
                <option selected>Seleccionar...</option>
                <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                <option value="FISCALIA">FISCALIA</option>
                <option value="SOPORTE">SOPORTE</option>
            </select>
            @error('user_admin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xl-3 col-lg-6 col-sm-12">
            <label for="cmd_pass_admin" class="form-label fw-bold text-danger">Password administrador</label>
            <select id="cmd_pass_admin" class="form-select form-select-xs" wire:model="pass_admin">
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

        <hr class="border-1">

        <div class="row">
            <div class="col-xl-2 col-lg-6 col-sm-12">
                <label for="cmb_impresora01" class="form-label fw-bold">Impresora 01</label>
                <select id="cmb_impresora01" class="form-select form-select-xs" wire:model="impresora01">
                    <option selected>Seleccionar...</option>
                    <option value="Kyocera_FS_4300DN">Kyocera_FS_4300DN</option>
                    <option value="HP_LASERJET_P4015">HP_LASERJET_P4015</option>
                    <option value="Lexmark_MS_811_DN">Lexmark_MS_811_DN</option>
                    <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                    <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                    <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                    <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
                    <option value="TASKalfa_7001i">TASKalfa_7001i</opction>
                </select>
            </div>
            <div class="col-xl-2 col-lg-6 col-sm-12">
                <label for="txt_ip_impresora01" class="form-label fw-bold">IP Impresora 01</label>
                <input id="txt_ip_impresora01" type="text" class="form-control form-control-xs" wire:model="ip_impresora01">
            </div>
            <div class="col-xl-2 col-lg-6 col-sm-12">
                <label for="cmb_impresora02" class="form-label fw-bold">Impresora 02</label>
                <select id="cmb_impresora02" class="form-select form-select-sm" wire:model="impresora02">
                    <option selected>Seleccionar...</option>
                    <option value="Kyocera_FS_4300DN">Kyocera_FS_4300DN</option>
                    <option value="HP_LASERJET_P4015">HP_LASERJET_P4015</option>
                    <option value="Lexmark_MS_811_DN">Lexmark_MS_811_DN</option>
                    <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                    <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                    <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                    <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
                    <option value="TASKalfa_7001i">TASKalfa_7001i</opction>
                </select>
            </div>
            <div class="col-xl-2 col-lg-6 col-sm-12">
                <label for="txt_ip_impresora02" class="form-label fw-bold">IP Impresora 02</label>
                <input id="txt_ip_impresora02" type="text" class="form-control form-control-xs" wire:model="ip_impresora02">
            </div>
            <div class="col-xl-2 col-lg-6 col-sm-12">
                <label for="cmb_impresora03" class="form-label fw-bold">Impresora 03</label>
                <select id="cmb_impresora03" class="form-select form-select-sm" wire:model="impresora03">
                    <option selected>Seleccionar...</option>
                    <option value="Kyocera_FS_4300DN">Kyocera_FS_4300DN</option>
                    <option value="HP_LASERJET_P4015">HP_LASERJET_P4015</option>
                    <option value="Lexmark_MS_811_DN">Lexmark_MS_811_DN</option>
                    <option value="TASKalfa_5501i">TASKalfa_5501i</opction>
                    <option value="TASKalfa_6003i">TASKalfa_6003i</opction>
                    <option value="TASKalfa_6004i">TASKalfa_6004i</opction>
                    <option value="TASKalfa_6005i">TASKalfa_6005i</opction>
                    <option value="TASKalfa_7001i">TASKalfa_7001i</opction>
                </select>
            </div>
            <div class="col-xl-2 col-lg-6 col-sm-12">
                <label for="txt_ip_impresora03" class="form-label fw-bold">IP Impresora 03</label>
                <input id="txt_ip_impresora03" type="text" class="form-control form-control-xs" wire:model="ip_impresora03">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <label for="txt_observacion" class="form-label fw-bold">Observación</label>
                <input id="txt_observacion" type="text" class="form-control form-control-xs" wire:model="observacion">
            </div>
        </div>
    </div>
{{-- </fieldset> --}}