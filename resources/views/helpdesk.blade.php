@extends('layouts.app')

@section('content')
    <h1 class="text-4xl text-center mb-4">
        Helpdesk
    </h1>

    <h2 class="text-2xl text-center mb-4">
        Create ticket
    </h2>

    <form method="POST" id="form" class="flex flex-col mt-16 mb-4 w-full max-w-125">
        <input type="hidden" id="item-id"/>
        <label for="question">
            Question:
        </label>
        <textarea name="question" id="question"
               class="border-2 mb-4 w-full rounded-lg p-2 disabled:bg-gray-200"
               tabindex="1"
               required
        ></textarea>

        <input type="submit" value="Save" id="submit"
               class="border-2 border-green-500 bg-green-500/5 hover:bg-green-500/20 text-green-500 rounded-lg p-2"
               tabindex="3"
        />
    </form>

    <p id="form-error"></p>

    <h2 class="text-2xl text-center mt-16 mb-4">
        View your questions and their answers
    </h2>

    <ul id="list" class="w-full"></ul>
@endsection

@section('scripts')
    @vite(['resources/js/pages/helpdesk-page.js'])
@endsection
