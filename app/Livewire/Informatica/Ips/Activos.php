<?php

namespace App\Livewire\Informatica\Ips;

use App\Models\Tbl_biene;
use App\Models\Tbl_bienes_informativo;
use App\Models\Tbl_sede;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['ipActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';

    // Variables de Modal
    public $modal_abierto_personal = false;
    public $modal_abierto_personal_buscar = false;
    public $modal_abierto_bienes = false;
    public $modal_abierto_imagen = false;

    // Variables de tabla
    public $id_bien,$cod_pat,$cod_barra,$bien,$marca,$modelo,$serie,$medidas,$color,
            $est_cons,$cod_ubif,$desc_ubif,$cod_usuario,$desc_usuario,$desc_cargo,$clase,$familia,
            $observa,$df,$nro_pecosa,$doc_adq,$ndoc_adq,$fecha_adq,$acoddepofi,$coddepofi,$nomdepofi,
            $anomdepofi,$sedepofi,$codsedeofi,$nomsedeofi,$codsede1,$nomsede,$estadoofi,$codgbien,$estado,$codcat,$codgclase;
    public $ip,$user_admin,$pass_admin,$sistema_operativo,$impresora01,
            $ip_impresora01,$impresora02,$ip_impresora02,$impresora03,$ip_impresora03,
            $desplazamiento,$activo,$observacion,$created_user,$updated_user;

    public $personal_detalle,$equipo_detalle;
    public $dni,$datos,$cel_personal,$correo_personal;

    public $avatar;
    public $codsede,$coddependencia;
    public $filtro_dependencia,$filtro_ip;

    //Buscar
    public $searcha;
    public function updatingSearcha(){
        $this->resetPage();
    }

    public $searchbien;
    public function updatingSearchbien(){
        $this->resetPage();
    }


    public function render()
    {
        $lista_activos = Tbl_biene::where('activo','1')
            ->where('clase', 'COMPUTO')
            ->whereIn('familia', [
                'COMPUTADORA PERSONAL PORTATIL',
                'UNIDAD CENTRAL DE PROCESO - CPU'
            ])
            ->whereNotIn('nomsedeofi', [
                'CASA ACOGIDA TAMBO'
            ])
            ->when($this->filtro_dependencia, function ($query) {
                $query->where('nomsedeofi', $this->filtro_dependencia);
            })
            ->when($this->filtro_ip !== null, function ($query) {
                if ($this->filtro_ip === "1") {
                    // Con IP
                    $query->whereNotNull('ip');
                } elseif ($this->filtro_ip === "0") {
                    // Sin IP
                    $query->whereNull('ip');
                }
            })
            ->when($this->searcha, function ($query) {
                $query->where(function ($q) {
                    $q->where('cod_usuario', 'like', '%' . $this->searcha . '%')
                    ->orWhere('cod_pat', 'like', '%' . $this->searcha . '%')
                    ->orWhere('ip','like','%' . $this->searcha . '%');
                });
            })
            ->orderBy('desc_usuario', 'desc')
            ->paginate(12);

        $lista_sedes = Tbl_sede::select('codsedeofi','nomsedeofi')
            ->where('activo','1')
            ->distinct()
            ->orderBy('nomsedeofi')
            ->get();
            
        $lista_dependencias = Tbl_sede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->when($this->codsede, function($query, $codsede) {
                $query->where('codsedeofi', $codsede);
            })
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        //Lista Nombre Sede Oficina
            $lista_sedes_dependencias_despachos = Tbl_biene::select('nomsedeofi', DB::raw('COUNT(cod_pat) as total'))
            ->where('activo', '1')
            ->where('clase', 'COMPUTO')
            ->whereIn('familia', [
                'COMPUTADORA PERSONAL PORTATIL',
                'UNIDAD CENTRAL DE PROCESO - CPU'
            ])
            ->whereNotIn('nomsedeofi', [
                    'CASA ACOGIDA TAMBO'
                ])
            ->groupBy('nomsedeofi')
            ->get();

        $lista_bienes = Tbl_biene::where('activo','1')
            ->where('clase','CÓMPUTO')
            ->where('cod_pat','like','%' . $this->searchbien . '%')
            ->orderBy('id','desc')
            ->paginate(10);
        

        return view('livewire.informatica.ips.activos',
                compact('lista_activos','lista_bienes',
                'lista_sedes','lista_dependencias','lista_sedes_dependencias_despachos')
            );
    }

    // Reglas de validación de variables

    protected function rules(){
        return [
            'cod_pat' => 'required|string|unique:tbl_bienes,cod_pat,' . $this->id_bien,
            'desc_ubif' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'serie' => 'required',
            'ip' => 'required|unique:tbl_bienes,ip' . $this->ip,
            'sistema_operativo' => 'required',
            'user_admin' => 'required',
            'pass_admin' => 'required',
        ];
    }

    protected $messages = [
        'cod_pat.required' => 'El código patrimonial es obligatorio.',
        'cod_pat.unique' => 'El código patrimonial ya fue registrado.',
        'desc_ubif.required'  => 'La ubicación física es obligatorio.',
        'marca.required'=> 'La marca es obligatorio.',
        'modelo.required'=> 'El modelo es obligatorio.',
        'serie.required'=> 'La serie es obligatorio.',
        'ip.required' => 'La ip es obligatorio.',
        'ip.unique' => 'La ip ya fue registrada.',
        'sistema_operativo.required'=> 'El sistema operativo es obligatorio.',
        'user_admin.required'=> 'El usuario administrador es obligatorio.',
        'pass_admin.required'=> 'La contraseña administrador es obligatorio.',
    ];

    public function nuevo(){
        $this->reset();

        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function guardar(){
        $validated = $this->validate(); 

        $this->reset();
    }

    public function editar(Tbl_biene $instanciaTbl){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
        
        // Rellenar campos
        $this->id_bien = $instanciaTbl->id;
        $this->cod_pat = $instanciaTbl->cod_pat;
        $this->cod_barra = $instanciaTbl->cod_barra;
        $this->bien = $instanciaTbl->bien;
        $this->marca = $instanciaTbl->marca;
        $this->modelo = $instanciaTbl->modelo;
        $this->serie = $instanciaTbl->serie;
        $this->medidas = $instanciaTbl->medidas;
        $this->color = $instanciaTbl->color;
        $this->est_cons = $instanciaTbl->est_cons;
        $this->cod_ubif = $instanciaTbl->cod_ubif;
        $this->desc_ubif = $instanciaTbl->desc_ubif;
        $this->cod_usuario = $instanciaTbl->cod_usuario;
        $this->desc_usuario = $instanciaTbl->desc_usuario;
        $this->desc_cargo = $instanciaTbl->desc_cargo;
        $this->clase = $instanciaTbl->clase;
        $this->familia = $instanciaTbl->familia;
        $this->observa = $instanciaTbl->observa;
        $this->df = $instanciaTbl->df;
        $this->nro_pecosa = $instanciaTbl->nro_pecosa;
        $this->doc_adq = $instanciaTbl->doc_adq;
        $this->ndoc_adq = $instanciaTbl->ndoc_adq;
        $this->fecha_adq = $instanciaTbl->fecha_adq;
        $this->acoddepofi = $instanciaTbl->acoddepofi;
        $this->ip = $instanciaTbl->ip;
        $this->coddepofi = $instanciaTbl->coddepofi;
        $this->nomdepofi = $instanciaTbl->nomdepofi;
        $this->anomdepofi = $instanciaTbl->anomdepofi;
        $this->sedepofi = $instanciaTbl->sedepofi;
        $this->codsedeofi = $instanciaTbl->codsedeofi;
        $this->nomsedeofi = $instanciaTbl->nomsedeofi;
        $this->codsede = $instanciaTbl->codsede;
        $this->nomsede = $instanciaTbl->nomsede;
        $this->estadoofi = $instanciaTbl->estadoofi;
        $this->codgbien = $instanciaTbl->codgbien;
        $this->estado = $instanciaTbl->estado;
        $this->codcat = $instanciaTbl->codcat;
        $this->codgclase = $instanciaTbl->codgclase;
        $this->user_admin = $instanciaTbl->user_admin;
        $this->pass_admin = $instanciaTbl->pass_admin;
        $this->sistema_operativo = $instanciaTbl->sistema_operativo;
        $this->impresora01 = $instanciaTbl->impresora01;
        $this->ip_impresora01 = $instanciaTbl->ip_impresora01;
        $this->impresora02 = $instanciaTbl->impresora02;
        $this->ip_impresora02 = $instanciaTbl->ip_impresora02;
        $this->impresora03 = $instanciaTbl->impresora03;
        $this->ip_impresora03 = $instanciaTbl->ip_impresora03;
        $this->desplazamiento = $instanciaTbl->desplazamiento;
        $this->activo = $instanciaTbl->activo;
        $this->observacion = $instanciaTbl->observacion;
        $this->created_user = auth()->user()->datos;
        $this->updated_user = auth()->user()->datos;

        $this->personal_detalle = $this->cod_usuario . ' - ' . $this->desc_usuario;
        $this->equipo_detalle = $this->cod_pat . ' - ' . $this->bien . ' - ' . $this->marca . ' - ' . $this->modelo . ' - ' . $this->serie;

    }

    public function actualizar(){
        $instanciaTbl = Tbl_biene::findOrFail($this->id_bien);

        $instanciaTbl->update([
            'cod_pat'          => $this->cod_pat,
            'cod_barra'        => $this->cod_barra,
            'bien'             => mb_strtoupper($this->bien),
            'marca'            => mb_strtoupper($this->marca),
            'modelo'           => mb_strtoupper($this->modelo),
            'serie'            => mb_strtoupper($this->serie),
            'medidas'          => $this->medidas,
            'color'            => mb_strtoupper($this->color),
            'est_cons'         => $this->est_cons,
            'cod_ubif'         => $this->cod_ubif,
            'desc_ubif'        => $this->desc_ubif,
            'cod_usuario'      => $this->cod_usuario,
            'desc_usuario'     => $this->desc_usuario,
            'desc_cargo'       => $this->desc_cargo,
            'clase'            => $this->clase,
            'familia'          => $this->familia,
            'observa'          => $this->observa,
            'df'               => $this->df,
            'nro_pecosa'       => $this->nro_pecosa,
            'doc_adq'          => $this->doc_adq,
            'ndoc_adq'         => $this->ndoc_adq,
            'fecha_adq'        => $this->fecha_adq,
            'acoddepofi'       => $this->acoddepofi,
            'ip'               => $this->ip,
            'coddepofi'        => $this->coddepofi,
            'nomdepofi'        => $this->nomdepofi,
            'anomdepofi'       => $this->anomdepofi,
            'sedepofi'         => $this->sedepofi,
            'codsedeofi'       => $this->codsedeofi,
            'nomsedeofi'       => $this->nomsedeofi,
            'codsede'          => $this->codsede,
            'nomsede'          => $this->nomsede,
            'estadoofi'        => $this->estadoofi,
            'codgbien'         => $this->codgbien,
            'estado'           => $this->estado,
            'codcat'           => $this->codcat,
            'codgclase'        => $this->codgclase,
            'user_admin'       => $this->user_admin,
            'pass_admin'       => $this->pass_admin,
            'sistema_operativo'=> $this->sistema_operativo,
            'impresora01'      => $this->impresora01,
            'ip_impresora01'   => $this->ip_impresora01,
            'impresora02'      => $this->impresora02,
            'ip_impresora02'   => $this->ip_impresora02,
            'impresora03'      => $this->impresora03,
            'ip_impresora03'   => $this->ip_impresora03,
            'desplazamiento'   => $this->desplazamiento,
            'activo'           => $this->activo,
            'observacion'      => mb_strtoupper($this->observacion),
            'updated_user'     => auth()->user()->datos,
        ]);

        $this->resetExcept('filtro_dependencia','filtro_ip','searcha');

        $this->modal_abierto_personal = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch('alerta-actualizado');
    }

    public function desactivar(Tbl_biene $ibien){
        try {
            $ibien->update([
                'activo' => '0',
                'updated_user' => auth()->user()->datos,
            ]);

            // Comunica que se desactivado
            $this->dispatch('ipDesactivado');

            session()->flash('danger', 'Usuario desactivado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }
    }

    public function cerrar(){
        $this->modal_abierto_personal = false;
    }

    // Bienes
    // ---------------------------------------------------------
    public function buscar_bienes(){
        $this->modal_abierto_bienes = true;
    }
    public function agregar_bienes(Tbl_biene $ibienInformatico){


        $this->cod_pat = $ibienInformatico->cod_pat;

        $this->personal_detalle = $ibienInformatico->cod_usuario . ' - ' . $ibienInformatico->desc_usuario;
        $this->equipo_detalle = $ibienInformatico->cod_pat . ' - ' . $ibienInformatico->bien;

        $this->desc_ubif = $ibienInformatico->desc_ubif;
        $this->marca = $ibienInformatico->marca;
        $this->modelo = $ibienInformatico->modelo;
        $this->serie = $ibienInformatico->serie;
        $this->ip = $ibienInformatico->ip;
        $this->sistema_operativo = $ibienInformatico->sistema_operativo;
        $this->user_admin = $ibienInformatico->user_admin;
        $this->pass_admin = $ibienInformatico->pass_admin;
        $this->impresora01 = $ibienInformatico->impresora01;
        $this->impresora02 = $ibienInformatico->impresora02;
        $this->impresora03 = $ibienInformatico->impresora03;
        $this->ip_impresora01 = $ibienInformatico->ip_impresora01;
        $this->ip_impresora02 = $ibienInformatico->ip_impresora02;
        $this->ip_impresora03 = $ibienInformatico->ip_impresora03;
        $this->observacion = $ibienInformatico->observacion;

        $this->modal_abierto_bienes = false;
    }
    public function cerrar_bienes(){
        $this->modal_abierto_bienes = false;
    }

    // Imagen
    // ---------------------------------------------------------
    public function editar_imagen(){
        $this->modal_abierto_imagen = true;
    }

    public function cerrar_imagen(){
        $this->modal_abierto_imagen = false;

        // Variable de entorno
        $this->reset(['avatar']);
    }
}
