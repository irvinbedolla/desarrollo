<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Luecano\NumeroALetras\NumeroALetras; 
use NumberToWords\NumberToWords; // para convertir numeros a letras

class Turnos extends Model {
    //use HasFactory;
    protected $table = 'turnos';
    protected $primaryKey = 'id';
    protected $fillable = ['consecutivo','fecha','hora','hora_fin','auxiliar','tipo','lugar_auxiliar','exepcion',
    'edad','sexo','vulnerables','monto','empresa','trabajador','frecuencia','dias','estatus','delegacion','ine','representacion','email','telefono','turnos','JLCA','motivo',
    'trabajador_curp','documentoCurp','tipo_identificacion','documentoidentificacion','fecha_inicio','fecha_termino','categoria','tipo_pago',
    'Aguinaldo','Vacaciones','PrimaVacacional','PagoPTU','Gratificación','PrimaAntigüedad','Otras','Especifique','documentoCuanti','tipo_otros',
    'observaciones','curp_solicitante','salario','primero_empresa','segundo_empresa','nombre_empresa','primero_trabajador','segundo_trabajador',
    'vacaciones_dias','aguinaldo_dias','otros_dias','horario','comida','domicilio','resolucion_primera','resolucion_trabajadores','resolucion_justificacion','resolucion_segunda',
    'NUE','observaciones']; 
    
   //método para convertir una cantidad númerica a texto
   /*public function getMontoTextoAttribute(){
        $formato = new NumeroALetras();

        $cantidad = explode('.', number_format($this->monto, 2, '.', ''));
        $parteEntera = (int) $cantidad[0];
        $parteDecimal = $cantidad[1];

        $letras = strtoupper($formato->toWords($parteEntera));

        return "{$letras} PESOS {$parteDecimal}/100";
    }*/


    public function getMontoTextoAttribute() {
        return $this->convertirNumerosALetras($this->monto);
    }

    public function getVacacionesTextoAttribute() {
        return $this->convertirNumerosALetras($this->Vacaciones);
    }

    public function getPrimaTextoAttribute() {
        return $this->convertirNumerosALetras($this->PrimaVacacional);
    }

    public function getAguinaldoTextoAttribute() {
        return $this->convertirNumerosALetras($this->Aguinaldo);
    }

    public function getUtilidadesTextoAttribute() {
        return $this->convertirNumerosALetras($this->PagoPTU);
    }

    public function getAntiguedadTextoAttribute() {
        return $this->convertirNumerosALetras($this->PrimaAntigüedad);
    }

    public function getGratificacionTextoAttribute() {
        return $this->convertirNumerosALetras($this->Gratificación);
    }

    public function getOtrasTextoAttribute() {
        return $this->convertirNumerosALetras($this->Otras);
    }

    private function convertirNumerosALetras($valor) {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('es'); 

        $parteEntera = floor($valor);
        $letras = strtoupper($numberTransformer->toWords($parteEntera)); 

        $parteDecimal = round(($valor - $parteEntera) * 100);
        $centavos = str_pad($parteDecimal, 2, '0', STR_PAD_LEFT); 
        return "{$letras} PESOS {$centavos}/100";
    }
}
