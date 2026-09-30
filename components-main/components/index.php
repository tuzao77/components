<?php

// Executa a simulação antes de montar o conteúdo visual da página.
require_once __DIR__ . '/main.php';
$resultado = executarAplicacao();

/** Protege textos dinâmicos antes de inseri-los no HTML. */
function escapar(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fluxo de uma requisição</title>
    <style>
        /* Paleta centralizada para facilitar mudanças no tema. */
        :root { --fundo:#f4f7fb; --cartao:#fff; --texto:#182230; --suave:#667085; --roxo:#5b5bd6; --claro:#eeeeff; --borda:#e4e7ec; }
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; color:var(--texto); background:radial-gradient(circle at top left,#e8e9ff,var(--fundo) 45%); font-family:Inter,system-ui,sans-serif; }
        /* Mantém o conteúdo centralizado e confortável em qualquer tela. */
        .pagina { width:min(1080px,calc(100% - 32px)); margin:auto; padding:64px 0; }
        .etiqueta { display:inline-block; padding:7px 12px; color:var(--roxo); background:var(--claro); border-radius:999px; font-size:.78rem; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
        h1 { margin:12px 0; font-size:clamp(2rem,5vw,3.6rem); line-height:1.05; }
        .subtitulo { max-width:680px; color:var(--suave); font-size:1.08rem; line-height:1.7; }
        /* Separa o fluxo da requisição e o resultado retornado. */
        .grade { display:grid; grid-template-columns:1.55fr .85fr; gap:24px; margin-top:40px; }
        .cartao { padding:28px; background:var(--cartao); border:1px solid var(--borda); border-radius:24px; box-shadow:0 18px 50px rgba(16,24,40,.08); }
        .cartao h2 { margin:0 0 22px; font-size:1.2rem; }
        .fluxo,.usuarios { margin:0; padding:0; list-style:none; }
        .fluxo { counter-reset:etapa; }
        /* Numera visualmente cada camada percorrida. */
        .fluxo li { position:relative; min-height:58px; padding:8px 0 20px 58px; color:var(--suave); counter-increment:etapa; }
        .fluxo li::before { content:counter(etapa); position:absolute; top:0; left:0; display:grid; width:38px; height:38px; place-items:center; color:white; background:var(--roxo); border-radius:12px; font-weight:800; }
        .fluxo li:not(:last-child)::after { content:""; position:absolute; top:40px; bottom:2px; left:18px; width:2px; background:var(--borda); }
        .status { color:#027a48; font-weight:700; line-height:1.5; }
        .usuarios { display:grid; gap:12px; }
        .usuarios li { display:flex; align-items:center; gap:12px; padding:14px; background:var(--fundo); border-radius:14px; font-weight:650; }
        .avatar { display:grid; width:36px; height:36px; place-items:center; color:var(--roxo); background:var(--claro); border-radius:50%; }
        /* No celular, os cartões passam a ocupar linhas separadas. */
        @media (max-width:760px) { .pagina{padding:40px 0} .grade{grid-template-columns:1fr} .cartao{padding:22px} }
    </style>
</head>
<body>
    <main class="pagina">
        <span class="etiqueta">Arquitetura em camadas</span>
        <h1>Como uma requisição percorre o sistema?</h1>
        <p class="subtitulo">Acompanhe a sequência executada até os dados dos usuários chegarem à interface.</p>

        <section class="grade" aria-label="Demonstração do fluxo da aplicação">
            <article class="cartao">
                <h2>Fluxo da requisição</h2>
                <ol class="fluxo">
                    <!-- Repete um item visual para cada etapa registrada pelo PHP. -->
                    <?php foreach ($resultado['etapas'] as $etapa): ?>
                        <li><?= escapar($etapa) ?></li>
                    <?php endforeach; ?>
                </ol>
            </article>

            <aside class="cartao">
                <h2>Resposta do Service</h2>
                <p class="status"><?= escapar($resultado['mensagem']) ?></p>
                <ul class="usuarios">
                    <!-- Exibe cada usuário retornado pela camada de serviço. -->
                    <?php foreach ($resultado['usuarios'] as $usuario): ?>
                        <li><span class="avatar" aria-hidden="true"><?= escapar(substr($usuario, 0, 1)) ?></span><?= escapar($usuario) ?></li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </section>
    </main>
</body>
</html>
