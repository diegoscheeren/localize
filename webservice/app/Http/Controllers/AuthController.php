<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\User;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cadastrar(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'validacao' => true, 'erros' => $validator->errors()];
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->token = $user->createToken($user->email)->accessToken;

        return ['status' => true, 'usuario' => $user];
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return ['status' => false, 'validacao' => true, 'erros' => $validator->errors()];
        }

        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->accessToken;
            $user->imagem = asset($user->imagem);
            return ['status' => true, 'usuario' => $user];
        } else {
            return ['status' => false];
        }
    }

    public function perfil(Request $request)
    {
        $user = $request->user();
        $data = $request->all();

        if (isset($data['password'])) {
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if ($validator->fails()) {
                return ['status' => false, 'validacao' => true, 'erros' => $validator->errors()];
            }

            $user->password = bcrypt($data['password']);
        } else {
            $user->name = $data['name'];
            $user->email = $data['email'];
        }

        if (isset($data['imagem'])) {
            Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
                $explode = explode(',', $value);
                $allow = ['png', 'jpg', 'svg', 'jpeg'];
                $format = str_replace(['data:image/', ';', 'base64'], ['', '', ''], $explode[0]);

                if (!in_array($format, $allow)) {
                    return false;
                }

                if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                    return false;
                }

                return true;
            });

            $validator = Validator::make($data, ['imagem' => 'base64image'], ['base64image' => 'Imagem inválida']);


            if ($validator->fails()) {
                return ['status' => false, 'validacao' => true, 'erros' => $validator->errors()];
            }

            $time = time();
            $dir = 'perfis';
            $dirImg = $dir . DIRECTORY_SEPARATOR . 'perfil_id' . $user->id;
            $ext = substr($data['imagem'], 11, strpos($data['imagem'], ';') -11);
            $urlImagem = $dirImg . DIRECTORY_SEPARATOR . $time . '.' . $ext;

            $file = str_replace('data:image/' . $ext . ';base64,', '', $data['imagem']);
            $file = base64_decode($file);

            if (!file_exists($dir)) {
                mkdir($dir, 0700);
            }

            if ($user->imagem && file_exists($user->imagem)) {
                unlink($user->imagem);
            }

            if (!file_exists($dirImg)) {
                mkdir($dirImg, 0700);
            }

            file_put_contents($urlImagem, $file);

            $user->imagem = $urlImagem;
        }

        $user->save();

        $user->imagem = asset($user->imagem);
        $user->token = $user->createToken($user->email)->accessToken;
        return ['status' => true, 'usuario' => $user];
    }
}
