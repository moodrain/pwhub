<?php

namespace App\Http\Controllers;

use App\Models\Application;

class IndexController extends Controller
{
    public function index()
    {
        $apps = Application::query()->with(['accounts' => function($q) {
            $q->orderBy('username');
        }])->whereHas('accounts')->orderBy('name')->get();
        $apps->transform(function($app) {
            $app->accounts->transform(function($account) {
                $account->password = decrypt($account->password);
                return $account;
            });
            return $app;
        });
        return $this->view('index', ['apps' => $apps]);
    }
}