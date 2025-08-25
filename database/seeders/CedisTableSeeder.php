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
                'SAN LUIS PLANTA', 'LEÓN', 'AGUASCALIENTES', 'QUERÉTARO', 
                'SAN JUAN DEL RÍO', 'CELAYA', 'IRAPUATO', 'SALAMANCA',
                'GUANAJUATO', 'MOROLEÓN', 'ACÁMBARO', 'DOLORES HIDALGO'
            ],
            'Corporativo' => [
                'ITZTACALCO', 'CORPORATIVO CDMX', 'OFICINAS CENTRALES',
                'ADMINISTRACIÓN', 'DIRECCIÓN GENERAL'
            ],
            'Centro' => [
                'PUEBLA', 'TLAXCALA', 'TOLUCA', 'CUAUTITLÁN', 'NAUCALPAN',
                'ECATEPEC', 'NEZAHUALCÓYOTL', 'CHIMALHUACÁN', 'TEXCOCO'
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
                'CENTRO DE DISTRIBUCIÓN', 'ALMACÉN PRINCIPAL', 'LOGÍSTICA',
                'CADENA DE SUMINISTRO', 'INVENTARIOS'
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