<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Tag;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // リクエストから宿泊施設名と住所を取得
        $name = $validated['name'];
        $address = $validated['address'];
        $city = $validated['city'];
        $description = $validated['description'] ?? null;


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
                    'city' => $city,
                    'description' => $description,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]);

                if(!empty($validated['description'])) {
                    preg_match_all('/#(\w+)/', $validated['description'], $matches);
                    $tags = $matches[1];

                    $tagIds = [];
                    foreach($tags as $tagName) {
                        $tag = Tag::firstOrCreate(['name' => $tagName]);
                        $tagIds[] = $tag->id;
                    }

                    $accommodation->tags()->attach($tagIds);
                }

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
