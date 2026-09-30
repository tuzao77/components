<?php

/** Analisa a URL e encaminha a requisição ao middleware. */
function router(string $rota, string $parametro, array &$etapas): array
{
    // Registra a rota encontrada para exibi-la posteriormente.
    $etapas[] = "Router identificou a rota {$rota}.";
    return middleware($rota, $parametro, $etapas);
}
