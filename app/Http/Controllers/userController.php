<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_Company;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *  
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $User = new User();
            $allUser = $User->all();
            foreach ($allUser as $key => $user) {
                $user->companys;

                foreach ($user->companys as $key => $company) {
                    $findCompany = Company::find($company->id);
                    $findCompany->address;
                    $company->address = $findCompany->address;;
                    # code...
                }
            }
            return response($allUser->toJson());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
            $companies = $request->companies;


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
            if (!is_array($companies)) {
                throw new Exception('Precisa informar empresas');
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
            $user->birth_date = str_replace('/', '-', $birth_date);
            $user->city = $city;

            if (count($companies) >= 1) {
                $listCompanies = array();

                foreach ($companies as $company => $value) {
                    $company_id = $value['company_id'];
                    $listCompanies[$company] = $company_id;
                }

                $existCompanies = DB::table('company')->whereIn('id', $listCompanies)->get();

                if (count($existCompanies) === 0 || count($existCompanies) !== count($listCompanies)) {
                    throw new Exception('Todas as empresas informadas precisan existir');
                }
                $user->save();

                foreach ($listCompanies as $index => $value) {
                    $newRelationUserCompany = new User_Company();
                    $newRelationUserCompany->user_id = $user->id;
                    $newRelationUserCompany->company_id = $value;
                    $newRelationUserCompany->save();
                }
            
            } else {
                $user->save();
            }
            $user->companys;


            return response()->json($user, 201);
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
                throw new Exception('Usuario n??o encontrado.');
            }
            $findUser->companys; 
            foreach ($findUser->companys as $key => $company) {
                $company = Company::find($company->id);
                
                $findUser->companys[$key]->address = $company->address;
                # code...
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
            $companies = $request->companies;

            if ($fullId === 0  || !$id) {
                throw new Exception('Informar um id Valido.');
            }
            
            if ($email ) {
                $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                $validEmail =  preg_match($regex, $email);
                if(!$validEmail){
                    throw new Exception('Formato de email invalido.');

                }
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
            if (!is_array($companies)) {
                throw new Exception("Precisa mandar um array no companies.");
            }

            $findUser = User::find($fullId);
            if (!$findUser) {
                throw new Exception('Usuario n??o cadastrado');
            }

            if ($companies) {
                $existCompanies = array();
                foreach ($companies as $key => $company) {
                    $findCompany = Company::find($company['company_id']);
                    if ($findCompany) {
                        array_push($existCompanies, $findCompany);
                    }
                }
                if (!(count($existCompanies) === count($companies))) {
                    throw new Exception('Todas as empresas informadas precisam existir');
                }
                foreach ($existCompanies as $key => $company) {
                    $newRelationUserCompany = new User_Company();
                    $existRelation =  $newRelationUserCompany::whereCompany_id($company->id);
                    if(!$existRelation){
                        $newRelationUserCompany->user_id = $findUser->id;
                        $newRelationUserCompany->company_id =$company->id;
                        $newRelationUserCompany->save();
                    }
                   
                }
            }
            $findUser->companys;
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
                throw new Exception('Usuario n??o cadastrado');
            }
            User::destroy($fullId);

            return response()->json(['message' => 'Usuario deletado com sucesso'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
