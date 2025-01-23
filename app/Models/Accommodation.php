<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    // テーブル名の設定（省略可能：テーブル名が単数形であればLaravelが自動で判断）
    protected $table = 'accommodations';

    // データベースに挿入可能なカラム
    protected $fillable = [
        'name',
        'address',
        'prefecture',
        'city',
        'street',
        'latitude',
        'longitude',
    ];

    // タイムスタンプ（created_at と updated_at）の自動管理を有効にする場合は true（デフォルトで有効）
    public $timestamps = true;

    // 日付のフォーマット（オプション）
    protected $dates = ['created_at', 'updated_at'];

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
