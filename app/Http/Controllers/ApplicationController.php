<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Validation\Rule;

class ApplicationController extends Controller
{

    protected $model = 'application';

    public function list()
    {
        $builder = $this->mSearch($this->builder());
        return $this->view('list', ['l' => $builder->paginate()]);
    }

    public function edit()
    {
        if (request()->isMethod('post')) {
            return request('id') ? $this->update() : $this->store();
        }
        return $this->view('edit', [
            'd' => request('id') ? $this->builder()->find(request('id')) : null,
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|unique:' . $this->table(),
            'site' => '',
        ];
        $this->vld($rules);
        $item = $this->builder()->newModelInstance(request()->only(array_keys($rules)));
        $item->save();
        return $this->viewOk('edit');
    }

    public function update()
    {
        $rules = [
            'id' => 'required|exists:' . $this->table(),
            'name' => ['required', Rule::unique($this->table())->ignore(request('id'))],
            'site' => '',
        ];
        $this->vld($rules);
        $item = $this->builder()->find(request('id'));
        $this->authorize('update', $item);
        $item->fill(request()->only(array_keys($rules)));
        $item->save();
        return $this->viewOk('edit', ['d' => $item]);
    }

    public function destroy()
    {
        $rules = [
            'id' => 'required_without:ids|exists:' . $this->table(),
            'ids' => 'required_without:id|array',
            'ids.*' => 'exists:' . $this->table() . ',id',
        ];
        $this->vld($rules);
        $ids = request('ids') ?? [];
        request('id') && $ids[] = request('id');
        $apps = $this->builder()->whereIn('id', $ids)->with(['accounts' => function($q) {
            $q->withoutGlobalScope('my');
        }])->get();
        foreach ($apps as $app) {
            $this->authorize('delete', $app);
            if ($app->accounts->isNotEmpty()) {
                return $this->backErr('there are accounts in the app' . (count($ids) > 1 ? 's' : '') . ', delete accounts before delete app (if these accounts are all yours)');
            }
            $app->delete();
        }
        return $this->backOk();
    }

}
