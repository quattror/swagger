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
        configObject.plugins = [
            function () {
                return {
                    fn: {
                        opsFilter: function (taggedOps, phrase) {
                            var needle = String(phrase).toLowerCase();
                            return taggedOps.filter(function (tagObj, tag) {
                                return String(tag).toLowerCase().indexOf(needle) !== -1;
                            });
                        }
                    }
                };
            }
        ];

        var ui = SwaggerUIBundle(configObject);
        window.ui = ui;

        var filterPlaceholder = "Filtrar por tag";
        var applyFilterPlaceholder = function () {
            var filterInput = document.querySelector(".operation-filter-input");
            if (!filterInput) {
                return false;
            }
            filterInput.placeholder = filterPlaceholder;
            return true;
        };

        if (!applyFilterPlaceholder()) {
            var filterObserver = new MutationObserver(function () {
                if (applyFilterPlaceholder()) {
                    filterObserver.disconnect();
                }
            });
            var swaggerRoot = document.getElementById("swagger-ui");
            if (swaggerRoot) {
                filterObserver.observe(swaggerRoot, { childList: true, subtree: true });
            }
        }

        var applyTopbar = function () {
            var versionLabel = document.querySelector(".select-label > span");
            var topbarLink = document.querySelector(".topbar-wrapper > .link");
            if (!versionLabel || !topbarLink) {
                return false;
            }
            versionLabel.textContent = "Versão";
            topbarLink.innerHTML = '<img src="{{ $logo }}" alt=""><span><p style="font-size: 11px; color: #efefef; margin:0;">Documentação</p>{{ $title }}</span>';
            return true;
        };

        if (!applyTopbar()) {
            var topbarObserver = new MutationObserver(function () {
                if (applyTopbar()) {
                    topbarObserver.disconnect();
                }
            });
            var topbarRoot = document.getElementById("swagger-ui");
            if (topbarRoot) {
                topbarObserver.observe(topbarRoot, { childList: true, subtree: true });
            }
        }
    }
</script>
</body>
</html>
