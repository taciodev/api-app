<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;

class ApiController extends Controller
{

    public function createTodo(Request $request) {
        $array = ['error' => ''];

        // Regras da validação.
        $rules = [
            'title' => 'required|min:3'
        ];

        // Validando
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->input('title');

        // Criando registro
        $todo = new Todo();
        $todo ->title = $title;
        $todo -> save();

        return $array;
    }

    public function readAllTodos() {
        $array = ['error' => ''];

        // Pegando todos os itens do banco
        $todo = Todo::all();
        $array['list'] = $todo;

        return $array;
    }

    public function readTodo($id) {
        $array = ['error' => ''];

        // Buscando Item pelo Id
        $todo = Todo::find($id);

        // Verificando se existe algum item na váriavel, caso não haja ele vai retornar um erro
        if ($todo) {
            $array['todo'] = $todo;
        } else {;
            $array['error'] = 'A tarefa '.$id.' não existe';
        }

        return $array;
    }

    public function updateTodo($id, Request $request) {
        $array = ['error' => ''];

        // Regras da validação.
        $rules = [
            'title' => 'min:3',
            'done' => 'boolean',
        ];

        // Validando
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->input('title');
        $done = $request->input('done');

        // Atualizando registro
        $todo = Todo::find($id);
        if ($todo) {
            if ($title) {
                $todo -> title = $title;
            }
            if ($done !== NULL) {
                $todo -> done = $done;
            }

            $todo -> save();
        } else {;
            $array['error'] = 'Tarefa '.$id.' não existe, logo, não pode ser atualizado.';
        }

        return $array;
    }

    public function deleteTodo($id) {
         $array = ['error' => ''];

        // Buscando e apagando item
        $todo = Todo::find($id);
        $todo -> delete();

        return $array;
    }

}
