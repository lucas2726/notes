<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // check if user exists 
        $user = User::where('username', $username)
        ->where('deleted_at', NULL)
        ->first();
        
        if(!$user) {
            return redirect()
            ->back()
            ->withInput()
            ->with('loginError', 'Username ou password incorretos.');

            /*
            redirect()
            Esse método cria uma instância de redirecionamento. Ele permite que você redirecione o usuário para uma URL específica, rota nomeada ou a página anterior.

            2. back()
            Esse método indica que o redirecionamento deve ser feito para a página anterior, geralmente a mesma página onde o usuário estava antes da requisição. Ele utiliza o cabeçalho Referer da requisição para determinar de onde veio o usuário.

            3. withInput()
            Esse método mantém os dados enviados na requisição anterior, permitindo que sejam reutilizados na próxima requisição. Isso é muito útil para preencher automaticamente campos de formulários quando há um erro de validação.

            4. with()
            Esse método adiciona dados à sessão flash, permitindo que você envie mensagens ou informações para a próxima requisição. Normalmente, ele é usado para enviar mensagens de erro ou sucesso.
            */
        }

        if(!password_verify($password, $user->password)) {
            return redirect()
            ->back()
            ->withInput()
            ->with('loginError', 'Username ou password incorretos.');
        }

        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
            ]);

        /*
        sessão (session()) armazena informações temporárias entre requisições, como dados de usuário logado, mensagens flash, etc. 
        */

        //redirect to home
        return redirect()->to("/");
    }

    public function logout() {
        session()->forget('user');
        return redirect()->to('/login');
    }

}
