<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class GenerarInformeTecnico extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generar:informe-tecnico';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera el Informe Técnico del Plan de Trabajo en formato DOCX';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generando Informe Técnico del Plan de Trabajo...');

        try {
            // Crear instancia de PHPWord
            $phpWord = new PhpWord();

            // Configurar estilos
            $phpWord->addFontStyle('titleStyle', ['bold' => true, 'size' => 24, 'name' => 'Arial']);
            $phpWord->addFontStyle('heading1Style', ['bold' => true, 'size' => 16, 'name' => 'Arial', 'color' => '00008B']);
            $phpWord->addFontStyle('heading2Style', ['bold' => true, 'size' => 14, 'name' => 'Arial', 'color' => '003366']);
            $phpWord->addFontStyle('boldText', ['bold' => true]);
            $phpWord->addFontStyle('italicText', ['italic' => true]);

            $phpWord->addParagraphStyle('centerPara', ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]);
            $phpWord->addParagraphStyle('justifyPara', ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH, 'spaceAfter' => 200]);

            // Agregar sección
            $section = $phpWord->addSection();

            // === PORTADA ===
            $section->addText('INFORME TÉCNICO DEL PLAN DE TRABAJO', 'titleStyle', 'centerPara');
            $section->addTextBreak(1);
            $section->addText('Red de Ventas - Arepa la Llanerita', 'heading1Style', 'centerPara');
            $section->addTextBreak(1);
            $section->addText('Sistema de Gestión Multinivel (MLM)', ['size' => 12], 'centerPara');
            $section->addTextBreak(2);

            $section->addText('Desarrolladores:', 'boldText', 'centerPara');
            $section->addTextBreak(1);
            $section->addText('Juan Sebastián Lozada Ceballos', null, 'centerPara');
            $section->addText('Luis Alberto Urrea Trujillo', null, 'centerPara');
            $section->addTextBreak(2);

            $section->addText('Período del Proyecto:', 'boldText', 'centerPara');
            $section->addTextBreak(1);
            $section->addText('8 de septiembre de 2025 - 22 de octubre de 2025', null, 'centerPara');

            $section->addPageBreak();

            // === 1. INTRODUCCIÓN ===
            $section->addText('1. INTRODUCCIÓN', 'heading1Style');
            $section->addTextBreak(1);

            $intro1 = 'El presente informe técnico documenta el desarrollo del proyecto Red de Ventas - Arepa la Llanerita, ';
            $intro1 .= 'un sistema integral de gestión de ventas multinivel (MLM) diseñado específicamente para la comercialización ';
            $intro1 .= 'de arepas tradicionales venezolanas.';
            $section->addText($intro1, null, 'justifyPara');

            $intro2 = 'Este proyecto surge de la necesidad de modernizar y optimizar la gestión de una red de distribución de ';
            $intro2 .= 'productos alimenticios tradicionales, implementando tecnologías modernas de desarrollo web que permitan ';
            $intro2 .= 'gestionar eficientemente vendedores, clientes, pedidos, inventarios y un complejo sistema de comisiones multinivel.';
            $section->addText($intro2, null, 'justifyPara');

            $intro3 = 'El sistema fue desarrollado utilizando Laravel 12 como framework principal de backend, MongoDB como base de ';
            $intro3 .= 'datos NoSQL para optimizar el rendimiento y escalabilidad, y diversas tecnologías modernas de frontend para ';
            $intro3 .= 'proporcionar una interfaz de usuario intuitiva y responsiva.';
            $section->addText($intro3, null, 'justifyPara');

            $intro4 = 'Durante el período comprendido entre el 8 de septiembre y el 22 de octubre de 2025, el equipo de desarrollo ';
            $intro4 .= 'conformado por Juan Sebastián Lozada Ceballos y Luis Alberto Urrea Trujillo trabajó de manera colaborativa ';
            $intro4 .= 'en la concepción, diseño, implementación y pruebas del sistema.';
            $section->addText($intro4, null, 'justifyPara');

            // === 2. OBJETIVOS ===
            $section->addText('2. OBJETIVOS', 'heading1Style');
            $section->addTextBreak(1);

            $section->addText('2.1 Objetivo General', 'heading2Style');
            $section->addTextBreak(1);

            $obj1 = 'Desarrollar e implementar un sistema web integral de gestión de ventas multinivel que permita administrar ';
            $obj1 .= 'eficientemente la red de distribución de Arepa la Llanerita, optimizando los procesos de ventas, gestión de ';
            $obj1 .= 'inventarios, cálculo de comisiones y seguimiento de la red de referidos.';
            $section->addText($obj1, null, 'justifyPara');

            $section->addText('2.2 Objetivos Específicos', 'heading2Style');
            $section->addTextBreak(1);

            $objectives = [
                '1. Implementar un sistema de autenticación y autorización robusto con roles diferenciados que garantice la seguridad y el acceso controlado.',
                '2. Desarrollar módulos de gestión para usuarios, productos, categorías, pedidos e inventarios con operaciones CRUD completas.',
                '3. Implementar un sistema de comisiones multinivel con cálculo automatizado basado en las ventas directas e indirectas.',
                '4. Crear un sistema de referidos jerárquico que permita el seguimiento de la red de ventas y códigos únicos.',
                '5. Desarrollar dashboards personalizados por rol con métricas relevantes y gráficos estadísticos en tiempo real.',
                '6. Optimizar el rendimiento mediante MongoDB, cache inteligente, consultas optimizadas y lazy loading.',
                '7. Garantizar la calidad del código mediante mejores prácticas, patrones de diseño y documentación completa.'
            ];

            foreach ($objectives as $objective) {
                $section->addText($objective, null, 'justifyPara');
            }

            // === 3. ALCANCE DEL PROYECTO ===
            $section->addPageBreak();
            $section->addText('3. ALCANCE DEL PROYECTO', 'heading1Style');
            $section->addTextBreak(1);

            $section->addText('3.1 Funcionalidades Incluidas', 'heading2Style');
            $section->addTextBreak(1);

            $funcionalidades = [
                ['Sistema de Autenticación:', 'Login, logout, registro, recuperación de contraseñas con tokens y validación de sesiones.'],
                ['Gestión de Usuarios:', 'CRUD completo con asignación de roles, gestión de perfiles y seguimiento de actividad.'],
                ['Gestión de Productos:', 'Catálogo con categorización, control de inventarios y alertas de stock bajo.'],
                ['Sistema de Pedidos:', 'Creación de pedidos, seguimiento de estados y gestión de zonas de entrega.'],
                ['Sistema de Comisiones:', 'Cálculo automatizado de comisiones y reportes detallados con exportación.'],
                ['Red de Referidos:', 'Códigos únicos de referido, estructura jerárquica y visualización de árbol.'],
                ['Dashboards y Reportes:', 'Dashboards personalizados con gráficos interactivos y KPIs en tiempo real.'],
                ['Sistema de Auditoría:', 'Registro completo de operaciones con trazabilidad de cambios.']
            ];

            foreach ($funcionalidades as $func) {
                $textRun = $section->addTextRun('justifyPara');
                $textRun->addText($func[0] . ' ', 'boldText');
                $textRun->addText($func[1]);
            }

            $section->addTextBreak(1);
            $section->addText('3.2 Límites del Proyecto', 'heading2Style');
            $section->addTextBreak(1);

            $section->addText('El proyecto no incluye:', null, 'justifyPara');

            $limites = [
                'Pasarela de pagos en línea (se contempla para versiones futuras)',
                'Aplicación móvil nativa (el sistema es responsive pero no es app nativa)',
                'Integración con sistemas contables externos',
                'Sistema de punto de venta (POS) físico',
                'Notificaciones push en dispositivos móviles'
            ];

            foreach ($limites as $limite) {
                $section->addListItem($limite);
            }

            // === 4. METODOLOGÍA DE TRABAJO ===
            $section->addPageBreak();
            $section->addText('4. METODOLOGÍA DE TRABAJO', 'heading1Style');
            $section->addTextBreak(1);

            $metod1 = 'Para el desarrollo de este proyecto se adoptó una metodología ágil adaptada a las necesidades específicas ';
            $metod1 .= 'del equipo de dos desarrolladores, combinando elementos de Scrum y programación en pareja.';
            $section->addText($metod1, null, 'justifyPara');

            $section->addText('4.1 Fases del Proyecto', 'heading2Style');
            $section->addTextBreak(1);

            $fases = [
                ['Fase 1 (8-12 sept):', 'Levantamiento de requerimientos, análisis de necesidades y diseño de arquitectura.'],
                ['Fase 2 (13-17 sept):', 'Diseño de base de datos MongoDB y definición de modelos de datos.'],
                ['Fase 3 (18 sept-3 oct):', 'Implementación de autenticación y desarrollo de módulos base.'],
                ['Fase 4 (4-12 oct):', 'Sistema de comisiones multinivel y red de referidos.'],
                ['Fase 5 (13-18 oct):', 'Pruebas exhaustivas y optimización de rendimiento.'],
                ['Fase 6 (19-22 oct):', 'Documentación técnica y preparación de entrega final.']
            ];

            foreach ($fases as $fase) {
                $textRun = $section->addTextRun('justifyPara');
                $textRun->addText($fase[0] . ' ', 'boldText');
                $textRun->addText($fase[1]);
            }

            // === 5. RECURSOS UTILIZADOS ===
            $section->addPageBreak();
            $section->addText('5. RECURSOS UTILIZADOS', 'heading1Style');
            $section->addTextBreak(1);

            $section->addText('5.1 Recursos Tecnológicos', 'heading2Style');
            $section->addTextBreak(1);

            $section->addText('Tecnologías de Backend:', 'boldText');
            $backend_tech = [
                'Laravel 12.x - Framework PHP principal',
                'PHP 8.2 - Lenguaje de programación',
                'MongoDB 5.x - Base de datos NoSQL principal',
                'MySQL 8.x - Base de datos auxiliar',
                'Redis - Sistema de cache',
                'Composer - Gestor de dependencias PHP'
            ];

            foreach ($backend_tech as $tech) {
                $section->addListItem($tech);
            }

            $section->addTextBreak(1);
            $section->addText('Tecnologías de Frontend:', 'boldText');
            $frontend_tech = [
                'Livewire 3.6 - Componentes reactivos',
                'Bootstrap 5.2.3 - Framework CSS',
                'Alpine.js - Interactividad JavaScript',
                'Chart.js - Gráficos estadísticos',
                'Vite 7.x - Build tool',
                'Bootstrap Icons - Iconografía'
            ];

            foreach ($frontend_tech as $tech) {
                $section->addListItem($tech);
            }

            $section->addTextBreak(1);
            $section->addText('5.2 Recursos Humanos', 'heading2Style');
            $section->addTextBreak(1);

            $recursos_humanos = [
                ['Equipo de Desarrollo:', '2 desarrolladores full-stack durante 6 semanas.'],
                ['Juan Sebastián Lozada:', 'Backend, lógica de negocio y sistema de comisiones.'],
                ['Luis Alberto Urrea:', 'Frontend, diseño de interfaces e implementación de dashboards.']
            ];

            foreach ($recursos_humanos as $recurso) {
                $textRun = $section->addTextRun('justifyPara');
                $textRun->addText($recurso[0] . ' ', 'boldText');
                $textRun->addText($recurso[1]);
            }

            // === 6. ROLES Y RESPONSABILIDADES ===
            $section->addPageBreak();
            $section->addText('6. ROLES Y RESPONSABILIDADES', 'heading1Style');
            $section->addTextBreak(1);

            $roles1 = 'El equipo de desarrollo estuvo conformado por dos integrantes que asumieron responsabilidades específicas, ';
            $roles1 .= 'aunque trabajaron de manera colaborativa en todas las fases del proyecto.';
            $section->addText($roles1, null, 'justifyPara');

            $section->addText('6.1 Juan Sebastián Lozada Ceballos', 'heading2Style');
            $section->addTextBreak(1);
            $section->addText('Responsabilidades Principales:', 'boldText');

            $juan_resp = [
                'Diseño y configuración de la arquitectura del sistema',
                'Implementación de modelos de datos MongoDB',
                'Desarrollo del sistema de autenticación y autorización',
                'Lógica de negocio del sistema de comisiones multinivel',
                'Optimización de consultas y rendimiento de base de datos',
                'Sistema de auditoría y trazabilidad',
                'Validaciones y reglas de negocio'
            ];

            foreach ($juan_resp as $resp) {
                $section->addListItem($resp);
            }

            $section->addTextBreak(1);
            $section->addText('6.2 Luis Alberto Urrea Trujillo', 'heading2Style');
            $section->addTextBreak(1);
            $section->addText('Responsabilidades Principales:', 'boldText');

            $luis_resp = [
                'Diseño de interfaces de usuario (UI/UX)',
                'Implementación de vistas Blade y componentes Livewire',
                'Desarrollo de dashboards personalizados por rol',
                'Integración de Chart.js para gráficos',
                'Sistema de reportes y exportación de datos',
                'Diseño responsive y adaptabilidad móvil',
                'Elaboración de documentación de usuario'
            ];

            foreach ($luis_resp as $resp) {
                $section->addListItem($resp);
            }

            // === 7. PROPUESTAS DE MEJORA ===
            $section->addPageBreak();
            $section->addText('7. PROPUESTAS DE MEJORA', 'heading1Style');
            $section->addTextBreak(1);

            $prop1 = 'Basándose en el desarrollo actual del sistema y las necesidades identificadas durante el proyecto, ';
            $prop1 .= 'se proponen las siguientes mejoras para futuras versiones:';
            $section->addText($prop1, null, 'justifyPara');

            $section->addText('7.1 Mejoras Funcionales', 'heading2Style');
            $section->addTextBreak(1);

            $mejoras_funcionales = [
                ['1. Pasarela de Pagos:', 'Implementar pasarelas electrónicas para facilitar transacciones.'],
                ['2. App Móvil:', 'Desarrollar apps nativas con Flutter o React Native.'],
                ['3. Notificaciones:', 'Sistema en tiempo real mediante WebSockets.'],
                ['4. Geolocalización:', 'Integrar mapas y optimización de rutas.'],
                ['5. IA y Analytics:', 'Predicción de ventas con machine learning.'],
                ['6. Fidelización:', 'Programa de puntos y gamificación.']
            ];

            foreach ($mejoras_funcionales as $mejora) {
                $textRun = $section->addTextRun('justifyPara');
                $textRun->addText($mejora[0] . ' ', 'boldText');
                $textRun->addText($mejora[1]);
            }

            // === 8. RESULTADOS ESPERADOS ===
            $section->addPageBreak();
            $section->addText('8. RESULTADOS ESPERADOS', 'heading1Style');
            $section->addTextBreak(1);

            $section->addText('8.1 Resultados Funcionales', 'heading2Style');
            $section->addTextBreak(1);

            $resultados = [
                ['Sistema Completo:', 'Sistema web funcional que cubra todos los procesos de gestión.'],
                ['Automatización:', 'Reducir 70% el tiempo en tareas administrativas manuales.'],
                ['Visibilidad:', 'Visibilidad completa de la red de ventas en tiempo real.'],
                ['Escalabilidad:', 'Soportar desde 50 hasta 5,000 vendedores activos.']
            ];

            foreach ($resultados as $resultado) {
                $textRun = $section->addTextRun('justifyPara');
                $textRun->addText($resultado[0] . ' ', 'boldText');
                $textRun->addText($resultado[1]);
            }

            $section->addTextBreak(1);
            $section->addText('8.2 Indicadores de Éxito (KPIs)', 'heading2Style');
            $section->addTextBreak(1);

            $kpis = [
                'Tiempo de procesamiento de pedidos: < 5 minutos',
                'Tiempo de cálculo de comisiones: < 30 segundos para 1000 transacciones',
                'Tasa de error en cálculos: < 0.1%',
                'Tiempo de respuesta del sistema: < 2 segundos (95%)',
                'Disponibilidad del sistema: > 99.5%',
                'Satisfacción de usuarios: > 4.5/5',
                'Adopción del sistema: > 90% en primer mes'
            ];

            foreach ($kpis as $kpi) {
                $section->addListItem($kpi);
            }

            // === 9. CONCLUSIONES ===
            $section->addPageBreak();
            $section->addText('9. CONCLUSIONES', 'heading1Style');
            $section->addTextBreak(1);

            $conclusiones = [
                'El desarrollo del proyecto Red de Ventas - Arepa la Llanerita ha cumplido satisfactoriamente con los objetivos establecidos. Durante 6 semanas se implementó un sistema integral de gestión multinivel que moderniza los procesos operativos.',
                
                'La elección de tecnologías modernas como Laravel 12, MongoDB y Livewire permitió desarrollar una aplicación escalable y eficiente. La arquitectura híbrida proporcionó la flexibilidad necesaria.',
                
                'El sistema de comisiones multinivel fue implementado exitosamente con cálculos automatizados precisos. La red de referidos permite un seguimiento efectivo de la estructura organizacional.',
                
                'La colaboración entre los dos desarrolladores resultó altamente efectiva, combinando fortalezas complementarias para entregar un producto cohesivo de alta calidad.',
                
                'Las optimizaciones implementadas han resultado en un sistema con excelente rendimiento. El sistema de auditoría proporciona trazabilidad total de operaciones.',
                
                'La documentación desarrollada asegura que el sistema pueda ser mantenido y utilizado efectivamente por el equipo técnico y usuarios finales.',
                
                'En conclusión, el proyecto entrega una plataforma robusta y escalable que posiciona a Arepa la Llanerita para un crecimiento sostenible.'
            ];

            foreach ($conclusiones as $conclusion) {
                $section->addText($conclusion, null, 'justifyPara');
            }

            // === FIRMAS ===
            $section->addTextBreak(3);
            $section->addText('_____________________________________', null, 'centerPara');
            $section->addText('Juan Sebastián Lozada Ceballos', null, 'centerPara');
            $section->addText('Desarrollador Backend', null, 'centerPara');
            $section->addTextBreak(2);

            $section->addText('_____________________________________', null, 'centerPara');
            $section->addText('Luis Alberto Urrea Trujillo', null, 'centerPara');
            $section->addText('Desarrollador Frontend', null, 'centerPara');
            $section->addTextBreak(2);

            $section->addText('Fecha de Entrega: 22 de octubre de 2025', 'italicText', 'centerPara');

            // Guardar el documento
            $outputPath = base_path('Documentación/INFORME_TECNICO_PLAN_DE_TRABAJO.docx');
            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($outputPath);

            $this->info('✅ Documento generado exitosamente en: Documentación/INFORME_TECNICO_PLAN_DE_TRABAJO.docx');
            
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error al generar el documento: ' . $e->getMessage());
            $this->error($e->getTraceAsString());
            return Command::FAILURE;
        }
    }
}
