<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Productos de Ternera
        Product::create([
            'name' => "Filetes de aguja",
            'description' => "Filetes de aguja originados de Galicia",
            'stock' => 50,
            'sale' => 1,
            'priceKG' => 15,
            'urlImagen' => "assets/Filetes de aguja.png",
            'priceSale' => 5,
            'priceKGFinal' => 10,
            'category_id' => 1
        ]);

        Product::create([
            'name' => "Carne Picada mixta de cerdo y ternera",
            'description' => "Carne picada mixta originada de Pais Vasco",
            'stock' => 25,
            'sale' => 0,
            'priceKG' => 12,
            'urlImagen' => "assets/Carne Picada mixta de cerdo y ternera.png",
            'priceKGFinal' => 12,
            'category_id' => 1
        ]);

        Product::create([
            'name' => "Filete de Ternera a la Parrilla",
            'description' => "Filete de ternera tierno y jugoso, ideal para cocinar a la parrilla o a la plancha.",
            'stock' => 40,
            'sale' => 0,
            'priceKG' => 22.50,
            'urlImagen' => "assets/Filete de Ternera a la Parrilla.png",
            'priceKGFinal' => 22.50,
            'category_id' => 1
        ]);
        
        Product::create([
            'name' => "Ternera Estilo Ribeye",
            'description' => "Ternera cortada al estilo ribeye, con una infiltración de grasa que le aporta un sabor excepcional.",
            'stock' => 30,
            'sale' => 0,
            'priceKG' => 29.99,
            'urlImagen' => "assets/Ternera Estilo Ribeye.png",
            'priceKGFinal' => 29.99,
            'category_id' => 1
        ]);
        
        Product::create([
            'name' => "Chuletas de Ternera Premium",
            'description' => "Chuletas de ternera premium, perfectas para cocinar a la parrilla o al horno.",
            'stock' => 35,
            'sale' => 0,
            'priceKG' => 18.75,
            'urlImagen' => "assets/Chuletas de Ternera Premium.png",
            'priceKGFinal' => 18.75,
            'category_id' => 1
        ]);
        
        Product::create([
            'name' => "Solomillo de Ternera Extra",
            'description' => "Solomillo de ternera extra, uno de los cortes más tiernos y delicados de la carne de ternera.",
            'stock' => 25,
            'sale' => 0,
            'priceKG' => 35.50,
            'urlImagen' => "assets/Solomillo de Ternera Extra.png",
            'priceKGFinal' => 35.50,
            'category_id' => 1
        ]);
        
        Product::create([
            'name' => "Estofado de Ternera",
            'description' => "Ternera cortada en dados y lista para preparar un delicioso estofado con verduras frescas.",
            'stock' => 20,
            'sale' => 0,
            'priceKG' => 14.99,
            'urlImagen' => "assets/Estofado de Ternera.png",
            'priceKGFinal' => 14.99,
            'category_id' => 1
        ]);

        // Productos de Vaca
        Product::create([
            'name' => "Lomo de vaca extra",
            'description' => "Lomo de vaca fresco",
            'stock' => 25,
            'sale' => 1,
            'priceKG' => 30,
            'priceSale' => 5,
            'urlImagen' => "assets/Lomo de vaca extra.png",
            'priceKGFinal' => 25,
            'category_id' => 2
        ]);

        Product::create([
            'name' => "Solomillo de vaca extra al corte",
            'description' => "Solomillo de vaca al corte",
            'stock' => 25,
            'sale' => 0,
            'priceKG' => 42.75,
            'urlImagen' => "assets/Solomillo de vaca extra al corte.jpg",
            'priceKGFinal' => 42.75,
            'category_id' => 2
        ]);

        Product::create([
            'name' => "Entrecot de Vaca Premium",
            'description' => "Entrecot de vaca premium, perfecto para cocinar a la parrilla o a la plancha.",
            'stock' => 30,
            'sale' => 0,
            'priceKG' => 35.99,
            'urlImagen' => "assets/Entrecot de Vaca Premium.png",
            'priceKGFinal' => 35.99,
            'category_id' => 2
        ]);
        
        Product::create([
            'name' => "Costillas de Vaca a la Barbacoa",
            'description' => "Costillas de vaca marinadas y listas para cocinar a la barbacoa, una delicia para los amantes de la carne.",
            'stock' => 20,
            'sale' => 0,
            'priceKG' => 24.75,
            'urlImagen' => "assets/Costillas de Vaca a la Barbacoa.png",
            'priceKGFinal' => 24.75,
            'category_id' => 2
        ]);
        
        Product::create([
            'name' => "Filete de Vaca Angus",
            'description' => "Filete de vaca Angus, conocido por su terneza y sabor excepcional.",
            'stock' => 35,
            'sale' => 0,
            'priceKG' => 39.50,
            'urlImagen' => "assets/Filete de Vaca Angus.png",
            'priceKGFinal' => 39.50,
            'category_id' => 2
        ]);
        
        Product::create([
            'name' => "Hamburguesas de Vaca Caseras",
            'description' => "Hamburguesas caseras elaboradas con carne de vaca fresca y condimentos naturales.",
            'stock' => 50,
            'sale' => 0,
            'priceKG' => 12.99,
            'urlImagen' => "assets/Hamburguesas de Vaca Caseras.png",
            'priceKGFinal' => 12.99,
            'category_id' => 2
        ]);

        // Productos de Cerdo 
        Product::create([
            'name' => "Costillas Frescas",
            'description' => "Costillas frescas originadas en Portugal",
            'stock' => 100,
            'sale' => 0,
            'priceKG' => 14.50,
            'urlImagen' => "assets/Costillas Frescas.png",
            'priceKGFinal' => 14.50,
            'category_id' => 3
        ]);

        Product::create([
            'name' => "Costillas Adobadas",
            'description' => "Costillas adobadas marca de la casa",
            'stock' => 100,
            'sale' => 1,
            'priceKG' => 15,
            'urlImagen' => "assets/Costillas Adobadas.png",
            'priceSale' => 2.50,
            'priceKGFinal' => 12.50,
            'category_id' => 3
        ]);

        Product::create([
            'name' => "Chuletas de Cerdo",
            'description' => "Deliciosas chuletas de cerdo, perfectas para cocinar a la parrilla o al horno.",
            'stock' => 150,
            'sale' => 0,
            'priceKG' => 12.99,
            'urlImagen' => "assets/Chuletas de Cerdo.png",
            'priceKGFinal' => 12.99,
            'category_id' => 3
        ]);
        
        Product::create([
            'name' => "Jamón Serrano",
            'description' => "Auténtico jamón serrano curado durante meses para obtener su sabor único y delicioso.",
            'stock' => 80,
            'sale' => 1,
            'priceKG' => 18.75,
            'urlImagen' => "assets/Jamón Serrano.png",
            'priceSale' => 3.00,
            'priceKGFinal' => 15.75,
            'category_id' => 3
        ]);
        
        Product::create([
            'name' => "Panceta Ahumada",
            'description' => "Panceta de cerdo ahumada, ideal para añadir sabor a tus guisos y platos favoritos.",
            'stock' => 120,
            'sale' => 0,
            'priceKG' => 9.99,
            'urlImagen' => "assets/Panceta Ahumada.png",
            'priceKGFinal' => 9.99,
            'category_id' => 3
        ]);
        
        Product::create([
            'name' => "Salchichón de Cerdo",
            'description' => "Salchichón de cerdo de alta calidad, perfecto para picar como aperitivo o añadir a tus recetas.",
            'stock' => 100,
            'sale' => 0,
            'priceKG' => 11.50,
            'urlImagen' => "assets/Salchichón de Cerdo.png",
            'priceKGFinal' => 11.50,
            'category_id' => 3
        ]);
        
        Product::create([
            'name' => "Lomo Embuchado",
            'description' => "Lomo de cerdo embuchado y curado, un manjar perfecto para disfrutar en cualquier ocasión.",
            'stock' => 90,
            'sale' => 0,
            'priceKG' => 22.50,
            'urlImagen' => "assets/Lomo Embuchado.png",
            'priceKGFinal' => 22.50,
            'category_id' => 3
        ]);
    }
}
