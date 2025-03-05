<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pegawai::select('*');

            if ($request->has('nama') && !empty($request->nama)) {
                $data->where('nama', 'like', '%' . $request->nama . '%');
            }

            if ($request->has('jabatan') && !empty($request->jabatan)) {
                $data->where('jabatan', $request->jabatan);
            }

            if ($request->has('tanggal_masuk') && !empty($request->tanggal_masuk)) {
                $dates = explode(' - ', $request->tanggal_masuk);
                $data->whereBetween('tanggal_masuk', [date('Y-m-d', strtotime($dates[0])), date('Y-m-d', strtotime($dates[1]))]);
            }

            return DataTables::of($data)
                ->addColumn('action', function($row){
                    return '<a href="#" class="btn btn-sm btn-primary edit" data-id="'.$row->id.'">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pegawai.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'jabatan' => 'required',
            'tanggal_masuk' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Pegawai::create($request->all());

        return response()->json(['success' => 'Pegawai berhasil ditambahkan.']);
    }

    public function api()
    {
        return response()->json(Pegawai::all());
    }
}