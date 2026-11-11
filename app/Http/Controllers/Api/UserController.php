<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserResourceCollection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
         try {
            return new UserResource(User::create($request->validated()))
                ->additional(["message"=>"Usuário cadastrado!!"])
                ->response()->setStatusCode(201);
        } catch (\Exception $error) {
            return $this->errorHandler("Erro ao cadastrar o usuário!!!", $error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        // $permitido = $request->user()->id === $user->id;
        // $status = !$permitido?403:200;
        // return response()->json([
        //     "message"=> $permitido
        //                 ?"Pode alterar!"
        //                 :"Não deveria altetar!!"
        // ],$status);
        Gate::authorize('update-user',$user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Gate::authorize('delete-user',$user);
        Gate::authorize('superuser');
        return ["message"=>"Pode remover o usuário $user->id!"];
    }
}
