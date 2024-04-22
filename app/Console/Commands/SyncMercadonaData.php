<?php
namespace App\Console\Commands;

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use GuzzleHttp\Client;
use App\Models\Subcategory;

class SyncMercadonaData extends Command
{
    protected $signature = 'sync:mercadona';

    protected $description = 'Sync Mercadona data from API to database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Recuperar todas las subcategorías de la base de datos
        $subcategories = Subcategory::all();

        // Verificar si se encontraron subcategorías
        if ($subcategories->isEmpty()) {
            $this->error('No se encontraron subcategorías en la base de datos.');
            return;
        }

        // Crear un cliente Guzzle para realizar la solicitud HTTP
        $client = new Client();

        // Iterar sobre cada subcategoría y sincronizar los productos
        foreach ($subcategories as $subcategory) {
            // Obtener el ID de la subcategoría
            $subcategoryId = $subcategory->id;

            // Hacer la solicitud GET a la API de Mercadona para obtener los productos de la subcategoría
            $response = $client->request('GET', "https://tienda.mercadona.es/api/categories/{$subcategoryId}");

            // Obtener los datos de la respuesta y decodificarlos
            $data = json_decode($response->getBody(), true);

            // Guardar los productos en la base de datos
            foreach ($data['categories'][0]['products'] as $productData) {
                // Verificar si el producto ya existe en la base de datos por su ID
                $product = Product::firstOrNew(['id' => $productData['id']]);

                // Actualizar los datos del producto
                $product->fill([
                    'limit' => $productData['limit'],
                    'packaging' => $productData['packaging'],
                    'thumbnail' => $productData['thumbnail'],
                    'display_name' => $productData['display_name'],
                    'unit_price' => $productData['price_instructions']['unit_price'] ?? 0, // Precio unitario
                    //'unit_price' => 0,
                    'subcategory_id' => $subcategoryId,
                ]);

                // Guardar el producto en la base de datos
                $product->save();
            }
        }

        // Informar que la sincronización ha sido exitosa
        $this->info('Mercadona data synced successfully!');
    }
}
