@extends('layouts.app')

@section('content')
    <h1 class="text-4xl text-center">Reset password</h1>

    <form id="form" method="POST" class="flex flex-col mt-16 w-full max-w-125">
        <label for="password">
            Password:
        </label>

        <input type="password" name="password" id="password"
               class="border-2 mb-4 w-full rounded-lg p-2"
               tabindex="1"
               required
        />

        <label for="password_confirmation">
            Password confirmation:
        </label>

        <input type="password" name="password_confirmation" id="password_confirmation"
               class="border-2 mb-4 w-full rounded-lg p-2"
               tabindex="2"
               required
        />

        <input type="submit" value="Reset password" id="submit"
               class="border-2 border-green-500 bg-green-500/5 hover:bg-green-500/20 text-green-500 rounded-lg p-2"
               tabindex="3"
        />

    </form>

    <p id="form-error"></p>
    <a id="redirect-link" href="/" class="underline text-blue-400">Return to login</a>

@endsection

@section('scripts')
    @vite(['resources/js/pages/reset-password-page.js'])
@endsection
