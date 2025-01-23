<form action="{{ route('accommodation.store') }}" method="POST">
    @csrf
    <label for="name">Accommodation Name:</label>
    <input type="text" id="name" name="name" required />

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required onfocus="initAutocomplete()" />

    <label for="city">City:</label>
    <input type="text" id="city" name="city" required />

    <p>
        If automatic recognition is not possible, please enter the address manually.</p>

    <label for="description">Description</label>
    <textarea name="description" id="description" col="30" rows="5"></textarea>

    <button type="submit">Register</button>
</form>
<p></p>
<script>
    let autocomplete;

    function initAutocomplete() {
        const input = document.getElementById('address');
        const options = {
            fields: ["address_components", "formatted_address"], // 必要なフィールドのみ
            types: ['geocode'],  // 住所に関連するタイプのみ
            language: 'en',  // 英語表記を優先
        };

        // Autocompleteのインスタンスを作成
        autocomplete = new google.maps.places.Autocomplete(input, options);

        // 住所が選択された後の処理
        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            const addressComponents = place.address_components;

            // 英語表記の住所を取得
            const formattedAddress = place.formatted_address;

            // フォームに英語表記の住所を設定
            document.getElementById('address').value = formattedAddress;

            // 市区町村と町名を設定
            let city = '';
            let street = '';
            addressComponents.forEach(component => {
                const types = component.types;

                if (types.includes('locality')) {
                    city = component.long_name; // 市区町村（町名を含む場合あり）
                } else if (types.includes('route')) {
                    street = component.long_name; // 通り名
                } else if (types.includes('street_number')) {
                    street += ' ' + component.long_name; // 番地を追加
                } else if (types.includes('neighborhood')) {
                    city = component.long_name; // 町名（場合によってはここに入ることも）
                }
            });

            // city と street を対応する入力フィールドに設定
            document.getElementById('city').value = city;
            document.getElementById('street').value = street;
        });
    }

</script>

<script>
    const apiKey = "{{ config('services.google_maps.api_key') }}";

    // Google Maps APIスクリプトを動的に作成して読み込む
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=places`;
    script.async = true;
    script.defer = true;

    // スクリプトをHTMLに追加
    document.head.appendChild(script);

    script.onload = function () {
        console.log('Google Maps API loaded successfully.');
        // 必要ならここでGoogle Maps API関連の初期化を呼び出す
        initAutocomplete();
    };

    script.onerror = function () {
        console.error('Failed to load Google Maps API.');
    };
</script>

