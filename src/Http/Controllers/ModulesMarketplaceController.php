<?php

namespace Dorcas\ModulesMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dorcas\ModulesMarketplace\Models\ModulesMarketplace;
use App\Dorcas\Hub\Utilities\UiResponse\UiResponse;
use App\Http\Controllers\HomeController;
use Hostville\Dorcas\Sdk;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ModulesMarketplaceController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data = [
            'page' => ['title' => config('modules-marketplace.title')],
            'header' => ['title' => config('modules-marketplace.title')],
            'selectedMenu' => 'sales'
        ];
    }

    public function index()
    {
    	$this->data['availableModules'] = HomeController::SETUP_UI_COMPONENTS;
    	return view('modules-marketplace::index', $this->data);
    }


}