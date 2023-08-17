<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->has('userID'))
            return redirect()->to(base_url('login'));
        $model = new UsersModel();
        $data['user'] = $model->getUserByID(session()->get('userID'));
        return view('dashboard/index', $data);
    }
}
