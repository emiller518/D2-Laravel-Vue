<?php

namespace App\Http\Controllers\Sandbox;

use App\Crud;
use App\Http\Controllers\Controller;
use Faker\Generator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function response;

class CrudsController extends Controller
{
    public function create(Generator $faker)
    {
        $crud = new Crud();
        $crud->name = $faker->lexify('????????');
        $crud->color = $faker->boolean ? 'red' : 'green';
        $crud->save();

        return response($crud->jsonSerialize(), Response::HTTP_CREATED);
    }


    public function index()
    {
        return response(Crud::all()->jsonSerialize(), Response::HTTP_OK);
    }


    public function update(Request $request, $id)
    {
        $crud = Crud::findOrFail($id);
        $crud->color = $request->color;
        $crud->save();

        return response(null, Response::HTTP_OK);
    }


    public function destroy($id)
    {
        Crud::destroy($id);

        return response(null, Response::HTTP_OK);
    }



}
