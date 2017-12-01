<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
	public function index(Request $request)
	{
		if (!$request->ajax()) abort( 404 );

		return [ 'items' => Item::all() ];
	}

	public function items()
	{
		return view('items.index');
	}

	public function store(Request $request)
	{
		$create = Item::create($request->all());
		return response()->json($create);
	}

	public function update(Request $request, $item)
	{
		$edit = Item::find($item)->update($request->all());
		return response()->json($edit);
	}

	public function destroy($item)
    {
        Item::find($item)->delete();
        return response()->json(['ok']);
    }
}
