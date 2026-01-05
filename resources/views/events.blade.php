@extends('layouts.app')

@section('content')
    <h1 class="text-4xl text-center mb-4">
        Events
    </h1>

    <h2 class="text-2xl text-center mb-4">
        Create / edit event
    </h2>

    <form method="POST" id="form" class="flex flex-col mt-16 mb-4 w-full max-w-125">
        <input type="hidden" id="item-id"/>
        <label for="name">
            Event name:
        </label>
        <input type="text" name="name" id="name"
               class="border-2 mb-4 w-full rounded-lg p-2 disabled:bg-gray-200"
               tabindex="1"
               required
        />
        <label for="description">
            Event description:
        </label>
        <textarea name="description" id="description"
                  class="border-2 mb-4 w-full rounded-lg p-2"
                  tabindex="2"
                  rows="4"
        ></textarea>

        <input type="submit" value="Save" id="submit"
               class="border-2 border-green-500 bg-green-500/5 hover:bg-green-500/20 text-green-500 rounded-lg p-2"
               tabindex="3"
        />
    </form>

    <h2 class="text-2xl text-center mt-16 mb-4">
        View your events
    </h2>

    <ul id="list" class="w-full"></ul>
@endsection

@section('scripts')
    @vite(['resources/js/pages/events-page.js'])
@endsection
