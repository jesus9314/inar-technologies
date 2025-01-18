{{-- <div>
    <div class="header">
        <h1>Reporte de Mantenimiento</h1>
        <p>Código: <strong>{{ $record['code'] }}</strong></p>
        <p>Fecha de Inicio: {{ $record['start_date'] }} - Fecha de Fin: {{ $record['end_date'] }}</p>
    </div>

    <div class="section">
        <h2>Información del Cliente</h2>
        <p><strong>Nombre:</strong> {{ $record['customer']['display_name'] }}</p>
        <p><strong>Número de Documento:</strong> {{ $record['customer']['document_number'] }}</p>
    </div>

    <div class="section">
        <h2>Información del Equipo</h2>
        <p><strong>Nombre del Equipo:</strong> {{ $record['device']['name'] }}</p>
        <p><strong>Descripción:</strong> {{ $record['device']['description'] ?? 'No especificada' }}</p>
    </div>
</div> --}}

{{-- <div class="p-6 bg-white text-gray-800">
    <!-- Encabezado -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 text-center">Detalle del Mantenimiento</h1>
        <p class="text-sm text-gray-600">Código: 0002</p>
    </div>

    <!-- Información del cliente -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Cliente</h2>
        <p class="text-sm">
            <span class="font-bold">Nombre:</span> Tiffany Del Carmen Alfaro Apaestegui
        </p>
        <p class="text-sm">
            <span class="font-bold">DNI:</span> 71454930
        </p>
    </div>

    <!-- Información del dispositivo -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Dispositivo</h2>
        <p class="text-sm">
            <span class="font-bold">Nombre:</span> DESKTOP-0001-0000
        </p>
        <p class="text-sm">
            <span class="font-bold">Tipo:</span> PC de Escritorio
        </p>
    </div>

    <!-- Información del mantenimiento -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Mantenimiento</h2>
        <p class="text-sm">
            <span class="font-bold">Estado:</span> <span class="text-yellow-500">En curso</span>
        </p>
        <p class="text-sm">
            <span class="font-bold">Inicio:</span> 16/01/2025
        </p>
        <p class="text-sm">
            <span class="font-bold">Fin:</span> 18/01/2025
        </p>
        <p class="text-sm">
            <span class="font-bold">Solicitudes del cliente:</span> No especificado
        </p>
        <p class="text-sm">
            <span class="font-bold">Recomendaciones:</span> No especificado
        </p>
    </div>

    <!-- Fallas y soluciones -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Fallas y Soluciones</h2>
        <ul class="list-disc list-inside text-sm">
            <li>
                <span class="font-bold">Falla:</span> sadfasdf
                <br />
                <span class="font-bold">Solución:</span> asfdasdf
            </li>
        </ul>
    </div>

    <!-- Procedimientos -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Procedimientos</h2>
        <ul class="list-disc list-inside text-sm">
            <li>
                <span class="font-bold">Procedimiento:</span> safdasdf
                <br />
                <span class="font-bold">Estado:</span> Pendiente
            </li>
        </ul>
    </div>

    <!-- Documentos -->
    <div>
        <h2 class="text-lg font-semibold text-gray-800">Documentos Generados</h2>
        <ul class="list-disc list-inside text-sm">
            <li>Código: 0002RMC</li>
            <li>Código: 0002CGSM</li>
        </ul>
    </div>
</div> --}}

<div class="p-6 bg-white text-gray-800">
    <!-- Encabezado -->
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 uppercase">InarTechnologies</h1>
        <p class="text-sm text-gray-600">
            Especialistas en soluciones tecnológicas: mantenimiento, reparación y optimización de computadoras.
        </p>
    </div>

    <!-- Título -->
    <div class="text-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800 uppercase">Reporte de Mantenimiento</h2>
        <p class="text-sm">Código: {{ $record['code'] }}</p>
        <p class="text-sm">Fecha de Inicio: {{ $record['start_date'] }} - Fecha de Fin: {{ $record['end_date'] }}</p>
    </div>

    <!-- Datos del Cliente -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Datos del Cliente</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><span class="font-bold">Nombre:</span> {{ $record['customer']['display_name'] }}</p>
            <p><span class="font-bold">Documento:</span> {{ $record['customer']['document_number'] }}</p>
            <p><span class="font-bold">Técnico:</span> {{ $record['user']['name'] }}
                {{ $record['user']['last_name_p'] }} {{ $record['user']['last_name_m'] }}</p>
        </div>
    </div>

    <!-- Datos del Equipo -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Datos del Equipo</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <p><span class="font-bold">Nombre del Equipo:</span> {{ $record['device']['name'] }}</p>
            <p><span class="font-bold">Tipo:</span> Escritorio</p> <!-- Cambiar dinámicamente si es necesario -->
            <p><span class="font-bold">Descripción:</span> {{ $record['device']['description'] ?? 'No especificada' }}
            </p>
        </div>
    </div>

    <!-- Estado del Mantenimiento -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Estado del Mantenimiento</h3>
        <p class="text-sm">
            <span class="font-bold">Estado:</span>
            <span class="text-yellow-500">{{ $record['maintenanceState']['name'] }}</span>
        </p>
    </div>

    <!-- Fallas y Soluciones -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Fallas y Soluciones</h3>
        @if (!empty($record['maintenance_issues']))
            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-2 py-1 text-left">Falla</th>
                        <th class="border border-gray-300 px-2 py-1 text-left">Solución</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($record['maintenance_issues'] as $issue)
                        <tr>
                            <td class="border border-gray-300 px-2 py-1">{!! $issue['issues'] !!}</td>
                            <td class="border border-gray-300 px-2 py-1">{!! $issue['solution'] !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No se registraron fallas.</p>
        @endif
    </div>

    <!-- Procedimientos -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Procedimientos</h3>
        @if (!empty($record['maintenance_procedures']))
            <ol class="list-decimal list-inside text-sm">
                @foreach ($record['maintenance_procedures'] as $procedure)
                    <li>{{ $procedure['name'] }} -
                        {{ $procedure['status'] === '0' ? 'Pendiente' : 'Completado' }}</li>
                @endforeach
            </ol>
        @else
            <p>No se registraron procedimientos.</p>
        @endif
    </div>

    <!-- Documentos Generados -->
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Documentos Generados</h3>
        <ul class="list-disc list-inside text-sm">
            @foreach ($record['documents'] as $document)
                <li>Código: {{ $document['code'] }}</li>
            @endforeach
        </ul>
    </div>
</div>
