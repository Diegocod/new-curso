<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::get();

        return view('admin.posts.index', [ /* ou usar a função com: compact('posts'); */
            'posts' => $posts
        ]);

    }

    public function create()
    {
        
        return view('admin.posts.create');
    }

    public function store(StoreUpdatePost $request)//faz injeção de depêndencia para dps acessar os dados do post
    {//$request é um objeto de Request; mesma coisa que $request = new Request;
        

        //Acessa o model Post logo abaixo:
        Post::create($request->all()); /*Como o name dos inputs e textarea já corresponde ao nome das colunas da 
        tabela, é possível passar com o $request->all(), mas se não fosse o caso teria que passa em forma de
        array, específicando o valor para cada coluna, exemplo: 
        Post::create(['title' => $request->title]);*/

        return redirect()->route('posts.index');  

    }
}
