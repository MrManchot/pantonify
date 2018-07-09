<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Pantonify</title>
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href="dist/css/pantonify.min.css" />
</head>

<body>
    <form action="ajax.php" class="dropzone" id="pantonify-dropzone"></form>
    <div id="pantonify-container" class="container"></div>
    <script src="dist/js/pantonify.min.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122025561-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-122025561-1');
    </script>

</body>

</html>