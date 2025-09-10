<?php

namespace App\Http\Controllers;

use App\Models\CategoryItem;
use Illuminate\Http\Request;

class CategoryItemController extends Controller
{
    public function index()
    {
        return view('category_items.index.index');
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = CategoryItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('category_items.form.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data = new CategoryItem;
            $kode = CategoryItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data = CategoryItem::find($id);
            $kode = $data->kode;
        }

        $data->nama = $request->nama;
        $data->kode = $kode;
        $data->save();

        return redirect('category-items');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = CategoryItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        if (!empty($hargamin)) $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        if (!empty($hargamax)) $data_search = $data_search->where('harga_beli', '<=', $hargamax);

        $data_search = $data_search->select('kode', 'nama')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function singleView($kode)
    {
        $data['data'] = CategoryItem::where('kode', $kode)->first();
        return view('category_items.single.index', $data);
    }

    public function delete($id)
    {
        CategoryItem::find($id)->delete();
        return redirect('category-items');
    }
}
