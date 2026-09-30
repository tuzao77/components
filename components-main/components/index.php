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
        /* Novo esquema de cores Dark/Moderno em tons de esmeralda e ardósia */
        :root { 
            --fundo: #0f172a; 
            --cartao: #1e293b; 
            --texto: #f8fafc; 
            --suave: #94a3b8; 
            --destaque: #10b981; 
            --claro: rgba(16, 185, 129, 0.12); 
            --borda: #334155; 
        }

        * { box-sizing: border-box; }

        body { 
            margin: 0; 
            min-height: 100vh; 
            color: var(--texto); 
            background: radial-gradient(circle at top right, #1e1b4b, var(--fundo) 50%); 
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
        }

        /* Container principal */
        .pagina { 
            width: min(1080px, calc(100% - 32px)); 
            margin: auto; 
            padding: 56px 0; 
        }

        .etiqueta { 
            display: inline-flex; 
            align-items: center; 
            padding: 6px 16px; 
            color: var(--destaque); 
            background: var(--claro); 
            border: 1px solid rgba(16, 185, 129, 0.3); 
            border-radius: 8px; 
            font-size: 0.8rem; 
            font-weight: 700; 
            letter-spacing: 0.05em; 
            text-transform: uppercase; 
        }

        h1 { 
            margin: 16px 0 10px; 
            font-size: clamp(2rem, 4.5vw, 3.2rem); 
            font-weight: 800; 
            line-height: 1.1; 
            letter-spacing: -0.02em; 
        }

        .subtitulo { 
            max-width: 640px; 
            color: var(--suave); 
            font-size: 1.1rem; 
            line-height: 1.6; 
        }

        /* Layout em grade */
        .grade { 
            display: grid; 
            grid-template-columns: 1.5fr 0.9fr; 
            gap: 28px; 
            margin-top: 36px; 
        }

        .cartao { 
            padding: 32px; 
            background: var(--cartao); 
            border: 1px solid var(--borda); 
            border-radius: 16px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3); 
        }

        .cartao h2 { 
            margin: 0 0 24px; 
            font-size: 1.25rem; 
            font-weight: 700; 
            border-bottom: 1px solid var(--borda); 
            padding-bottom: 12px; 
        }

        .fluxo, .usuarios { 
            margin: 0; 
            padding: 0; 
            list-style: none; 
        }

        /* Indicadores numéricos do fluxo */
        .fluxo { counter-reset: etapa; }

        .fluxo li { 
            position: relative; 
            min-height: 60px; 
            padding: 4px 0 24px 54px; 
            color: var(--suave); 
            counter-increment: etapa; 
            font-size: 0.98rem; 
        }

        .fluxo li::before { 
            content: counter(etapa); 
            position: absolute; 
            top: 0; 
            left: 0; 
            display: grid; 
            width: 36px; 
            height: 36px; 
            place-items: center; 
            color: #022c22; 
            background: var(--destaque); 
            border-radius: 50%; 
            font-weight: 800; 
            font-size: 0.9rem; 
        }

        .fluxo li:not(:last-child)::after { 
            content: ""; 
            position: absolute; 
            top: 38px; 
            bottom: 6px; 
            left: 17px; 
            width: 2px; 
            background: var(--borda); 
        }

        .status { 
            color: #34d399; 
            font-weight: 600; 
            line-height: 1.5; 
            margin-bottom: 18px; 
        }

        /* Lista de usuários */
        .usuarios { display: grid; gap: 10px; }

        .usuarios li { 
            display: flex; 
            align-items: center; 
            gap: 14px; 
            padding: 12px 16px; 
            background: rgba(15, 23, 42, 0.6); 
            border: 1px solid var(--borda); 
            border-radius: 10px; 
            font-weight: 600; 
        }

        .avatar { 
            display: grid; 
            width: 34px; 
            height: 34px; 
            place-items: center; 
            color: var(--destaque); 
            background: var(--claro); 
            border: 1px solid rgba(16, 185, 129, 0.2); 
            border-radius: 8px; 
            font-size: 0.85rem; 
            font-weight: 700; 
        }

        /* Ajuste para dispositivos móveis */
        @media (max-width: 760px) { 
            .pagina { padding: 32px 0; } 
            .grade { grid-template-columns: 1fr; } 
            .cartao { padding: 24px; } 
        }
    </style>
</head>
<body>
    <main class="pagina">
        <span class="etiqueta">Arquitetura em Camadas</span>
        <h1>Como uma requisição percorre o sistema?</h1>
        <p class="subtitulo">Acompanhe a sequência executada até os dados dos usuários chegarem à interface.</p>

        <section class="grade" aria-label="Demonstração do fluxo da aplicação">
            <article class="cartao">
                <h2>Fluxo da requisição</h2>
                <ol class="fluxo">
                    <?php foreach ($resultado['etapas'] as $etapa): ?>
                        <li><?= escapar($etapa) ?></li>
                    <?php endforeach; ?>
                </ol>
            </article>

            <aside class="cartao">
                <h2>Resposta do Service</h2>
                <p class="status"><?= escapar($resultado['mensagem']) ?></p>
                <ul class="usuarios">
                    <?php foreach ($resultado['usuarios'] as $usuario): ?>
                        <li>
                            <span class="avatar" aria-hidden="true"><?= escapar(substr($usuario, 0, 1)) ?></span>
                            <?= escapar($usuario) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </section>
    </main>
</body>
</html>
