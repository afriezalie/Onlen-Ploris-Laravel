<?php

namespace App\Http\Controllers;

use App\Flower;
use App\FlowerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlowerController extends Controller
{
    public function index() {
        return view('flower.index', ['results' => Flower::paginate(10)]);
    }
    
    public function index_admin() {
        return view('flower.index_admin', ['results' => Flower::paginate(10)]);
    }

    public function show($id) {
        $flower = Flower::find($id);

        if($flower == null) {
            return redirect()->route('flower.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        return view('flower.show', ['flower' => $flower]);
    }
    
    public function create() {
        return view('flower.insert', ['flower_types' => FlowerType::all()]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'type' => 'required',
            'price' => 'required|numeric|min:10000',
            'description' => 'required|string|between:20,200',
            'stock' => 'required|numeric|gt:0',
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        $image_path = $request->file('image')->store('flower_images');

        Flower::create([
            'name' => $request->name,
            'type_id' => $request->type,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $image_path
        ]);

        $newPage = Flower::paginate(10)->lastPage();
        return redirect()->route('flower.index_admin', ['page' => $newPage])
            ->with('success', $request->name.' inserted.');
    }

    public function edit($id) {
        $flower = Flower::find($id);

        if($flower == null) {
            return redirect()->route('flower.index_admin')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        return view('flower.edit', ['flower' => $flower, 'flower_types' => FlowerType::all()]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'type' => 'required',
            'price' => 'required|numeric|min:10000',
            'description' => 'required|string|between:20,200',
            'stock' => 'required|numeric|gt:0',
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);

        $flower = Flower::find($id);

        if($flower == null) {
            return redirect()->route('flower.index_admin')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        Storage::delete($flower->image);

        $image_path = $request->file('image')->store('flower_images');

        $flower->name = $request->name;
        $flower->type_id = $request->type;
        $flower->price = $request->price;
        $flower->description = $request->description;
        $flower->stock = $request->stock;
        $flower->image = $image_path;
        $flower->save();

        return redirect()->route('flower.index_admin')->with('success', 'Flower updated.');
    }

    public function delete($id) {
        $flower = Flower::find($id);

        if($flower == null) {
            return redirect()->route('flower.index_admin')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $flower_name = $flower->name;

        Storage::delete($flower->image);
        $flower->delete();

        return redirect()->route('flower.index_admin')->with('success', $flower_name.' deleted.');
    }

    public function search(Request $request) {
        if($request->q == null) {
            return redirect()->route('flower.index');
        }

        $search_result = Flower::where('name', 'LIKE', '%'.$request->q.'%')
            ->orWhere('description', 'LIKE', '%'.$request->q.'%')->paginate(10);
        return view('flower.search_result', ['results' => $search_result, 'query' => $request->q]);
    }

    public function search_admin(Request $request) {
        if($request->q == null) {
            return redirect()->route('flower.index_admin');
        }

        $search_result = Flower::where('name', 'LIKE', '%'.$request->q.'%')
            ->orWhere('description', 'LIKE', '%'.$request->q.'%')->paginate(10);
        return view('flower.search_result_admin', ['results' => $search_result, 'query' => $request->q]);
    }

}