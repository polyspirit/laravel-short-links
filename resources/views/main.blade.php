<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/app.css" rel="stylesheet">
    <title>Laravel short links</title>
</head>

<body>
    <form class="link-form" method="POST" action="/i">
        @csrf

        <label for="uri">Input your uri-link here:</label>
        <input id="uri" type="text">
        <button class="submit">Get short-link</button>

        <div class="error"></div>
        <div class="link">Your short-link: <span class="link-text"></span></div>
    </form>
    <script src="/js/app.js" defer></script>
</body>

</html>
