<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CsvDownloadService;
use Illuminate\Support\Facades\Response;

class CsvDownloadController extends Controller
{
    /**
     * CSV画面一覧
     *
     * @return void
     */
    public function index()
    {
        return view('csv_download');
    }

    /**
     * 人気イベント一覧ダウンロード
     *
     * @return void
     */
    public function downloadPopularEvent()
    {
        $download = new CsvDownloadService();
        $csvData = $download->getPopularEvent();

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }

    /**
     * PHPイベント一覧ダウンロード
     *
     * @return void
     */
    public function downloadPhpEvent()
    {
        $download = new CsvDownloadService();
        $csvData = $download->getPhpEvent();

        return Response::make($csvData['csv'], 200, $csvData['headers']);
    }
}
