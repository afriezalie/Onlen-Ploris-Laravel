<?php

namespace App\Http\Controllers;

use App\FlowerType;
use Illuminate\Http\Request;

class FlowerTypeController extends Controller
{
    public function index() {
        return view('flower_type.index', ['flower_types' => FlowerType::paginate(10)]);
    }

    public function create() {
        return view('flower_type.insert');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|min:4|unique:flower_types,name',
        ]);

        FlowerType::create([
            'name' => $request->name,
        ]);

        $newPage = FlowerType::paginate(10)->lastPage();
        return redirect()->route('flower_type.index', ['page' => $newPage])
            ->with('success', $request->name.' inserted.');
    }

    public function edit($id) {
        if(FlowerType::find($id) == null) {
            return redirect()->route('flower_type.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        return view('flower_type.edit', ['id' => $id]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|string|min:4|unique:flower_types,name',
        ]);
        
        $flower_type = FlowerType::find($id);

        if($flower_type == null) {
            return redirect()->route('flower_type.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $type_old_name = $flower_type->name;
        
        $flower_type->name = $request->name;
        $flower_type->save();

        return redirect()->route('flower_type.index')
            ->with('success', $type_old_name.' has been updated to '.$request->name.'.');
    }

    public function delete($id) {
        $flower_type = FlowerType::find($id);

        if($flower_type == null) {
            return redirect()->route('flower_type.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $type_name = $flower_type->name;
        $flower_type->delete();

        return redirect()->route('flower_type.index')->with('success', $type_name.' deleted.');
    }

    public function search(Request $request) {
        if($request->q == null) {
            return redirect()->route('flower_type.index');
        }
        $search_result = FlowerType::where('name', 'LIKE', '%'.$request->q.'%')->paginate(10);
        return view('flower_type.search_result', ['results' => $search_result, 'query' => $request->q]);
    }
}
