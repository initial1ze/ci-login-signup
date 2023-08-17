<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function signup()
    {
        if (session()->has('userID'))
            return redirect()->to(base_url('dashboard'));

        helper('form');

        if (!$this->request->is('post'))
            return view('auth/signup');

        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required!',
                    'valid_email' => 'Email is not valid!',
                    'is_unique' => 'Email already exists!'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required!',
                    'min_length' => 'Password must be at least 8 characters!'
                ]
            ],
            'cnfPassword' => [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Password does not match!'
                ]
            ],
        ];

        $isValid = $this->validate($rules);

        if (!$isValid) {
            return redirect()->to(base_url('signup'))->withInput();
        } else {
            $model = model('UsersModel');

            $post = $this->request->getPost(['email', 'password']);

            $email = $post['email'];
            $password = $post['password'];
            $hasedPassword = password_hash($password, PASSWORD_DEFAULT);

            $data = [
                'email' => $email,
                'password' => $hasedPassword
            ];

            $model->save($data);
            session()->setFlashdata('success', 'User created successfully!');
            return redirect()->to(base_url('login'));
        }
    }

    public function login()
    {
        if (session()->has('userID'))
            return redirect()->to(base_url('dashboard'));

        helper('form');

        if (!$this->request->is('post'))
            return view('auth/login');

        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required!',
                    'valid_email' => 'Email is not valid!',
                    'is_not_unique' => 'Email does not exist!',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'Password is required!',
                    'min_length' => 'Password must be at least 8 characters!'
                ]
            ]
        ];

        $isValid = $this->validate($rules);

        if (!$isValid) {
            return redirect()->to(base_url('login'))->withInput();
        } else {
            $model = model('UsersModel');

            $post = $this->request->getPost(['email', 'password']);

            $email = $post['email'];
            $password = $post['password'];

            $user = $model->getUserByEmail($email);

            if (!password_verify($password, $user['password'])) {
                session()->setFlashdata('failure', 'Wrong password!');
                return redirect()->to(base_url('login'));
            }

            session()->set('userID', $user['id']);
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function logout()
    {
        if (!session()->has('userID'))
            return redirect()->to(base_url('login'));

        session()->remove('userID');
        session()->setFlashdata('success', 'Logout successfully!');
        return redirect()->to(base_url('login'));
    }
}
