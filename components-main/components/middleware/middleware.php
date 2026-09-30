<?php

/** Verifica se a requisição tem permissão para continuar. */
function middleware(string $rota, string $parametro, array &$etapas): array
{
    $etapas[] = 'Middleware está verificando a requisição.';

    // Em um sistema real, esta condição validaria login ou autorização.
    $permitido = true;
    if (!$permitido) {
        $etapas[] = 'Middleware bloqueou a requisição.';
        return ['sucesso' => false, 'mensagem' => 'Acesso não autorizado.', 'usuarios' => [], 'etapas' => $etapas];
    }

    $etapas[] = 'Middleware permitiu continuar.';
    return dispatcher($rota, $parametro, $etapas);
}
