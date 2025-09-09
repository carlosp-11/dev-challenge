<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Productos realistas basados en Dormitorum
        $products = [
            // Colchones de muelles
            ['sku' => 'MUE-001', 'name' => 'Colchón de Muelles Ensacados Premium'],
            ['sku' => 'MUE-002', 'name' => 'Colchón de Muelles Bonnell Confort'],
            ['sku' => 'MUE-003', 'name' => 'Colchón de Muelles Pocket Spring'],
            ['sku' => 'MUE-004', 'name' => 'Colchón de Muelles Multizones'],
            ['sku' => 'MUE-005', 'name' => 'Colchón de Muelles Reforzados'],
            
            // Colchones viscoelásticos
            ['sku' => 'VIS-001', 'name' => 'Colchón Viscoelástico Memory Foam'],
            ['sku' => 'VIS-002', 'name' => 'Colchón Viscoelástico Gel Cooling'],
            ['sku' => 'VIS-003', 'name' => 'Colchón Viscoelástico Termorregulador'],
            ['sku' => 'VIS-004', 'name' => 'Colchón Viscoelástico Adaptable'],
            ['sku' => 'VIS-005', 'name' => 'Colchón Viscoelástico Plus'],
            ['sku' => 'VIS-006', 'name' => 'Colchón Viscoelástico Ergonómico'],
            ['sku' => 'VIS-007', 'name' => 'Colchón Viscoelástico Transpirable'],
            
            // Colchones híbridos
            ['sku' => 'HIB-001', 'name' => 'Colchón Híbrido Muelles + Viscoelástica'],
            ['sku' => 'HIB-002', 'name' => 'Colchón Híbrido Premium'],
            ['sku' => 'HIB-003', 'name' => 'Colchón Híbrido Confort'],
            ['sku' => 'HIB-004', 'name' => 'Colchón Híbrido Advanced'],
            
            // Colchones de látex
            ['sku' => 'LAT-001', 'name' => 'Colchón de Látex Natural'],
            ['sku' => 'LAT-002', 'name' => 'Colchón de Látex Sintético'],
            ['sku' => 'LAT-003', 'name' => 'Colchón de Látex Ecológico'],
            ['sku' => 'LAT-004', 'name' => 'Colchón de Látex Transpirable'],
            
            // Colchones ortopédicos
            ['sku' => 'ORT-001', 'name' => 'Colchón Ortopédico Firme'],
            ['sku' => 'ORT-002', 'name' => 'Colchón Ortopédico Lumbar'],
            ['sku' => 'ORT-003', 'name' => 'Colchón Ortopédico Cervical'],
            ['sku' => 'ORT-004', 'name' => 'Colchón Ortopédico Terapéutico'],
            
            // Colchones juveniles e infantiles
            ['sku' => 'JUV-001', 'name' => 'Colchón Juvenil Crecimiento'],
            ['sku' => 'JUV-002', 'name' => 'Colchón Infantil Hipoalergénico'],
            ['sku' => 'JUV-003', 'name' => 'Colchón Juvenil Deportivo'],
            ['sku' => 'JUV-004', 'name' => 'Colchón Infantil Antibacteriano'],
            
            // Colchones de alta gama
            ['sku' => 'LUX-001', 'name' => 'Colchón Premium Royal'],
            ['sku' => 'LUX-002', 'name' => 'Colchón de Lujo Executive'],
            ['sku' => 'LUX-003', 'name' => 'Colchón Platinum Collection'],
            ['sku' => 'LUX-004', 'name' => 'Colchón Gold Standard'],
            
            // Colchones específicos
            ['sku' => 'ESP-001', 'name' => 'Colchón Anti-Ácaros'],
            ['sku' => 'ESP-002', 'name' => 'Colchón Hipoalergénico'],
            ['sku' => 'ESP-003', 'name' => 'Colchón Antibacteriano'],
            ['sku' => 'ESP-004', 'name' => 'Colchón Termostático'],
            ['sku' => 'ESP-005', 'name' => 'Colchón Climatizado'],
            
            // Colchones por tamaños específicos
            ['sku' => 'TAM-090', 'name' => 'Colchón Individual 90x190'],
            ['sku' => 'TAM-105', 'name' => 'Colchón Individual 105x190'],
            ['sku' => 'TAM-135', 'name' => 'Colchón Matrimonial 135x190'],
            ['sku' => 'TAM-150', 'name' => 'Colchón Matrimonial 150x190'],
            ['sku' => 'TAM-160', 'name' => 'Colchón Queen Size 160x190'],
            ['sku' => 'TAM-180', 'name' => 'Colchón King Size 180x190'],
            ['sku' => 'TAM-200', 'name' => 'Colchón Super King 200x200'],
            
            // Colchones especiales
            ['sku' => 'ESP-006', 'name' => 'Colchón para Personas Mayores'],
            ['sku' => 'ESP-007', 'name' => 'Colchón Articulado'],
            ['sku' => 'ESP-008', 'name' => 'Colchón para Camas Hospitalarias'],
            ['sku' => 'ESP-009', 'name' => 'Colchón Plegable'],
            ['sku' => 'ESP-010', 'name' => 'Colchón Enrollable'],
            
            // Más variaciones
            ['sku' => 'VAR-001', 'name' => 'Colchón Reversible Verano/Invierno'],
            ['sku' => 'VAR-002', 'name' => 'Colchón con Zona Lumbar Reforzada'],
            ['sku' => 'VAR-003', 'name' => 'Colchón con Núcleo de Grafeno'],
            ['sku' => 'VAR-004', 'name' => 'Colchón con Fibras de Bambú'],
            ['sku' => 'VAR-005', 'name' => 'Colchón con Aloe Vera'],
            ['sku' => 'VAR-006', 'name' => 'Colchón con Tejido 3D'],
            ['sku' => 'VAR-007', 'name' => 'Colchón Magnético Terapéutico'],
            ['sku' => 'VAR-008', 'name' => 'Colchón de Espuma de Soja'],
            ['sku' => 'VAR-009', 'name' => 'Colchón Ecológico Bio'],
            ['sku' => 'VAR-010', 'name' => 'Colchón de Alta Densidad'],
            
            // Colchones de firmes gradaciones
            ['sku' => 'FIR-001', 'name' => 'Colchón Extra Firme'],
            ['sku' => 'FIR-002', 'name' => 'Colchón Firme'],
            ['sku' => 'FIR-003', 'name' => 'Colchón Semi-Firme'],
            ['sku' => 'FIR-004', 'name' => 'Colchón Medio'],
            ['sku' => 'FIR-005', 'name' => 'Colchón Suave'],
            
            // Complementos de descanso
            ['sku' => 'COM-001', 'name' => 'Topper Viscoelástico'],
            ['sku' => 'COM-002', 'name' => 'Protector de Colchón Impermeable'],
            ['sku' => 'COM-003', 'name' => 'Funda de Colchón Transpirable'],
            ['sku' => 'COM-004', 'name' => 'Almohada Cervical'],
            ['sku' => 'COM-005', 'name' => 'Almohada Viscoelástica'],
            ['sku' => 'COM-006', 'name' => 'Almohada de Látex'],
            ['sku' => 'COM-007', 'name' => 'Almohada de Plumas'],
            ['sku' => 'COM-008', 'name' => 'Almohada Ergonómica'],
            
            // Colchones innovadores
            ['sku' => 'INN-001', 'name' => 'Colchón Inteligente con Sensores'],
            ['sku' => 'INN-002', 'name' => 'Colchón con Regulación de Temperatura'],
            ['sku' => 'INN-003', 'name' => 'Colchón con Masaje'],
            ['sku' => 'INN-004', 'name' => 'Colchón con Bluetooth'],
            ['sku' => 'INN-005', 'name' => 'Colchón Ajustable Automático'],
            
            // Colchones por temporadas
            ['sku' => 'TEM-001', 'name' => 'Colchón Verano Fresco'],
            ['sku' => 'TEM-002', 'name' => 'Colchón Invierno Cálido'],
            ['sku' => 'TEM-003', 'name' => 'Colchón Primavera Equilibrado'],
            ['sku' => 'TEM-004', 'name' => 'Colchón Otoño Confort'],
            
            // Líneas premium específicas
            ['sku' => 'PRE-001', 'name' => 'Colchón Dormitorum Signature'],
            ['sku' => 'PRE-002', 'name' => 'Colchón Dormitorum Classic'],
            ['sku' => 'PRE-003', 'name' => 'Colchón Dormitorum Elite'],
            ['sku' => 'PRE-004', 'name' => 'Colchón Dormitorum Master'],
            ['sku' => 'PRE-005', 'name' => 'Colchón Dormitorum Supreme'],
            
            // Más variedades para llegar a 100+ productos
            ['sku' => 'EXT-001', 'name' => 'Colchón Deportivo Recovery'],
            ['sku' => 'EXT-002', 'name' => 'Colchón para Embarazadas'],
            ['sku' => 'EXT-003', 'name' => 'Colchón Postoperatorio'],
            ['sku' => 'EXT-004', 'name' => 'Colchón Antiestrés'],
            ['sku' => 'EXT-005', 'name' => 'Colchón Relajante'],
            ['sku' => 'EXT-006', 'name' => 'Colchón Energizante'],
            ['sku' => 'EXT-007', 'name' => 'Colchón Detox'],
            ['sku' => 'EXT-008', 'name' => 'Colchón Antioxidante'],
            ['sku' => 'EXT-009', 'name' => 'Colchón Revitalizante'],
            ['sku' => 'EXT-010', 'name' => 'Colchón Regenerador'],
            
            // Líneas económicas
            ['sku' => 'ECO-001', 'name' => 'Colchón Básico Económico'],
            ['sku' => 'ECO-002', 'name' => 'Colchón Estudiante'],
            ['sku' => 'ECO-003', 'name' => 'Colchón Residencia'],
            ['sku' => 'ECO-004', 'name' => 'Colchón Apartamento'],
            ['sku' => 'ECO-005', 'name' => 'Colchón Hostal'],
            
            // Finales para completar el volumen
            ['sku' => 'FIN-001', 'name' => 'Colchón Resort Hotel'],
            ['sku' => 'FIN-002', 'name' => 'Colchón Spa Wellness'],
            ['sku' => 'FIN-003', 'name' => 'Colchón Business Class'],
            ['sku' => 'FIN-004', 'name' => 'Colchón Executive Suite'],
            ['sku' => 'FIN-005', 'name' => 'Colchón Presidential'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'sku' => $product['sku'],
                'name' => $product['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
