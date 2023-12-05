<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{
    public function index(Request $request){

        if($request->ajax()){
            $data = Transaksi::latest()->get();

            return DataTables::of($data)
                     ->addColumn('coa_id_kode', function($item){
                         return ($item->coa == null ? 'COA Telah Di Hapus!' : $item->coa->kode);
                    })
                    ->addColumn('coa_id_nama', function($item){
                        return ($item->coa == null ? 'COA Telah Di Hapus!' : $item->coa->nama);

                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm m-1 editTransaksi">Edit</a>';
   
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm m-1 deleteTransaksi">Delete</a>';

                        $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Show" class="btn btn-info btn-sm m-1 showTransaksi">Detail</a>';

                        return $btn;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $chartOfAccounts = ChartOfAccount::all();

        return view('transaksi.index',compact('chartOfAccounts'));
    }

    public function store(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(),[
            'desc' => 'required',
            'kode_coa' => 'required',
            'tanggal' => 'required',
            'debit' => 'nullable',
            'credit' => 'nullable'
        ],
        [
            'desc.required' => 'Deskripsi Harus Di Isi!',
            'tanggal.required' => 'Tanggal Harus Di Isi!',
            'kode_coa.required' => 'Harap Pilih Kode!'
        ]
        );

        // dd($validator);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

       $data = Transaksi::updateOrCreate(
            ['id' => $request->id],
            [
                'coa_id' => $request->kode_coa,
                'tanggal' => $request->tanggal,
                'desc' => $request->desc,
                'debit' => $request->debit,
                'credit' => $request->credit,
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
        $data = Transaksi::where('id', $id)->with('coa')->first();
        return response()->json($data);
    }

    public function show($id){
        $data = Transaksi::where('id', $id)->with('coa')->first();
        return response()->json($data);
    }

    public function destroy($id){
        Transaksi::find($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }

    public function getDetail(Request $request, $id){
        $data = ChartOfAccount::find($id);

        return response()->json($data);
    }

    
}