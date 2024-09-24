<?php

return [
    "save" => "Guardar",
    "saved_successfully" => "Guardado exitosamente",
    "group" => "Cuentas",
    "accounts" => [
        "label" => "Cuentas",
        "single" => "Cuenta",
        "coulmns" => [
            "id" => "ID",
            "avatar" => "Avatar",
            "teams" => "Equipos",
            "name" => "Nombre",
            "email" => "Correo electrónico",
            "phone" => "Teléfono",
            "type" => "Tipo",
            "address" => "Dirección",
            "password" => "Contraseña",
            "password_confirmation" => "Confirmación de contraseña",
            "loginBy" => "Iniciar sesión por",
            "is_active" => "¿Está activo?",
            "is_login" => "¿Puede iniciar sesión?",
            "created_at" => "Creado el",
            "updated_at" => "Actualizado el",
        ],
        "filters" => [
            "type" => "Tipo",
            "teams" => "Equipos",
            "is_active" => "¿Está activo?",
            "is_login" => "¿Puede iniciar sesión?",
        ],
        "actions" => [
            "teams" => "Gestionar equipos",
            "impersonate" => "Iniciar sesión como",
            "password" => "Cambiar contraseña",
            "notifications" => "Enviar notificaciones",
            "edit" => "Editar",
            "delete" => "Eliminar",
            "force_delete" => "Eliminar permanentemente",
            "restore" => "Restaurar",
        ],
        "notifications" => [
            "use_notification_template" => "Usar plantilla de notificación",
            "template_id" => "Plantilla",
            "image" => "Imagen",
            "title" => "Título",
            "body" => "Cuerpo",
            "action" => "Acción",
            "url" => "URL",
            "icon" => "Icono",
            "type" => "Tipo",
            "providers" => "Enviar por"
        ],
        "export" => [
            "title" => "Exportar",
            "columns" => "Columnas"
        ],
        "import" => [
            "title" => "Importar",
            "excel" => "Excel",
            "hint" => "Puedes subir el mismo estilo de archivo exportado",
            "success" => 'Éxito',
            "body" => 'Cuentas importadas exitosamente',
            "error" => "Error",
            "error-body" => "Error al importar las cuentas",
        ]
    ],
    "meta" => [
        "label" => "Metas",
        "single" => "Meta",
        "create" => "Crear Meta",
        "columns" => [
            "account" => "Cuenta",
            "key" => "Clave",
            "value" => "Valor"
        ],
    ],
    "locations" => [
        "label" => "Ubicaciones",
        "single" => "Ubicación",
        "create" => "Crear Ubicación",
    ],
    "requests" => [
        "label" => "Solicitudes de cuenta",
        "single" => "Solicitud de cuenta",
        "columns" => [
            "account" => "Cuenta",
            "user" => "Usuario",
            "type" => "Tipo",
            "status" => "Estado",
            "is_approved" => "¿Está aprobado?",
            "is_approved_at" => "Aprobado el"
        ],
    ],
    "contacts" => [
        "label" => "Contactos",
        "single" => "Contacto",
        "columns" => [
            "type" => "Tipo",
            "status" => "Estado",
            "name" => "Nombre",
            "email" => "Correo electrónico",
            "phone" => "Teléfono",
            "subject" => "Asunto",
            "message" => "Mensaje",
            "active" => "Activo"
        ],
    ],
    "profile" => [
        "title" => "Editar perfil",
        "edit" => [
            "title" => "Editar información",
            "description" => "Actualiza la información de perfil y la dirección de correo electrónico de tu cuenta.",
            "name" => "Nombre",
            "email" => "Correo electrónico",
        ],
        "password" => [
            "title" => "Cambiar contraseña",
            "description" => "Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantenerla segura.",
            "current_password" => "Contraseña actual",
            "new_password" => "Nueva contraseña",
            "confirm_password" => "Confirmar contraseña",
        ],
        "browser" => [
            "sessions_last_active"  => "Última actividad",
            "browser_section_title" => "Sesiones de navegador",
            "browser_section_description" => "Gestiona y cierra tus sesiones activas en otros navegadores y dispositivos.",
            "browser_sessions_log_out" => "Cerrar otras sesiones de navegador",
            "browser_sessions_confirm_pass" => "Por favor ingresa tu contraseña para confirmar que deseas cerrar tus otras sesiones de navegador en todos tus dispositivos.",
            "password" => "Contraseña",
            "confirm" => "Confirmar",
            "nevermind" => "No importa",
            "browser_sessions_logout_notification" => "Se han cerrado tus sesiones de navegador.",
            "browser_sessions_logout_failed_notification" => "Tu contraseña es incorrecta.",
            "sessions_device" => "Dispositivo",
            "sessions_content" => "Dispositivos conectados",
            "incorrect_password" => "La contraseña que ingresaste es incorrecta.",
        ],
        "delete" => [
            "delete_account" => "Eliminar cuenta",
            "delete_account_description" => "Eliminar permanentemente tu cuenta.",
            "incorrect_password" => "La contraseña que ingresaste es incorrecta.",
            "are_you_sure" => "¿Estás seguro de que deseas eliminar tu cuenta? Una vez eliminada, todos sus recursos y datos se perderán permanentemente. Por favor ingresa tu contraseña para confirmar.",
            "yes_delete_it" => "Sí, eliminar",
            "password" => "Contraseña",
            "delete_account_card_description" => "Una vez eliminada, todos sus recursos y datos se perderán permanentemente. Antes de eliminar tu cuenta, descarga cualquier dato o información que desees conservar.",
        ],
        "delete-team" => [
            "title" => "Eliminar equipo",
            "description" => "Eliminar permanentemente tu equipo.",
            "body" => "Una vez eliminado el equipo, todos sus recursos y datos se perderán permanentemente. Antes de eliminar este equipo, descarga cualquier dato o información relacionada que desees conservar.",
            "delete" => "Eliminar equipo",
            "delete_account" => "Eliminar equipo",
            "delete_account_description" => "¿Estás seguro de que deseas eliminar tu equipo? Una vez eliminado, todos sus recursos y datos se perderán permanentemente. Por favor ingresa tu contraseña para confirmar.",
            "yes_delete_it" => "Sí, eliminar",
            "password" => "Contraseña",
            "incorrect_password" => "La contraseña que ingresaste es incorrecta.",
            "are_you_sure" => "¿Estás seguro de que deseas eliminar tu equipo? Una vez eliminado, todos sus recursos y datos se perderán permanentemente. Por favor ingresa tu contraseña para confirmar.",
        ],
        "token" => [
            "title" => "Tokens API",
            "description" => "Los tokens API permiten que servicios externos se autentiquen en nuestra aplicación en tu nombre.",
            "name" => "Nombre",
            "created_at" => "Creado el",
            "expires_at" => "Expira el",
            "abilities" => "Habilidades",
            "action_label" => "Crear token",
            "create_notification" => "¡Token creado exitosamente!",
            "modal_heading" => "Crear token",
            "empty_state_heading" => "Sin tokens",
            "empty_state_description" => "Crea un nuevo token para autenticarte con la API.",
            "delete_token" => "Eliminar token",
            "delete_token_description" => "¿Estás seguro de que deseas eliminar este token?",
            "delete_token_confirmation" => "Sí, eliminar",
            "delete_token_notification" => "¡Token eliminado exitosamente!",
            "modal_heading_2" => "Token creado exitosamente",
            "helper_text" => "Puedes editar el token a continuación. Asegúrate de copiarlo ahora, ya que no podrás verlo de nuevo.",
            "token" => "Token",
        ],
    ],
    "teams" => [
        "title" => "Configuraciones del equipo",
        "actions" => [
            "cancel_invitation" => "Cancelar invitación",
            "resend_invitation" => "Reenviar invitación",
        ],
        "edit" => [
            "title" => "Editar nombre del equipo",
            "description" => "Actualiza la información del perfil y la dirección de correo electrónico de tu equipo.",
            "name" => "Nombre",
            "email" => "Correo electrónico",
            "avatar" => "Avatar",
            "save" => "Guardar",
            "owner" => "Propietario"
        ],
        "members" => [
            "title" => "Invitar miembros del equipo",
            "description" => "Añadir un nuevo miembro al equipo para que pueda colaborar contigo.",
            "team-members" => "Proporciona la dirección de correo electrónico de la persona que deseas invitar a este equipo.",
            "send_invitation" => "Enviar invitación",
            "pending_invitations" => "Invitaciones pendientes",
            "invited_at" => "Invitado el",
            "leave_team" => "Dejar equipo",
            "remove_team_member" => "Eliminar del equipo",
            "remove_team_member_notification" => "¡Eliminado del equipo!",
            "leave_team_notification" => "¡Has dejado el equipo!",
        ],
    ],
    "team" => [
        "title" => "Equipos",
        "single" => "Equipo",
        "columns" => [
            "avatar" => "Avatar",
            "name" => "Nombre",
            "owner" => "Propietario",
            "personal_team" => "Equipo Personal",
        ],
    ],

    "roles" => [
        "admin" => [
            "name" => "Administrador",
            "description" => "Los usuarios administradores pueden realizar cualquier acción."
        ],
        "user" => [
            "name" => "Usuario",
            "description" => "Los usuarios pueden leer y actualizar datos."
        ],
    ],

    "login" => [
        "active" => "Por favor, verifica tu cuenta primero y luego intenta iniciar sesión nuevamente.",
    ],

    "settings" => [
        "types" => [
            "title" => "Tipos de Cuentas"
        ]
    ],

    "address" => [
        "title" => "Editar Ubicaciones"
    ],

    "account-requests" => [
        "title" => "Solicitudes",
        "status" => "Estado de la Solicitud",
        "types" => "Tipos de Solicitud",
        "button" => "Gestionar Tipos y Estados"
    ],

    "contact-us" => [
        "status" => "Editar Estado de Contáctenos",
        "status-button" => "Gestionar Estado",
        "footer" => "¿Tienes algún problema o pregunta? Por favor",
        "modal" => "Por favor llena este formulario para contactarnos",
        "label" => "Contáctenos",
        "form" => [
            "name" => "Nombre",
            "email" => "Correo Electrónico",
            "phone" => "Teléfono",
            "subject" => "Asunto",
            "message" => "Mensaje",
        ],
        "notification" => [
            "title" => "Contáctenos",
            "body" => "Tu mensaje ha sido enviado con éxito",
        ]
    ]

];