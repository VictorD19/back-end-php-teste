<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use Exception;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $listCompanies = Company::all();
            foreach ($listCompanies as $key => $company) {
                $address = Company::find($company->id)->address;
                $company->street =  $address->street;
                $company->city =  $address->city;
                $company->state =  $address->state;;
            }
            return response()->json($listCompanies);
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
            $name = $request->name;
            $cnpj = $request->cnpj;
            $street = $request->street;
            $city = $request->city;
            $state = $request->state;

            if (!$name) {
                throw new Exception('Precisa informar um nome.');
            }

            // 00.000.000/0001-00 Valido
            $validCnpj = !$cnpj ?: preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/', $cnpj);

            if (!$validCnpj) {
                throw new Exception('Precisa informar um cnpj valido.');
            }
            if (!$street) {
                throw new Exception('Precisa informar uma rua. ');
            }
            if (!$city) {
                throw new Exception('Precisa informar uma cidade.');
            }
            if (!$state) {
                throw new Exception('Precisa informar um estado.');
            }

            $existCnpj = Company::where('cnpj', $cnpj)->first();

            if ($existCnpj) {
                throw new Exception('Empresa com cnpj ja cadastrada.');
            }

            $newCompany = new Company();
            $newCompany->name = $name;
            $newCompany->cnpj = $cnpj;
            $newCompany->save();

            $newAddress = new Address();
            $newAddress->company_id = $newCompany->id;
            $newAddress->street = $street;
            $newAddress->state = $state;
            $newAddress->city = $city;
            $newAddress->save();


            return response()->json(['message' => 'Empresa criada com sucesso.'], 201);
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
            $validId = intval($id);

            if ($validId === 0  || !$id) {
                throw new Exception('Informar um id Valido.');
            }
            $findCompany = Company::find($validId);
            if (!$findCompany) {
                throw new Exception('Empresa não encontrada.');
            }
            $address = Company::find($findCompany->id)->address;
            $findCompany->street =  $address->street;
            $findCompany->city =  $address->city;
            $findCompany->state =  $address->state;;
            return response()->json($findCompany);
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
            $validId = intval($id);
            $name  = $request->name;
            $cnpj = $request->cnpj;
            $street = $request->street;
            $city = $request->city;
            $state = $request->state;

            if ($validId === 0  || !$id) {
                throw new Exception('Informar um id Valido.');
            }

            $findCompany = Company::find($validId);
            if (!$findCompany) {
                throw new Exception('Empresa não encontrada.');
            }
            
            if ($cnpj) {
                $existCnpj = Company::where('cnpj', $cnpj)->first();
                if ($existCnpj) {
                    throw new Exception('Email ja esta cadastrado.');
                }
            }



            $findCompany->name =  $name ?: $findCompany->name;
            $findCompany->cnpj =  $cnpj ?: $findCompany->cnpj;


            $addressCompany = $findCompany->address;
            $addressCompany->street = $street ?: $addressCompany->street;
            $addressCompany->city = $city ?: $addressCompany->city;
            $addressCompany->state = $state ?: $addressCompany->state;
            
            $addressCompany->save();
            $findCompany->save();
            unset( $findCompany->address->id);
            unset( $findCompany->address->company_id);
            unset( $findCompany->address->created_at);
            unset( $findCompany->address->updated_at);
        
            return response()->json($findCompany, 200);
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
            $validId = intval($id);

            if ($validId === 0  || !$id) {
                throw new Exception('Informar um id Valido.');
            }
            $findCompany = Company::find($validId);
            if (!$findCompany) {
                throw new Exception('Empresa não encontrada.');
            }
            $findCompany->destroy($validId);
            return response()->json([], 204);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
