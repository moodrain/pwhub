<?php

namespace App\Http\Controllers;

use App\Models\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $model = '';

    public function __construct()
    {
        $this->initSearch();
        $this->initSort();
        singleUser() && Auth::loginUsingId(singleUser()->id);
    }

    private function initSearch() {
        $search = (array) request('search');
        foreach ($search as $key => $value) {
            if ($value === null || $value === '') {
                unset($search[$key]);
            }
        }
        $this->search = $search;
    }

    private function initSort() {
        $sort = (array) request('sort');
        foreach ($sort as $key => $value) {
            if ($value === null || $value === '') {
                unset($sort[$key]);
            }
        }
        $this->sort = $sort;
    }

    protected function mSearch($builder): Builder {
        return $builder->search($this->search)->sort();
    }

    protected function vld($rules) {
        return $this->validate(request(), $rules);
    }

    protected function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return call_user_func([$this->modelClass(), 'query']);
    }

    protected function model()
    {
        return $this->model;
    }

    protected function modelClass()
    {
        return 'App\\Models\\' . ucfirst($this->model());
    }

    protected function table()
    {
        $class = $this->modelClass();
        return (new $class)->getTable();
    }

    protected function view($view, $para = [])
    {
        $model = $this->model();
        $modelClass = $this->modelClass();
        $initPara = [
            'm' => $model,
            'modelClass' => $modelClass,
        ];
        empty($para['d']) && $initPara['d'] = null;
        empty($para['l']) && $initPara['l'] = [];
        return view($model . '.' . $view, array_merge($initPara, $para));
    }

    protected function viewOk($view, $para = [])
    {
        return $this->view($view, array_merge($para, [
            'msg' => __('msg.success'),
        ]));
    }

    protected function backOk()
    {
        return redirect()->back()->withInput()->with('msg', __('msg.success'));
    }

    protected function backErr($errMsg)
    {
        return redirect()->back()->withInput()->withErrors(__($errMsg));
    }

}
