<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller {

    public function login() {
        return view('login');
    }

    public function loginSubmit(Request $request) {

        // form validation
        $request->validate(
            // regras 
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],
            // Mensagens de erro
            [
                'text_username.required' => 'O username é obrigatório',
                'text_username.email' => 'Username deve ser um email válido',
                'text_password.required' => 'A password é obrigátoria',
                'text_password.min' => 'A password deve ter pelo menos :min caracteres',
                'text_password.max' => 'A password deve ter no máximo :max caracteres'
            ]
        );

        // get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        echo "jhhhh";
    }

    public function logout() {
        echo "logout";
    }

}
