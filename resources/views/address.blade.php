<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Google Map Example</title>
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
</head>
<body>
  <h2>Google Map Example</h2>
  <div id="map"></div>

  <script>
    function initMap() {
      const myLatLng = { lat: 22.2734719, lng: 70.7512559 };

      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 5,
        center: myLatLng,
      });

      new google.maps.Marker({
        position: myLatLng,
        map,
        title: "Hello Rajkot!",
      });
    }

    window.initMap = initMap;
  </script>

<script>
    const apiKey = "{{ config('services.google_maps.api_key') }}";

    // Google Maps APIスクリプトを動的に生成
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
    script.async = true;
    script.defer = true;

    // スクリプトをHTMLに追加
    document.head.appendChild(script);

    // スクリプト読み込み成功時の処理（オプション）
    script.onload = function () {
        console.log('Google Maps API loaded successfully.');
    };

    // スクリプト読み込み失敗時の処理
    script.onerror = function () {
        console.error('Failed to load Google Maps API.');
    };

    // initMap 関数の定義（コールバック関数）
    function initMap() {
        console.log('Google Maps initialized!');
        // ここに地図の初期化コードを記述
    }
</script>

</body>
</html>
