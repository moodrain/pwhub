<?php

namespace App\Http\Controllers;

class AccountController extends Controller
{

    protected $model = 'account';

    public function list()
    {
        $builder = $this->mSearch($this->builder());
        $l = $builder->paginate();
        $l->getCollection()->transform(function($a) {
            $a->password = decrypt($a->password);
            return $a;
        });
        return $this->view('list', ['l' => $l]);
    }

    public function edit()
    {
        if (request()->isMethod('post')) {
            return request('id') ? $this->update() : $this->store();
        }
        if(! request('id')) {
            return $this->view('edit');
        }
        $d = $this->builder()->find(request('id'));
        $d->password = decrypt($d->password);
        return $this->view('edit', ['d' => $d]);
    }

    public function store()
    {
        $rules = [
            'applicationId' => 'required|exists:applications,id',
            'username' => 'required',
            'password' => 'required',
            'note' => '',
        ];
        $this->vld($rules);
        $exists = $this->builder()->where([
            'user_id' => uid(),
            'application_id' => request('applicationId'),
            'username' => request('username'),
        ])->exists();
        if ($exists) {
           return $this->backErr('account already exists');
        }
        $item = $this->builder()->newModelInstance(request()->only(array_keys($rules)));
        $item->userId = uid();
        $item->password = encrypt($item->password);
        $item->save();
        return $this->viewOk('edit');
    }

    public function update()
    {
        $rules = [
            'id' => 'required|exists:' . $this->table(),
            'applicationId' => 'required|exists:applications,id',
            'username' => 'required',
            'password' => 'required',
            'note' => '',
        ];
        $this->vld($rules);
        $item = $this->builder()->find(request('id'));
        $item->fill(request()->only(array_keys($rules)));
        $item->password = encrypt($item->password);
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
        $this->builder()->whereIn('id', $ids)->delete();
        return $this->backOk();
    }

}
