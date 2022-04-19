<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
        <title>Laravel short links</title>
    </head>
<body>
    <div id="app" class="main-wrapper container d-flex flex-column justify-content-center align-items-center">
