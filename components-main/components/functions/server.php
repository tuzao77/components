<?php

/** Simula a entrada de uma requisição no servidor HTTP. */
function servidorHttp(): array
{
    // O histórico será compartilhado por todas as camadas da aplicação.
    $etapas = ['Servidor HTTP recebeu a requisição.'];
    return router('/usuarios', 'id-123', $etapas);
}
