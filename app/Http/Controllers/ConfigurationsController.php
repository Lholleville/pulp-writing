<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;

class ConfigurationsController extends Controller
{
    public function index(){
        $config = Configuration::all();
        return view('admin.config.index');
    }
}
