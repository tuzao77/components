<?php

/** Escolhe o controller responsável pela rota solicitada. */
function dispatcher(string $rota, string $parametro, array &$etapas): array
{
    $etapas[] = 'Dispatcher está escolhendo o controller.';
    if ($rota === '/usuarios') {
        return usuarioController($parametro, $etapas);
    }

    // Produz uma resposta previsível quando a rota não existe.
    $etapas[] = 'Dispatcher não encontrou um controller para a rota.';
    return ['sucesso' => false, 'mensagem' => 'Rota não encontrada.', 'usuarios' => [], 'etapas' => $etapas];
}
