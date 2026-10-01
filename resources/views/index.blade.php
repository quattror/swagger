<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Open+Sans:400,700|Source+Code+Pro:300,600|Titillium+Web:400,600,700|Roboto:400,500,700"
        rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ $favicon }}"/>
    <link rel="stylesheet" type="text/css" href="{{ $assetsDir . 'swagger-ui.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ $assetsDir . 'swagger-ui-custom.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ $assetsDir . 'swagger-ui-custom-' . $env . '.css' }}">
    <style>
        html {
            box-sizing: border-box;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fff;
        }
    </style>
</head>

<body>
<div id="swagger-ui"></div>
<script src="{{ $assetsDir . 'swagger-ui-bundle.js' }}"></script>
<script src="{{ $assetsDir . 'swagger-ui-standalone-preset.js' }}"></script>
<script>
    window.onload = function () {
        var configObject = {!! json_encode([
            'urls' => [['url' => $urlToDocs, 'name' => 'v1']],
            'deepLinking' => true,
            'displayOperationId' => false,
            'defaultModelsExpandDepth' => -1,
            'defaultModelExpandDepth' => 1,
            'defaultModelRendering' => 'example',
            'displayRequestDuration' => false,
            'docExpansion' => 'none',
            'filter' => true,
            'persistAuthorization' => true,
            'showExtensions' => false,
            'showCommonExtensions' => false,
            'supportedSubmitMethods' => ['get', 'put', 'post', 'delete', 'options', 'head', 'patch', 'trace'],
            'validatorUrl' => null,
        ]) !!};

        configObject.dom_id = "#swagger-ui";
        configObject.presets = [SwaggerUIBundle.presets.apis, SwaggerUIStandalonePreset];
        configObject.layout = "StandaloneLayout";

        var ui = SwaggerUIBundle(configObject);
        window.ui = ui;

        var versionLabel = document.querySelector(".select-label > span");
        if (versionLabel) {
            versionLabel.textContent = "Versão";
        }

        var topbarLink = document.querySelector(".topbar-wrapper > .link");
        if (topbarLink) {
            topbarLink.innerHTML = '<img src="{{ $logo }}" alt=""><span><p style="font-size: 11px; color: #efefef; margin:0;">Documentação</p>{{ $title }}</span>';
        }
    }
</script>
</body>
</html>
