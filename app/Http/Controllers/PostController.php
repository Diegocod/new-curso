<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePost;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate();
        //latest ex: Post::latest()->paginate();
        //paginate(<numero de elementos por pag>); o valor default é 15
        //orderBy(<nome da coluna>); por padrão ordena asc (do menor para o maior)

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

        return redirect()
            ->route('posts.index')
            ->with('message', 'Post criado com sucesso');

    }

    public function show($id)//só colocar  $id, que vai receber o $id da rota
    {
        //$post = Post::where('id', $id)->first();
        /*o método get() retorna uma collection (um array)
        no nosso caso queremos só um registro então usamos o método firt();
        /*where pega todos posts onde o valor da coluna 'id' é igual
        da variavel $id*/

        //outra maneira: 
        $post = Post::find($id);// por default já recupera o registro pelo id
       
        //fazendo verificação se o valor existe, se não existir da um redirect
        if (!$post) {/*se retornar false ele entra na condição 
        porque !false vira true. */
            return redirect()->route('posts.index');
    
        }
        
        return view('admin.posts.show', compact('post'));/*retorna para uma view 
        com msm nome do método do PostController*/
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post)
            return redirect()->route('posts.index');
    
       $post->delete();
       
       return redirect()
            ->route('posts.index')
            ->with('message', 'Post deletado com sucesso');

    }

    public function edit($id)
    {    
        $post = Post::find($id);

        if (!$post) {
            return redirect()->back();//back() volta de onde veio
        }
        
        return view('admin.posts.edit', compact('post'));
    }

    public function update(StoreUpdatePost $request, $id)
    {    //primeiro faz a injeção de dependencia, dps passa os parametros como ex: $id
        $post = Post::find($id);
        
        if (!$post) {
            return redirect()->back();//back() volta de onde veio
        }
        
        $post->update($request->all());/*todos os dados já vem validados por causa 
         do StoreUpdatePost que foi configurado para que somente determinadas colunas
         sejam modificadas.
        */
        
        return redirect()
            ->route('posts.index')
            ->with('message', 'Post atualizado com sucesso');


    }
    


}