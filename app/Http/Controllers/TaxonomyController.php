<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taxonomy;
use App\TermMeta;
use Illuminate\Support\Facades\DB;

class TaxonomyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categoryData = Taxonomy::with('parent', 'term_meta')->get();
        return response()->json($categoryData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $checkSlugString = str_slug($request->input('name'));

        $validInputData = $request->validate([
            'name' => 'required|string|unique:taxonomy|max:60',
            'slug' => 'required_with:name|unique:taxonomy|max:100|in:'.$checkSlugString,
            'type' => 'required|alpha|max:50',
            'parent' => 'required|exists:taxonomy,taxonomy_id'
        ]);

        $insertedData = Taxonomy::create($validInputData);
        
        return response()->json($insertedData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $categoryData = Taxonomy::with('parent', 'term_meta')
            ->where('taxonomy_id', $id)
            ->get();
        return response()->json($categoryData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        $existsData = Taxonomy::findOrFail($id);

        $checkSlugString = str_slug($request->input('name'));

        $validInputData = $request->validate([
            'name' => 'sometimes|required_with:slug|string|unique:taxonomy|max:60',
            'slug' => 'sometimes|required_with:name|unique:taxonomy|max:100|in:'.$checkSlugString,
            'type' => 'sometimes|required|alpha|max:50',
            'parent' => 'sometimes|required|exists:taxonomy,taxonomy_id'
        ]);

        $existsData->update($validInputData);

        $categoryData = Taxonomy::with('parent', 'term_meta')
            ->where('taxonomy_id', $id)
            ->get();

        return response()->json($categoryData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $existsData = Taxonomy::findOrFail($id);

        try {
            DB::beginTransaction();

            TermMeta::where('taxonomy_id', $id)
                ->delete();

            $existsData->delete();

            DB::commit();

            $response = [
                "message" => "Data deleted successfully"
            ];
            $responseCode = 200;
        } catch (\Exception $e) {
            DB::rollback();

            $response = [
                "message" => "Something went wrong while deleting data.",
                "errors" => "Exception encountered. ".$e
            ];
            $responseCode = 400;
        }

        return response()->json($response, $responseCode);
    }
}
