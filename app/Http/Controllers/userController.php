<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Error;
use Exception;


class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allUser = User::all();
        return $allUser;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $email  = $request->email;
            $name = $request->name;
            $phone = $request->phone;
            $birth_date = $request->birth_date;
            $city = $request->city;

            if (!$name) {
                throw new Exception('Precisa informar nome.');
            }
            if (!$email) {
                throw new Exception('Precisa informar um email.');
            }
            $existUser = User::whereEmail($request->email)->get();

            if (count($existUser) === 1) {
                throw new Exception('Ja existe usuario cadastrado com este email.');
            }

            if ($birth_date) {
                $validData = preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/', $birth_date);
                if (!$validData) {
                    throw new Exception("Formato de data invalido");
                }

                [$day, $month] = explode("/", $birth_date);
                if (($day <= 0 || $day >= 32) || ($month <= 0 || $month >= 13)) {
                    throw new Exception('Data invalida, verifique o dia ou mes informado!.');
                }
            }

            $user =  new User();
            $user->email = $email;
            $user->name =  $name;
            $user->phone = $phone;
            $user->birth_date = $birth_date;
            $user->city = $city;
            $user->save();
            return response()->json(['message' => "Usuario criado com sucesso"], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $fullId = intval($id);

            if ($fullId === 0  || !$id) {
                throw new Exception('Informar um id Valido.');
            }
            $findUser = User::find($fullId);
            if (!$findUser) {
                throw new Exception('Usuario não encontrado.');
            }
            return response()->json($findUser);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $fullId = intval($id);
            $email  = $request->email;
            $name = $request->name;
            $phone = $request->phone;
            $birth_date = $request->birth_date;
            $city = $request->city;

            if ($fullId === 0  || !$id) {
                throw new Exception('Informar um id Valido.');
            }

            if ($email) {
                $existEmail = User::whereEmail($email)->get();
                if (count($existEmail) === 1) {
                    throw new Exception('Email ja esta cadastrado.');
                }
            }


            if ($birth_date) {
                $validData = preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/', $birth_date);
                if (!$validData) {
                    throw new Exception("Formato de data invalido");
                }

                [$day, $month] = explode("/", $birth_date);
                if (($day <= 0 || $day >= 32) || ($month <= 0 || $month >= 13)) {
                    throw new Exception('Data invalida, verifique o dia ou mes informado!.');
                }
            }

            $findUser = User::find($fullId);
            if (!$findUser) {
                throw new Exception('Usuario não cadastrado');
            }
            $findUser->email =  $email ?: $findUser->email;
            $findUser->name =  $name ?: $findUser->name;
            $findUser->phone = $phone ?: $findUser->phone;
            $findUser->birth_date = str_replace('/', '-', $birth_date)  ?: $findUser->birth_date;
            $findUser->city = $city  ?: $findUser->birth_date;
            $findUser->save();
            return response()->json($findUser, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $fullId = intval($id);
            if ($fullId === 0  || !$id) {
                throw new Exception('Informar um id Valido.');
            }

            $findUser = User::find($fullId);
            if (!$findUser) {
                throw new Exception('Usuario não cadastrado');
            }
             User::destroy($fullId);

            return response()->json(['message' => 'Usuario deletado com sucesso'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
