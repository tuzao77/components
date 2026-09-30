<?php

// Carrega cada camada uma única vez antes de iniciar a aplicação.
require_once __DIR__ . '/functions/server.php';
require_once __DIR__ . '/router/router.php';
require_once __DIR__ . '/middleware/middleware.php';
require_once __DIR__ . '/dispatcher/dispatcher.php';
require_once __DIR__ . '/controllers/usuario_controller.php';
require_once __DIR__ . '/services/usuario_service.php';

/** Oferece um ponto de entrada único para executar todo o fluxo. */
function executarAplicacao(): array
{
    return servidorHttp();
}
