@extends('layouts.app')

@section('title', '')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accommodation Details</title>
<script>
    const apiKey = "{{ config('services.google_maps.api_key') }}";

    // Google Maps APIスクリプトを動的に生成
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap&libraries=places&loading=async`;
    script.async = true;
    script.defer = true;

    // スクリプトをHTMLに追加
    document.head.appendChild(script);


    // initMap 関数の定義（コールバック関数）
    function initMap() {
        console.log('Google Maps initialized!');
        // ここに地図の初期化コードを記述
    }
</script>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: { lat: {{ $accommodation->latitude }}, lng: {{ $accommodation->longitude }} },
        });

        var marker = new google.maps.Marker({
            position: { lat: {{ $accommodation->latitude }}, lng: {{ $accommodation->longitude }} },
            map: map,
        });
    }
</script>

@section('content')


<div onload="initMap()">
    <h1>Accommodation Details</h1>
    <p>Address: {{ $accommodation->address }}</p>
    {{-- <p>Latitude: {{ $accommodation->latitude }}</p>
    <p>Longitude: {{ $accommodation->longitude }}</p> --}}
        <div id="map" style="height: 300px; width: 50%; margin: auto"></div>
</div>


@endsection
