<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AccommodationController extends Controller
{
    public function create()
    {
        return view('accommodation.create');
    }

    public function store(Request $request)
    {
        // リクエストから宿泊施設名と住所を取得
        $name = $request->input('name');
        $address = $request->input('address');
        $prefecture = $request->input('prefecture');
        $city = $request->input('city');
        $street = $request->input('street');
        $apiKey = "AIzaSyC5WwFaRtTQUz9vdq9DLMbrYcSUWx7rjSs";

        try {
            // Google Geocoding APIを使用して緯度と経度、住所コンポーネントを取得
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $address,
                'key' => $apiKey
            ]);

            $data = $response->json();

            if ($data['status'] == 'OK') {
                // 緯度・経度を取得
                $latitude = $data['results'][0]['geometry']['location']['lat'];
                $longitude = $data['results'][0]['geometry']['location']['lng'];

                // 住所コンポーネントを取得
                // $components = $data['results'][0]['address_components'];


                // データベースに保存
                $accommodation = Accommodation::create([
                    'name' => $name,
                    'address' => $address,
                    'prefecture' => $prefecture,
                    'city' => $city,
                    'street' => $street,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]);

                return redirect()->route('accommodation.show', $accommodation->id)
                    ->with('success', '宿泊施設が登録されました');
            } else {
                return response()->json(['error' => '住所のジオコーディングに失敗しました。', 'details' => $data], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'エラーが発生しました。', 'message' => $e->getMessage()], 500);
        }
    }




    public function show($id)
{
    $accommodation = Accommodation::findOrFail($id);
    return view('accommodation.show', compact('accommodation'));
}

}
