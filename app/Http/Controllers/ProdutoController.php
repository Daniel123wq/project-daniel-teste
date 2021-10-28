<?php

namespace App\Http\Controllers;

use App\Repository\ProdutoRepositoryInterface;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected $produtoRepository;

    public function __construct(ProdutoRepositoryInterface $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function index () 
    {
        return response()->json($this->produtoRepository->all(
            request()->input('columns', ['*']),
            request()->input('relations', []),
            request()->input('per-page', 25),
            request()->input('page') ? true : false,
        ), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json($this->produtoRepository->create($request->all()), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->produtoRepository->findById(
            $id,    
            request()->input('columns', ['*']),
            request()->input('relations', []),
        ), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return bool
     */
    public function update(Request $request, $id)
    {
        return response()->json($this->produtoRepository->update($id, $request->all()), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json($this->produtoRepository->deleteById($id), 200);
    }
}
