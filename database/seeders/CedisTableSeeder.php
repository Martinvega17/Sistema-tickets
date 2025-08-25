<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Region;

class CedisTableSeeder extends Seeder
{
    public function run()
    {
        $cedisPorRegion = [
            'Bajio' => [
                'QUERETARO', 'SAN JUAN DEL RIO', 'SAN LUIS DE LA PAZ', 'PACHUCA', 
                'TULANCINGO', 'ZACUALTIPAN', 'TEPEJI', 'CALERA',
                'SANTA MARIA', 'SAN LUIS PLANTA', 'RIO VERDE', 'CD DEL MAIZ',
                'CD VALLES', 'TAMAZUNCHALE', 'TANQUIAN', 'RIO GRANDE', 'OJUELOS',
                'SAN MARCOS (AGUASCALIENTES)', 'CELAYA PLANTA', 'LAGOS DE MORENO',
                'VALLE DE SANTIAGO', 'LEON ORIENTE', 'ACAMBARO', 'URIANGATO',
                'CELAYA MEGA', 'CELAYA GARRAFON', 'CORTAZAR', 'SALVATIERRA', 
                'DOLORES', 'SAN MIGUEL ALLENDE', 'RINCON DE ROMOS', 'TEOCALTICHE'
            ],
            'Corporativo' => [
                'ITZTACALCO', 'PROPLASA', 'TLALNEPANTLA', 'SANTA FE',
                'CENTRO DE SERVICIOS ZAPOPAN'
            ],
            'Centro' => [
                'PUEBLA', 'PROPLASA', 'TLALNEPANTLA', 'SANTA FE',
                'CENTRO DE SERVICIOS ZAPOPAN'
            ],
            'Metro' => [
                'IZTAPALAPA', 'COYOACÁN', 'BENITO JUÁREZ', 'ÁLVARO OBREGÓN',
                'MIGUEL HIDALGO', 'CUAUHTÉMOC', 'VENUSTIANO CARRANZA'
            ],
            'Norte' => [
                'MONTERREY', 'SALTILLO', 'TORREÓN', 'CHIHUAHUA', 'CIUDAD JUÁREZ',
                'DURANGO', 'ZACATECAS', 'SAN LUIS POTOSÍ', 'TAMPICO'
            ],
            'Occidente' => [
                'GUADALAJARA', 'ZAPOPAN', 'TLAQUEPAQUE', 'TONALÁ', 'PUERTO VALLARTA',
                'COLIMA', 'MANZANILLO', 'AUTLÁN', 'CIUDAD GUZMÁN'
            ],
            'Pacifico' => [
                'HERMOSILLO', 'CIUDAD OBREGÓN', 'NOGALES', 'GUAYMAS', 'LOS MOCHIS',
                'CULIACÁN', 'MAZATLÁN', 'TEPIC', 'ENSENADA'
            ],
            'Sur' => [
                'VERACRUZ', 'XALAPA', 'CÓRDOBA', 'ORIZABA', 'VILLAHERMOSA',
                'TUXTLA GUTIÉRREZ', 'OAXACA', 'ACAPULCO', 'CHILPANCINGO'
            ],
            'CAT' => [
                'CAT'
            ]
        ];

        foreach ($cedisPorRegion as $regionNombre => $cedisArray) {
            $region = Region::where('nombre', $regionNombre)->first();
            
            if ($region) {
                foreach ($cedisArray as $cedisNombre) {
                    DB::table('cedis')->updateOrInsert(
                        ['nombre' => $cedisNombre, 'region_id' => $region->id],
                        [
                            'estatus' => 'activo',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }
}