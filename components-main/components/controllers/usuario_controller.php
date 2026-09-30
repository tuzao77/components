<?php

/** Coordena a consulta e prepara a resposta para a página. */
function usuarioController(string $parametro, array &$etapas): array
{
    $etapas[] = 'Controller recebeu a requisição.';

    // O controller pede os dados ao service sem conhecer sua regra interna.
    $usuarios = usuarioService();
    $etapas[] = 'Controller recebeu os dados do Service.';

    return [
        'sucesso' => true,
        'mensagem' => "Consulta concluída para o parâmetro {$parametro}.",
        'usuarios' => $usuarios,
        'etapas' => $etapas,
    ];
}
