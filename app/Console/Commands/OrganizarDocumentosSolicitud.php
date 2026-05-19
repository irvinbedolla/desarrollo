<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OrganizarDocumentosSolicitud extends Command
{
    protected $signature = 'documentos:organizar';
    protected $description = 'Organiza los archivos sueltos pasándolos a carpetas individuales por id_solicitud';

    public function handle()
    {
        // 1. Obtener los registros de la base de datos
        $documentos = DB::table('documentos')
                        ->select('id_solicitud', 'nombre_documento')
                        ->whereNotNull('nombre_documento')
                        ->where('nombre_documento', '<>', '')
                        ->get();

        $this->info("Se encontraron {$documentos->count()} registros en la base de datos para procesar.");
        
        // 2. Intentar autodetectar dónde están las carpetas físicamente en tu Xampp
        $rutasPosibles = [
            storage_path('app'),          // storage/app/
            storage_path('app/public'),   // storage/app/public/
            public_path()                 // public/
        ];

        $raizFisica = null;
        // Buscaremos cuál ruta contiene la carpeta documentosSolicitud o documentos_abogados
        foreach ($rutasPosibles as $ruta) {
            if (is_dir($ruta . '/documentosSolicitud') || is_dir($ruta . '/documentos_abogados') || is_dir($ruta . '/documentos_ratificacion') || is_dir($ruta . '/documentos_notificacion')) {
                $raizFisica = $ruta;
                break;
            }
        }

        if (!$raizFisica) {
            $this->error("No se pudo encontrar físicamente la carpeta 'documentosSolicitud' o 'documentos_abogados' en los directorios estándar de Laravel.");
            $this->line("Por favor, verifica que existan dentro de storage/app o storage/app/public");
            return Command::FAILURE;
        }

        $this->info("Carpeta raíz de almacenamiento detectada en: {$raizFisica}");

        $bar = $this->output->createProgressBar($documentos->count());
        $bar->start();

        $movidos = 0;
        $noEncontrados = 0;

        // 3. Iterar y mover usando funciones nativas de PHP para evitar restricciones de discos virtuales de Laravel
        foreach ($documentos as $doc) {
            $nombreArchivo = $doc->nombre_documento;
            $idSolicitud = $doc->id_solicitud;

            // Evaluamos en cuál de las dos carpetas que mencionas está guardado el archivo actualmente
            $carpetasOrigen = ['documentosSolicitud', 'documentos_abogados'];
            $archivoEncontrado = false;

            foreach ($carpetasOrigen as $carpeta) {
                $rutaViejaFisica = $raizFisica . DIRECTORY_SEPARATOR . $carpeta . DIRECTORY_SEPARATOR . $nombreArchivo;
                $directorioNuevo = $raizFisica . DIRECTORY_SEPARATOR . $carpeta . DIRECTORY_SEPARATOR . $idSolicitud;
                $rutaNuevaFisica = $directorioNuevo . DIRECTORY_SEPARATOR . $nombreArchivo;

                // Si el archivo existe suelto en la raíz de esa carpeta...
                if (file_exists($rutaViejaFisica) && !is_dir($rutaViejaFisica)) {
                    
                    // Crear la subcarpeta con el id_solicitud si no existe
                    if (!file_exists($directorioNuevo)) {
                        mkdir($directorioNuevo, 0755, true);
                    }

                    // Mover el archivo físicamente en el disco duro de Windows
                    if (rename($rutaViejaFisica, $rutaNuevaFisica)) {
                        $movidos++;
                        $archivoEncontrado = true;
                        break; // Saltamos a la siguiente iteración de documento
                    }
                } 
                // Si ya fue movido con anterioridad a la carpeta correcta
                elseif (file_exists($rutaNuevaFisica)) {
                    $archivoEncontrado = true;
                    break;
                }
            }

            if (!$archivoEncontrado) {
                $noEncontrados++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->info("¡Proceso terminado!");
        $this->line("-> Archivos movidos exitosamente: <info>{$movidos}</info>");
        $this->line("-> Archivos no hallados o inexistentes en el disco: <error>{$noEncontrados}</error>");
        
        return Command::SUCCESS;
    }
}