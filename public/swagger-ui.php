<!doctype html>
<html lang="pt-BR">
<head>
    <title>My CashFlow API - Documentação</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Documentação da API My CashFlow" />
</head>
<body>
<div id="app"></div>

<script src="https://cdn.jsdelivr.net/npm/@scalar/api-reference@latest"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Scalar.createApiReference('#app', {
            url: '<?= getBaseUrl() ?>/docs/json',
            proxyUrl: 'https://proxy.scalar.com',
            theme: 'kepler',
            layout: 'modern',
            showSidebar: true,
            hideDownloadButton: false,
            searchHotKey: 'k',
            metaData: {
                title: 'My CashFlow API',
                description: 'Documentação completa da API de gestão de fluxo de caixa'
            }
        });
    });
</script>
</body>
</html>