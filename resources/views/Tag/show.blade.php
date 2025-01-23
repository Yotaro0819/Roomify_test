@extends('layouts.app')

@section('title', $tag->name)

@section('content')
    <h1>Tag: {{ $tag->name }}</h1>

    {{-- 宿泊施設の一覧を表示 --}}
    <h3>Related Accommodations:</h3>
    @if($accommodations->count())
        <ul>
            @foreach($accommodations as $accommodation)
                <li>
                    <a href="{{ route('accommodation.show', $accommodation->id) }}">
                        {{ $accommodation->name }}
                    </a>
                    <p>{{ $accommodation->address }}</p>
                </li>
            @endforeach
        </ul>
    @else
        <p>No accommodations found for this tag.</p>
    @endif
@endsection
