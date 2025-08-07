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

<!-- Loading indicator -->
<div id="loading" style="text-align: center; margin-top: 50px; font-family: Arial, sans-serif;">
    <p>Carregando documentação da API...</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/@scalar/api-reference@latest"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loading = document.getElementById('loading');

        Scalar.createApiReference('#app', {
            url: '<?= getBaseUrl() ?>/docs/json',
            proxyUrl: 'https://proxy.scalar.com',
            theme: 'default',
            layout: 'modern',
            showSidebar: true,
            hideDownloadButton: false,
            searchHotKey: 'k',
            metaData: {
                title: 'My CashFlow API',
                description: 'Documentação completa da API de gestão de fluxo de caixa'
            }
        }).then(() => {
            if (loading) loading.remove();
        }).catch((error) => {
            console.error('Erro ao carregar documentação:', error);
            loading.innerHTML = '<p style="color: red;">Erro ao carregar a documentação. Tente recarregar a página.</p>';
        });
    });
</script>
</body>
</html>