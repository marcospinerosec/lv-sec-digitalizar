<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function copyAll()
    {
        $remoteDirectory = '/'; // Ruta en el servidor SFTP
        $localDirectory = storage_path('/'); // Directorio local de destino

        $files = Storage::disk('sftp')->files($remoteDirectory);
        $result=array();
// Copiar cada archivo al directorio de destino
        foreach ($files as $file) {
            //echo "Ruta completa en SFTP: {$file}\n";
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            //$localFilePath = storage_path("app/copias/{$fileName}.{$fileExtension}");

            $newFileName = "{$fileName}.{$fileExtension}";



            try {
                Log::info('Intentando copiar el archivo: '.$file,[]);
                // ...
                // Intenta obtener el contenido del archivo desde el servidor SFTP
                $fileContents = Storage::disk('sftp')->get($file);
                // Verifica si el contenido se obtuvo correctamente
                if ($fileContents !== false) {
                    // Escribe el contenido en el archivo local
                    $store  = Storage::disk('cpagos')->put($newFileName, $fileContents);

                    // Verifica si se escribió el archivo localmente
                    if ($store) {
                        Log::info('Copiado exitoso: '.$file,[]);
                        $result[]='Copiado exitoso: '.$file;
                    } else {
                        Log::info('error al copiar: '.$file,[]);
                        $result[]='Error al copiar: '.$file;
                    }
                } else {
                    Log::info('No se pudo obtener: '.$file,[]);
                    $result[]='No se pudo obtener: '.$file;
                }
            } catch (\Exception $e) {
                Log::info('Error al copiar el archivo: ' . $e->getMessage(),[]);
                $result[]='Error al copiar el archivo: ' . $e->getMessage();

            }

        }

        return $result;
    }

    public function moveAll()
    {
        $remoteDirectory = '/'; // Ruta en el servidor SFTP
        $localDirectory = storage_path('/'); // Directorio local de destino

        $files = Storage::disk('sftp')->files($remoteDirectory);

        $result=array();
        // Mover cada archivo al directorio de destino
        foreach ($files as $file) {
            //echo "Ruta completa en SFTP: {$file}\n";
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
            ///$localFilePath = storage_path("app/copias/{$fileName}.{$fileExtension}");

            $newFileName = "{$fileName}.{$fileExtension}";
            try {
                Log::info('Intentando mover el archivo: '.$file,[]);
                // ...
                // Intenta obtener el contenido del archivo desde el servidor SFTP
                $fileContents = Storage::disk('sftp')->get($file);
                // Verifica si el contenido se obtuvo correctamente
                if ($fileContents !== false) {
                    // Escribe el contenido en el archivo local
                    //file_put_contents($localFilePath, $fileContents);
                    $store  = Storage::disk('cpagos')->put($newFileName, $fileContents);
                    //Log::info('Store: '.$store,[]);
                    // Verifica si se escribió el archivo localmente
                    if ($store) {
                        Storage::disk('sftp')->delete($file);
                        Log::info('Movido exitoso: '.$file,[]);
                        $result[]='Movido exitoso: '.$file;
                    } else {
                        Log::info('error al mover: '.$file,[]);
                        $result[]='Error al mover: '.$file;
                    }
                } else {
                    Log::info('No se pudo obtener: '.$file,[]);
                    $result[]='No se pudo obtener: '.$file;
                }
            } catch (\Exception $e) {
                Log::info('Error al mover el archivo: ' . $e->getMessage(),[]);
                $result[]='Error al mover el archivo: ' . $e->getMessage();

            }

        }

        return $result;
    }
}
