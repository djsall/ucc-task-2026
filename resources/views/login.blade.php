@extends('layouts.app')

@section('content')
    <h1 class="text-4xl text-center">Login</h1>

    <form id="form" class="flex flex-col mt-16 w-full max-w-125">

        <label for="email">
            Email:
        </label>

        <input type="email" name="email" id="email"
               class="border-2 mb-4 w-full rounded-lg p-2"
               tabindex="1"
               required
        />

        <label for="password">
            Password:
        </label>

        <input type="password" name="password" id="password"
               class="border-2 mb-4 w-full rounded-lg p-2"
               tabindex="2"
               required
        />

        <input type="submit" value="Login" id="submit"
               class="border-2 border-green-500 bg-green-500/5 hover:bg-green-500/20 text-green-500 rounded-lg p-2"
               tabindex="3"
        />

    </form>

    <p id="form-error"></p>

    <a href="/forgot-password" class="mt-4 underline text-blue-400">I forgot my password.</a>
@endsection

@section('scripts')
    @vite(['resources/js/pages/auth-page.js'])
@endsection
