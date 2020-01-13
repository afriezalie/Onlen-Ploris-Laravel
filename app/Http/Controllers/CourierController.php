<?php

namespace App\Http\Controllers;

use App\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    public function index() {
        return view('courier.index', ['couriers_col' => Courier::paginate(10)]);
    }

    public function create() {
        return view('courier.insert');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'cost' => 'required|numeric|min:3000'
        ]);

        Courier::create([
            'name' => $request->name,
            'cost' => $request->cost,
        ]);

        $newPage = Courier::paginate(10)->lastPage();

        return redirect()->route('courier.index', ['page' => $newPage])
            ->with('success', $request->name.' inserted.');
    }

    public function edit($id) {
        $courier = Courier::find($id);

        if($courier == null) {
            return redirect()->route('courier.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        return view('courier.edit', ['courier' => $courier]);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|string|min:3',
            'cost' => 'required|numeric|min:3000'
        ]);

        $courier = Courier::find($id);

        if($courier == null) {
            return redirect()->route('courier.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $courier->name = $request->name;
        $courier->cost = $request->cost;
        $courier->save();

        return redirect()->route('courier.index')->with('success', 'Courier '.$id.' has been updated.');
    }

    public function delete($id) {
        $courier = Courier::find($id);

        if($courier == null) {
            return redirect()->route('courier.index')->withErrors(['operation_failed' => 'Oops, something went wrong.']);
        }

        $courier_name = $courier->name;
        $courier->delete();

        return redirect()->route('courier.index')->with('success', $courier_name.' deleted.');
    }

    public function search(Request $request) {
        if($request->q == null) {
            return redirect()->route('courier.index');
        }

        $search_result = Courier::where('name', 'LIKE', '%'.$request->q.'%')->paginate(10);
        return view('courier.search_result', ['results' => $search_result, 'query' => $request->q]);
    }
}
