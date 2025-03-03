@extends('layouts.main_layout')

{{-- Essa diretiva informa que esta view está herdando o layout definido em layouts.main_layout. Isso significa que toda a estrutura desse layout será carregada antes do conteúdo específico desta página. --}}

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8">
                <div class="card p-5">
                    
                    <!-- logo -->
                    <div class="text-center p-3">
                        <img src="assets/images/logo.png" alt="Notes logo">
                    </div>

                    <!-- form -->
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-12">
                            <form action="/loginSubmit" method="post" novalidate>

                                @csrf
                                {{-- @csrf no Laravel é uma diretiva do Blade usada para incluir um token CSRF (Cross-Site Request Forgery) dentro de um formulário HTML. Esse token ajuda a proteger a aplicação contra ataques CSRF, garantindo que os pedidos ao servidor sejam feitos apenas de fontes legítimas. Quando um formulário envia dados para uma rota POST, PUT, PATCH ou DELETE, o framework exige um token CSRF para validar a requisição. O Blade facilita isso com a diretiva @csrf. Quando o formulário é enviado, o Laravel compara o token enviado com o token armazenado na sessão do usuário. Se eles não coincidirem, a requisição é rejeitada como não autorizada. --}}

                                <div class="mb-3">
                                    <label for="text_username" class="form-label">Username</label>
                                    <input type="email" class="form-control bg-dark text-info" name="text_username" value="{{ old('text_username') }}" required>

                                    {{-- old(''): Recupera o valor que o usuário digitou no campo do formulario na requisição anterior.
                                    Se o formulário for enviado e houver erros de validação, o Laravel redireciona de volta e mantém o valor preenchido.
                                    Isso evita que o usuário tenha que digitar tudo novamente caso ocorra um erro. --}}

                                    {{-- show error (Para mostrar um erro de cada vez) --}}
                                    @error('text_username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="text_password" class="form-label">Password</label>
                                    <input type="password" class="form-control bg-dark text-info" name="text_password" value="{{ old('text_password') }}" required>
                                    {{-- show error (Para mostrar um erro de cada vez) --}}
                                    @error('text_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-secondary w-100">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- copy -->
                    <div class="text-center text-secondary mt-3">
                        <small>&copy; <?= date('Y') ?> Notes</small>
                    </div>

                    {{-- errors (Para mostrar tds os erros ) --}}
                    {{-- @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif --}}
                
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @section('content') define um bloco de conteúdo que será inserido dentro do @yield('content') do layout main_layout. --}}