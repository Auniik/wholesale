<?php

namespace App\Http\Controllers;

use App\Models\SystemConfig;
use App\Repositories\SystemConfigRepository;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{
    private $config;
    public function __construct(SystemConfigRepository $config)
    {
        $this->config = $config;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('configs.index', [
            'config' => $this->config->first()
        ]);
    }


    public function store(Request $request)
    {
        $data = [
            'outdoor_discount' => $request->outdoor_discount ? 1 : 0,
            'outdoor_sms' => $request->outdoor_sms? 1 : 0,
        ];
        $this->config->createOrUpdate($data);
        return back()->withSuccess('Configs Updated Successfully');
    }
}
