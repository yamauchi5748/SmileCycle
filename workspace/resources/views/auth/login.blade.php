<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <!-- CSRF Token -->
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>{{ config('app.name', 'SmileCycle') }}</title>
    <!-- Styles -->
    <link
        href="{{ asset('css/app.css') }}"
        rel="stylesheet"
    >
</head>

<body>
    <main class="login-container-wrapper">
        <h1 class="login-title">SmileCycle</h1>
        <form class="login-container" method="post" action="{{ route('login') }}" name="Login">
            @csrf
            <div class="login-content-wrapper">
                @if($errors->has('name'))
                    <input class="login-content error" type="text" name="name" placeholder="ユーザ名">
                @else
                    <input class="login-content" type="text" name="name" placeholder="ユーザ名">
                @endif 
                @error('name')
                    <div class="alert">{{ $message }}</div>
                @enderror
            </div>
            <div class="login-content-wrapper">
                @if($errors->has('password'))
                    <input class="login-content error" type="password" name="password" placeholder="パスワード">
                @else
                    <input class="login-content" type="password" name="password" placeholder="パスワード">
                @endif 
                @error('password')
                    <div class="alert">{{ $message }}</div>
                @enderror
            </div>
            <button class="login-btn" type="submit">ログイン</button>
        </form>
    </main>
</body>

<style> 
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset;
}
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f4f4f4;
}

.login-container-wrapper {
    width: 100%;
    max-width: 600px;
    padding: 4%;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 1px 2px 3px #aaaaaa;
    background-color: #ffffff;
}

.login-container {
    width: 100%;
    max-width: 600px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.login-title {
    margin-bottom: 15%;
    color: #ff9900;
    font-size: 3rem;
    font-weight: 700;
    letter-spacing: .2rem;
}

.login-content-wrapper {
    width: 60%;
    margin-bottom: 15%;
}

.login-content {
    width: 100%;
    margin-bottom: 15px;
    padding: 10px 0;
    border: none;
    border-bottom: solid 2px gray;
    font-size: 18px;
}

.login-content:focus {
  outline: 0;
  background: none;
}

.login-btn {
    width: 60%;
    height: 36px;
    min-width: 80px;
    padding: 0 12px;
    font-size: 15px;
    font-weight: 700;
    border-radius: 4px;
    justify-content: center;
    align-items: center;
    color: #ffffff;
    background-color: #009680;
    box-shadow: 0 5px 5px rgba(0, 0, 0, 0.24);
    flex-shrink: 0;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    transition: all 80ms linear;
    text-decoration: none;
    cursor: pointer;
}

.alert {
    color: #b92d00;
}

.error {
    border-bottom: solid 2px #b92d00;
}

</style>

</html>