<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SCoordinator;

class SCoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            // ['name' => 'SIN COORDINADOR'],
            // ['name' => 'ALEJANDRO VAZQUEZ NIETO'],
            // ['name' => 'ALEJANDRO VAZQUEZ NIETO'],
            // ['name' => 'ALONSO LOPEZ RODOLFO'],
            // ['name' => 'ANA GABRIELA RODRIGUEZ ROMAN'],
            // ['name' => 'ANA GABRIELA RODRIGUEZ ROMAN'],
            // ['name' => 'ANA LAURA'],
            // ['name' => 'ANTONIO MENDOZA ARELLANO'],
            // ['name' => 'BLANCA JULIETA'],
            // ['name' => 'BRENDA DINORAH RAMOS RODRIGUEZ'],
            // ['name' => 'BRENDA ISELA RAMIREZ RAMIREZ'],
            // ['name' => 'MARTHA ANGELICA CASAS CRUZ'],
            // ['name' => 'KATHIA FERNANDA CASTILLO ROJAS'],
            // ['name' => 'CINTHIA PUENTES MEDINA'],
            // ['name' => 'CLARA CORTES JUAREZ'],
            // ['name' => 'CLARA CORTES JUAREZ'],
            // ['name' => 'YOSHIGEN TONATIUH JOSE CORCHADO HERNANDEZ'],
            // ['previous_name' => 'CORREA OROZCO EVELYN ESMERALDA', 'name' => 'EVELYN ESMERALDA CORREA OROZCO'],
            // ['previous_name' => 'CORTES JUAREZ CLARA', 'name' => 'CLARA CORTES JUAREZ'],
            // ['previous_name' => 'CYNTHIA', 'name' => 'CINTHIA PUENTES MEDINA'],
            // ['previous_name' => 'DIAZ ORTEGON LUIS FERNANDO', 'name' => 'LUIS FERNANDO DIAZ ORTEGON'],
            // ['previous_name' => 'EDGAR CERVANTES RIVERA', 'name' => 'EDGAR CERVANTES RIVERA'],
            // ['previous_name' => 'ELVA MARIA DEL REFUGIO', 'name' => 'ELVA MARIA DEL REFUGIO SILLER LUBRERAS'],
            // ['previous_name' => 'EVELYN', 'name' => 'EVELYN ESMERALDA CORREA OROZCO'],
            // ['previous_name' => 'EVELYN CORREA', 'name' => 'EVELYN ESMERALDA CORREA OROZCO'],
            // ['previous_name' => 'EVELYN ESMERALDA CORREA OROZCO', 'name' => 'EVELYN ESMERALDA CORREA OROZCO'],
            // ['previous_name' => 'FLORES FLORES NADIA DENY', 'name' => 'NADIA DENY FLORES FLORES'],
            // ['previous_name' => 'GERARDO ALEJANDRO', 'name' => 'GERARDO ALEJANDRO'],
            // ['previous_name' => 'GERENCIA COMERCIAL', 'name' => 'SIN COORDINADOR'],
            // ['previous_name' => 'GONZALEZ CAMPOS MARIA TERESITA', 'name' => 'MARIA TERESITA GONZALEZ CAMPOS'],
            // ['previous_name' => 'GRACIA CORTES RAUL', 'name' => 'RAUL GRACIA CORTES'],
            // ['previous_name' => 'GUILLERMO CABRERA', 'name' => 'GUILLERMO CABRERA'],
            // ['previous_name' => 'GUSTAVO ADOLFO VILLARREAL', 'name' => 'GUSTAVO ADOLFO VILLARREAL'],
            // ['previous_name' => 'GUTIERREZ PACHECO ONEYDA MARGARITA', 'name' => 'ONEYDA MARGARITA GUTIERREZ PACHECO'],
            // ['previous_name' => 'IRENE LEAL CERVANTES', 'name' => 'IRENE LEAL CERVANTES'],
            // ['previous_name' => 'JESUS', 'name' => 'JESUS EDUARDO MEZA DONEZ'],
            // ['previous_name' => 'JESUS EDUARDO MEZA DONEZ', 'name' => 'JESUS EDUARDO MEZA DONEZ'],
            // ['previous_name' => 'JORGE', 'name' => 'JORGE ALEJANDRO VAZQUEZ NIETO'],
            // ['previous_name' => 'JORGE ALEJANDRO VAZQUEZ NIETO', 'name' => 'JORGE ALEJANDRO VAZQUEZ NIETO'],
            // ['previous_name' => 'JOSE', 'name' => 'JOSE ORTIZ ROMO'],
            // ['previous_name' => 'JUAN MANUEL', 'name' => 'JUAN MANUEL'],
            // ['previous_name' => 'JUAN VALLEJO', 'name' => 'JUAN VALLEJO'],
            // ['previous_name' => 'JULIA ESPINOSA CHAVIRA', 'name' => 'JULIA ESPINOSA CHAVIRA'],
            // ['previous_name' => 'KATHIA FERNANDA', 'name' => 'KATHIA FERNANDA CASTILLO ROJAS'],
            // ['previous_name' => 'LETICIA ARACELI PALOMINO CHAVARRIA', 'name' => 'LETICIA ARACELI PALOMINO CHAVARRIA'],
            // ['previous_name' => 'LETICIA ARACELI PALOMINO CHAVARRÍA', 'name' => 'LETICIA ARACELI PALOMINO CHAVARRIA'],
            // ['previous_name' => 'LOZANO GUEVARA ELEAZAR', 'name' => 'ELEAZAR LOZANO GUEVARA'],
            // ['previous_name' => 'LUIS FERNANDO', 'name' => 'LUIS FERNANDO DIAZ ORTEGON'],
            // ['previous_name' => 'MARCO ANTONIO', 'name' => 'MARCO ANTONIO SANCHEZ HUIHUITOA'],
            // ['previous_name' => 'MARCO ANTONIO SANCHEZ HUIHUITOA', 'name' => 'MARCO ANTONIO SANCHEZ HUIHUITOA'],
            // ['previous_name' => 'MARIA MODESTA', 'name' => 'MARIA MODESTA'],
            // ['previous_name' => 'MARIA TERESITA', 'name' => 'MARIA TERESITA GONZALEZ CAMPOS'],
            // ['previous_name' => 'MARIN MONTORO ALEJANDRO', 'name' => 'ALEJANDRO MARIN MONTORO'],
            // ['previous_name' => 'MARTHA ANGELICA CASAS CRUZ', 'name' => 'MARTHA ANGELICA CASAS CRUZ'],
            // ['previous_name' => 'MATEO RAMON AGUILAR', 'name' => 'MATEO RAMON AGUILAR'],
            // ['previous_name' => 'MENDOZA ARELLANO ANTONIO', 'name' => 'ANTONIO MENDOZA ARELLANO'],
            // ['previous_name' => 'NELSON BALDEMAR BAZALDUA REYES', 'name' => 'NELSON BALDEMAR BAZALDUA REYES'],
            // ['previous_name' => 'OMAR OTHONIEL DÍAZ DE LEÓN', 'name' => 'OMAR OTHONIEL DÍAZ DE LEÓN'],
            // ['previous_name' => 'ONEYDA MARGARITA', 'name' => 'ONEYDA MARGARITA GUTIERREZ PACHECO'],
            // ['previous_name' => 'ORTEGA ORTEGA HILDA ISABEL', 'name' => 'HILDA ISABEL ORTEGA ORTEGA'],
            // ['previous_name' => 'ORTIZ ROMO JOSE', 'name' => 'JOSE ORTIZ ROMO'],
            // ['previous_name' => 'PUENTES MEDINA CINTHIA', 'name' => 'CINTHIA PUENTES MEDINA'],
            // ['previous_name' => 'RAMIREZ RAMIREZ BRENDA ISELA', 'name' => 'BRENDA ISELA RAMIREZ RAMIREZ'],
            // ['previous_name' => 'RAMON HERNANDEZ  EDGAR', 'name' => 'EDGAR ALFONSO RAMON HERNANDEZ'],
            // ['previous_name' => 'RAMON HERNANDEZ EDGAR ALFONSO', 'name' => 'EDGAR ALFONSO RAMON HERNANDEZ'],
            // ['previous_name' => 'RAMOS CORTES STEPHANY JAQUELINE', 'name' => 'STEPHANY JAQUELINE RAMOS CORTES'],
            // ['previous_name' => 'RAUL', 'name' => 'RAUL ESTRADA'],
            // ['previous_name' => 'RAUL ESTRADA', 'name' => 'RAUL ESTRADA'],
            // ['previous_name' => 'REYES NIETO RENE ALBERTO', 'name' => 'RENE ALBERTO REYES NIETO'],
            // ['previous_name' => 'RIOJAS HERNANDEZ TANIA MARGARITA', 'name' => 'TANIA MARGARITA RIOJAS HERNANDEZ'],
            // ['previous_name' => 'ROCIO ESMERALDA VÁZQUEZ ABREGO', 'name' => 'ROCIO ESMERALDA VÁZQUEZ ABREGO'],
            // ['previous_name' => 'RODOLFO', 'name' => 'RODOLFO'],
            // ['previous_name' => 'RODRIGUEZ ROMAN ANA GABRIELA', 'name' => 'ANA GABRIELA RODRIGUEZ ROMAN'],
            // ['previous_name' => 'ROMERO ROMERO HÉCTOR ADRIAN', 'name' => 'HÉCTOR ADRIAN ROMERO ROMERO'],
            // ['previous_name' => 'Rubio JUÁREZ ROGELIO', 'name' => 'ROGELIO RUBIO JUÁREZ'],
            // ['previous_name' => 'SAMANTHA GOMEZ', 'name' => 'SAMANTHA GOMEZ'],
            // ['previous_name' => 'SANCHEZ HUIHUITOA MARCO', 'name' => 'MARCO SANCHEZ HUIHUITOA'],
            // ['previous_name' => 'SANCHEZ HUIHUITOA MARCO ANTONIO', 'name' => 'MARCO SANCHEZ HUIHUITOA'],
            // ['previous_name' => 'SANCHEZ RAMIREZ ADRIANA', 'name' => 'ADRIANA SANCHEZ RAMIREZ'],
            // ['previous_name' => 'SANJUANA', 'name' => 'SANJUANA'],
            // ['previous_name' => 'SERRANO NORIEGA JESUS', 'name' => 'JESUS SERRANO NORIEGA'],
            // ['previous_name' => 'SERRANO NORIEGA JESUS.', 'name' => 'JESUS SERRANO NORIEGA'],
            // ['previous_name' => 'SILLER LUBRERAS ELVA MARIA DEL REFUGIO', 'name' => 'ELVA MARIA DEL REFUGIO SILLER LUBRERAS'],
            // ['previous_name' => 'STEPHANY JAQUELINE', 'name' => 'STEPHANY JAQUELINE RAMOS CORTES'],
            // ['previous_name' => 'TANIA MARGARITA', 'name' => 'TANIA MARGARITA RIOJAS HERNANDEZ'],
            // ['previous_name' => 'TELEMARKETING', 'name' => 'TELEMARKETING'],
            // ['previous_name' => 'VAZQUEZ ABREGO ROCIO ESMERALDA', 'name' => 'ROCIO ESMERALDA VÁZQUEZ ABREGO'],
            // ['previous_name' => 'VICTOR MANUEL MARTINEZ ROA', 'name' => 'VICTOR MANUEL MARTINEZ ROA'],
            // ['previous_name' => 'YOSHIGEN CORCHADO', 'name' => 'YOSHIGEN TONATIUH JOSE CORCHADO HERNANDEZ'],
            // ['previous_name' => 'YOSHIGEN TONATIUH JOSE', 'name' => 'YOSHIGEN TONATIUH JOSE CORCHADO HERNANDEZ'],
            // ['previous_name' => 'YOSHIGEN TONATIUH JOSE CORCHADO HERNANDEZ', 'name' => 'YOSHIGEN TONATIUH JOSE CORCHADO HERNANDEZ']
        ];

        foreach ($data as $item) {
            SCoordinator::create($item);
        }
    }
}
