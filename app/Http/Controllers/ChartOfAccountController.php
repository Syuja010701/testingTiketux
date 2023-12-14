<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\KategoriCoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class ChartOfAccountController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
          $data = ChartOfAccount::latest();

            // Filter berdasarkan kategori
            if ($request->has('filter_kategori') && $request->filter_kategori != 'all') {
                // dd($request->filter_kategori);
                $data->where('kategori_coa_id', $request->filter_kategori);
            }

            $data = $data->get();

            return DataTables::of($data)
                     ->addColumn('kategori_coa_id', function($item){
                        return ($item->kategoriCoa == null ? 'Kategori COA Telah Di Hapus!' : $item->kategoriCoa->nama);
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm m-1 editCoa">Edit</a>';
   
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm m-1 deleteCoa">Delete</a>';

                        $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm m-1 showCoa">Detail</a>';

                        return $btn;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $kategoris = KategoriCoa::all();

        return view('chart_of_account.index',compact('kategoris'));
    }

    public function store(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(),[
            'kode' => 'required',
            'nama' => 'required',
            'kategori_coa_id' => 'required',
        ],
        [
            'kode.required' => 'Kode Harus Di Isi!',
            'nama.required' => 'Nama Harus Di Isi!',
            'kategori_coa_id.required' => 'kategori Harus Di Isi!',
        ]
        );

        // dd($validator);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

       $data = ChartOfAccount::updateOrCreate(
            ['id' => $request->id],
            [
                'kode' => $request->kode,
                'kategori_coa_id' => $request->kategori_coa_id,
                'nama' => $request->nama,
            ]
        );

       

        $textMessage = $data->id == $request->id ? 'Diperbarui' : 'Ditambahkan';

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil ' . $textMessage . '!',
            'data' => $data
        ]);
    }

    public function edit($id){
        $data = ChartOfAccount::find($id);
        return response()->json($data);
    }

    public function show($id){
        $data = ChartOfAccount::find($id);
        return response()->json($data);
    }

    public function destroy($id){
        ChartOfAccount::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }

    
}
