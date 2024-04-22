<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use GuzzleHttp\Client;
use App\Models\Subcategory;

class UpdateMercadonaData extends Command
{
    protected $signature = 'update:mercadona';

    protected $description = 'Update Mercadona data from API in database';

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

            // Iterar sobre los productos obtenidos de la API
            foreach ($data['categories'][0]['products'] as $productData) {
                // Buscar el producto en la base de datos por su ID
                $product = Product::find($productData['id']);

                // Si el producto existe en la base de datos, actualizar sus campos
                if ($product) {
                    $product->limit = $productData['limit'];
                    $product->packaging = $productData['packaging'];
                    $product->thumbnail = $productData['thumbnail'];
                    $product->display_name = $productData['display_name'];
                    
                    // Obtener el precio unitario del producto
                    $unitPrice = isset($productData['price_instructions']['unit_price']) ? $productData['price_instructions']['unit_price'] : 0;
                    $product->unit_price = $unitPrice;

                    // Guardar los cambios en el producto
                    $product->save();
                }
            }
        }

        // Informar que la actualización ha sido exitosa
        $this->info('Mercadona data updated successfully!');
    }
}
