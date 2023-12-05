<?php

namespace App\Http\Controllers;

use App\Models\KategoriCoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

use function Laravel\Prompts\error;

class KategoriCoaController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
  
            $data = KategoriCoa::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm m-1 editKategoriCoa">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm m-1 deleteKategoriCoa">Delete</a>';

                           $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm m-1 showKategoriCoa">Detail</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('kategori_COA.index');
    }

    public function store(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
                'nama'     => 'required',
            ],
            [
                'nama.required' => 'Nama Tidak Boleh Kosong!'
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // dd($validator);
        $data = KategoriCoa::updateOrCreate(
             ['id' => $request->id],
             [
            'nama' => $request->nama] 
        );        
        
        $textMessage = $data->id == $request->id ? 'Diperbarui' : "Ditambahkan"; 
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil ' . $textMessage . '!',
            'data'    => $data  
        ]);
    }

    public function edit($id){
        $kategoriCoa = KategoriCoa::find($id);
        return response()->json($kategoriCoa);
    }

    public function destroy($id){
        $kategoriCoa = KategoriCoa::find($id);
        $kategoriCoa->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]);
    }

    public function show($id){
        $kategoriCoa = KategoriCoa::find($id);
        return response()->json($kategoriCoa);
    }
}
