<form class="link-form" method="POST" action="/i">
    @csrf

    <label for="url">Input your uri-link here:</label>
    <input id="url" name="url" placeholder="http://example.com" type="text">
    <button class="submit">Get short-link</button>

    <div class="error">
        <div class="error-text"></div>
        <div class="error-description"></div>
    </div>
    <div class="link">Your short-link: <a href="" class="link-text" target="_blank"></a></div>
</form>
