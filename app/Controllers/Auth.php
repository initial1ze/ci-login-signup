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
            return view('template/header', ['title' => 'Sign Up']) . view('auth/signup') . view('template/footer');

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

        $response = array('success' => false);

        $validationErrors = $this->validator->getErrors();
        $errors = array_values($validationErrors);

        if ($isValid) {

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

            $response['success'] = true;
        }

        $response['errors'] = $errors;

        exit(json_encode($response));
    }

    public function login()
    {
        if (session()->has('userID'))
            return redirect()->to(base_url('dashboard'));

        helper('form');

        if (!$this->request->is('post')) {

            $registrationSuccess = $this->request->getGet('registration');
            $logoutSuccess = $this->request->getGet('logout');

            $referer = $this->request->getHeaderLine('Referer');
            $data = [];
            if (!empty($referer)) {
                $data = [
                    'registrationSuccess' => $registrationSuccess,
                    'logoutSuccess' => $logoutSuccess
                ];
            } else {
                $data = [
                    'registrationSuccess' => false,
                    'logoutSuccess' => false
                ];
            }

            return  view('template/header', ['title' => 'Login']) .
                view('auth/login', $data) .
                view('template/footer');
        }

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

        $response = array('success' => false);

        $validationErrors = $this->validator->getErrors();
        $errors = array_values($validationErrors);

        if ($isValid) {
            $model = model('UsersModel');

            $post = $this->request->getPost(['email', 'password']);

            $email = $post['email'];
            $password = $post['password'];

            $user = $model->getUserByEmail($email);

            if (!password_verify($password, $user['password'])) {
                $errors[] = 'Wrong password!';
            } else {
                session()->set('userID', $user['id']);
                $response['success'] = true;
            }
        }

        $response['errors'] = $errors;

        exit(json_encode($response));
    }

    public function dashboard()
    {
        if (!session()->has('userID'))
            return redirect()->to(base_url('login'));

        $model = model('UsersModel');
        $userID = session()->get('userID');

        $data['user'] = $model->getUserByID($userID);

        return view('template/header', ['title' => 'Dashboard']) . view('auth/dashboard', $data) . view('template/footer');
    }

    public function logout()
    {
        if (!session()->has('userID'))
            return redirect()->to(base_url('login'));

        session()->destroy();
        return redirect()->to(base_url('login?logout=success'));
    }
}
