<?php include 'header.php'?>
<body class="contenedor">
    <!-- Botón de hamburguesa -->
    <div class="sidebar">
        <div class="logo-contenido">
            <img class="width-img" src="../img/logo.png" alt="">
        </div>
        <div class="menu">
            <a class="boton-sidebar <?php echo ($titulo === 'Inicio') ? 'activo':'';?>" href="inicio.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#FFFFFF">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z" />
                </svg>
                <span class="text">Inicio</span>
            </a>

            <a class="boton-sidebar <?php echo ($titulo === 'Solicitudes') ? 'activo' : ''; ?>" href="solicitudes.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#FFFFFF">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M14.59 2.59c-.38-.38-.89-.59-1.42-.59H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8.83c0-.53-.21-1.04-.59-1.41l-4.82-4.83zM15 18H9c-.55 0-1-.45-1-1s.45-1 1-1h6c.55 0 1 .45 1 1s-.45 1-1 1zm0-4H9c-.55 0-1-.45-1-1s.45-1 1-1h6c.55 0 1 .45 1 1s-.45 1-1 1zm-2-6V3.5L18.5 9H14c-.55 0-1-.45-1-1z" />
                </svg>
                <span class="text">Solicitudes</span>
            </a>

            <a class="boton-sidebar <?php echo ($titulo === 'Laboratorio') ? 'activo':'';?>" href="laboratorio.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#FFFFFF">
                    <path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7v2H9c-.55 0-1 .45-1 1s.45 1 1 1h6c.55 0 1-.45 1-1s-.45-1-1-1h-1v-2h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 14H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1h16c.55 0 1 .45 1 1v10c0 .55-.45 1-1 1z" />
                </svg>
                <span class="text">Laboratorio</span>
            </a>

            <a class="boton-sidebar <?php echo ($titulo === 'Sala de Consultas') ? 'activo':'';?>" href="consultas.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#FFFFFF">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 9h10c.55 0 1 .45 1 1s-.45 1-1 1H7c-.55 0-1-.45-1-1s.45-1 1-1zm6 5H7c-.55 0-1-.45-1-1s.45-1 1-1h6c.55 0 1 .45 1 1s-.45 1-1 1zm4-6H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1z" />
                </svg>
                <span class="text">Sala de Consultas</span>
            </a>

            <a class="boton-sidebar <?php echo ($titulo === 'Impresiones') ? 'activo':'';?>" href="impresiones.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="#FFFFFF">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M19 8H5c-1.66 0-3 1.34-3 3v4c0 1.1.9 2 2 2h2v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2v-2h2c1.1 0 2-.9 2-2v-4c0-1.66-1.34-3-3-3zm-4 11H9c-.55 0-1-.45-1-1v-4h8v4c0 .55-.45 1-1 1zm4-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-2-9H7c-.55 0-1 .45-1 1v2c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1z" />
                </svg>
                <span class="text">Impresiones</span>
            </a>

            <a class="boton-sidebar <?php echo ($titulo === 'Estadistica') ? 'activo':'';?>" href="estadistica.php">
                <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 20 20" height="30px" viewBox="0 0 20 20" width="30px" fill="#FFFFFF">
                    <rect fill="none" height="20" width="20" />
                    <path d="M16.44,15.38c0.51-0.79,0.72-1.79,0.42-2.86c-0.35-1.24-1.41-2.22-2.68-2.46c-2.47-0.47-4.59,1.65-4.12,4.12 c0.24,1.27,1.21,2.33,2.46,2.68c1.07,0.3,2.07,0.09,2.86-0.42l2.03,2.03c0.29,0.29,0.77,0.29,1.06,0l0,0 c0.29-0.29,0.29-0.77,0-1.06L16.44,15.38z M13.5,15.5c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S14.6,15.5,13.5,15.5z M18.41,2.45 L18.41,2.45c0.33,0.23,0.41,0.69,0.19,1.02l-3.49,5.29h0C14.61,8.59,14.07,8.5,13.5,8.5l3.85-5.85 C17.59,2.3,18.07,2.21,18.41,2.45z M13.5,8.5c-0.58,0-1.13,0.1-1.65,0.28l0,0l-0.78-1.1l-2.67,4.2c-0.36,0.57-1.18,0.62-1.61,0.1 l-1.6-1.92l-2.54,4.13c-0.23,0.37-0.72,0.47-1.07,0.22l0,0c-0.32-0.23-0.41-0.67-0.2-1l2.9-4.72C4.63,8.1,5.45,8.04,5.89,8.57 L7.5,10.5l2.7-4.25c0.38-0.6,1.25-0.62,1.66-0.04L13.5,8.5z" />
                </svg>
                <span class="text">Estadistica</span>
            </a>
        </div>
    </div>

</body>

</html>