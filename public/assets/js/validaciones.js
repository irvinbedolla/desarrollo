function validacionCamposInput(valor, tipoValidacion, elementoMsj, msj, aplicaVacio, msjVacio){

  // console.log(tipoValidacion);
  if(aplicaVacio == 0 && valor == ""){
    $(elementoMsj).text(msjVacio);
    return false;
  }

  var patron = "sinValidacion";
  if(valor != ""){
    if(tipoValidacion == "soloLetras"){ patron = /^[a-zA-Z\ñ\Ñ\.\,\s]+$/; }
    else if(tipoValidacion == "soloLetrasSinEspacios"){ patron = /^[a-zA-Z\ñ\Ñ\.\,]+$/; }
    else if(tipoValidacion == "soloNumeros"){ patron = /^[0-9\.]\d*$/; }
    else if(tipoValidacion == "soloLetrasYNumeros"){ patron = /^[0-9a-zA-Z\ñ\Ñ\.\,\s]+$/; }
    else if(tipoValidacion == "soloLetrasYNumerosSinEspacios"){ patron = /^[0-9a-zA-Z\ñ\Ñ\.\,]+$/; }
    else if(tipoValidacion == "correoElectronico"){ patron = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/; }
    else if(tipoValidacion == "numeroTelefonico"){ patron = /^[0-9]{10}$/; }
    else if(tipoValidacion == "fecha"){ patron = /^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/; }
    else if(tipoValidacion == "hora"){ patron = /^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/; }
    else if(tipoValidacion == "minutosSegundos"){ patron = /^[0-5][0-9](:[0-5][0-9])?$/; }
    else if(tipoValidacion == "rfcPersonaFisica"){ patron = /^[A-ZÑ&]{4}\d{6}[A-V1-9][A-Z1-9][0-9A]$/; }
    else if(tipoValidacion == "rfcPersonaMoral"){ patron = /^[A-ZÑ&]{3}\d{6}[A-V1-9][A-Z1-9][0-9A]$/; }
    else if(tipoValidacion == "claveInterbancaria"){ patron = /^[0-9]{18}$/; }
    else if(tipoValidacion == "numeroIccid"){ patron = /^[0-9]{19}$/; }
    else if(tipoValidacion == "numeroIccidAsignar"){ patron = /^[0-9]{18}$/; }
    else if(tipoValidacion == "numeroImsi"){ patron = /^[0-9]{15}$/; }
    else if(tipoValidacion == "numeroNIR"){ patron = /^[0-9]{2,3}$/; }
    else if(tipoValidacion == "numeroImei"){ patron = /^[0-9]{14,15}$/; }
    else if(tipoValidacion == "numeroPin"){ patron = /^[0-9]{4}$/; }
    else if(tipoValidacion == "numeroPuk"){ patron = /^[0-9\.]\d*$/; }
    else if(tipoValidacion == "importe"){ patron = /^(?:- ?)?\d+(.\d{1,2})?$/; }
    else if(tipoValidacion == "longitud"){ patron = /^[\-\+]?(0(\.\d{1,10})?|([1-9](\d)?)(\.\d{1,10})?|1[0-7]\d{1}(\.\d{1,10})?|180\.0{1,10})$/; }
    else if(tipoValidacion == "latitud"){ patron = /^[\-\+]?((0|([1-8]\d?))(\.\d{1,10})?|90(\.0{1,10})?)$/; }
    else if(tipoValidacion == "numeroCuentaBancario"){ patron = /^[0-9]{4}$/; }
    else if(tipoValidacion == "nip"){ patron = /^[0-9]{4}$/; }
    else if(tipoValidacion == "nroTarjeta"){ patron = /^[0-9]{15,16}$/; }
    else if(tipoValidacion == "anio"){ patron = /^[0-9]{4}$/; }
    else if(tipoValidacion == "mes"){ patron = /^[0-9]{2}$/; }
    else if(tipoValidacion == "cvc"){ patron = /^[0-9]{3}$/; }
    else if(tipoValidacion == "km"){ patron = /^(?:- ?)?\d+(.\d{1,10})?$/; }
    else if(tipoValidacion == "curp"){ patron = /^[A-Z]{4}\d{6}[H,M][A-Z]{5}[A-Z\d][0-9]$/;}
    
  }

  if(patron == "sinValidacion"){
    return true;
  }
  else{
    if(!valor.search(patron)){
      return true;
    }
    else{
      $(elementoMsj).text(msj);
      return false;
    }
  }
}

function validacionCamposSelect(valor, elementoMsj, aplicaVacio, msjVacio){
  if(aplicaVacio == 0 && valor == "-1"){
    $(elementoMsj).text(msjVacio);
    return false;
  }

  return true;
}


