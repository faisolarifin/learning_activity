<?php

namespace App\Http\Controllers;

use App\Models\{
    Bulan, 
    Metode,
    Tahun,
};
use Illuminate\Http\Request;

class Master extends Controller
{
    ///Bulan 

    public function indexBulan()
    {
        $bulan = Bulan::all();
        return view('bulan', compact('bulan'));
    }
    public function getBulan($id=null)
    {
        if ($id == null) $bulan = Bulan::get();
        else $bulan = Bulan::find($id);

        return response()->json($bulan);
    }
    public function saveBulan(Request $request)
    {
        Bulan::create([
            'nm_bulan' => $request->bulan
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan bulan',
        ]);
    }
    public function updateBulan(Request $request)
    {
        Bulan::find($request->kode)->update([
            'nm_bulan' => $request->bulan
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah bulan',
        ]);
    }
    public function deleteBulan(Request $request)
    {
        Bulan::find($request->kode)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus bulan',
        ]);
    }

    public function indexTrashBulan()
    {
        $bulan = Bulan::onlyTrashed()->get();
        return view('trash_bulan', compact('bulan'));
    }
    public function getTrashBulan()
    {
        $pjw = Bulan::onlyTrashed()->get();
        return response()->json($pjw);
    }
    public function restoreTrashBulan(Request $request)
    {
        Bulan::onlyTrashed()->find($request->kode)->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore  bulan',
        ]);
    }
    public function restoreAllTrashBulan()
    {
        Bulan::onlyTrashed()->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore semua  bulan',
        ]);
    }
    public function deleteTrashBulan(Request $request)
    {
        Bulan::onlyTrashed()->find($request->kode)->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen  bulan',
        ]);
    }
    public function deleteAllTrashBulan()
    {
        Bulan::onlyTrashed()->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen semua bulan',
        ]);
    } 

    ////Metode

    public function indexMetode()
    {
        $metode = Metode::where(['id_thn' => 1])->get();
        $tahun = Tahun::all();
        return view('metode', compact('metode', 'tahun'));
    }
    public function getMetode(Request $request, $id=null)
    {
        if ($id == null) $metode = Metode::where('id_thn', $request->tahun)->get();
        else $metode = Metode::find($id);

        return response()->json($metode);
    }
    public function saveMetode(Request $request)
    {
        Metode::create([
            'id_thn' => $request->tahun,
            'nm_metode' => $request->metode,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan metode',
        ]);
    }
    public function updateMetode(Request $request)
    {
        Metode::find($request->kode)->update([
            'id_thn' => $request->tahun,
            'nm_metode' => $request->metode
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah metode',
        ]);
    }
    public function deleteMetode(Request $request)
    {
        Metode::find($request->kode)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus metode',
        ]);
    }

    public function indexTrashMetode()
    {
        $metode = Metode::onlyTrashed()->get();
        return view('trash_metode', compact('metode'));
    }
    public function getTrashMetode()
    {
        $metode = Metode::with('tahun')->onlyTrashed()->get();
        return response()->json($metode);
    }
    public function restoreTrashMetode(Request $request)
    {
        Metode::onlyTrashed()->find($request->kode)->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore  metode',
        ]);
    }
    public function restoreAllTrashMetode()
    {
        Metode::onlyTrashed()->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore semua  metode',
        ]);
    }
    public function deleteTrashMetode(Request $request)
    {
        Metode::onlyTrashed()->find($request->kode)->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen  metode',
        ]);
    }
    public function deleteAllTrashMetode()
    {
        Metode::onlyTrashed()->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen semua metode',
        ]);
    } 

    ////Tahun

    public function indexTahun()
    {
        $tahun = Tahun::all();
        return view('tahun', compact('tahun'));
    }
    public function getTahun($id=null)
    {
        if ($id == null) $tahun = Tahun::get();
        else $tahun = Tahun::find($id);

        return response()->json($tahun);
    }
    public function saveTahun(Request $request)
    {
        Tahun::create([
            'nm_tahun' => $request->tahun,
            'deskripsi' => $request->deskripsi,
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan tahun',
        ]);
    }
    public function updateTahun(Request $request)
    {
        Tahun::find($request->kode)->update([
            'nm_tahun' => $request->tahun,
            'deskripsi' => $request->deskripsi,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah tahun',
        ]);
    }
    public function deleteTahun(Request $request)
    {
        Tahun::find($request->kode)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus tahun',
        ]);
    }
    public function indexTrashTahun()
    {
        $tahun = Tahun::onlyTrashed()->get();
        return view('trash_tahun', compact('tahun'));
    }
    public function getTrashTahun()
    {
        $tahun = Tahun::onlyTrashed()->get();
        return response()->json($tahun);
    }
    public function restoreTrashTahun(Request $request)
    {
        Tahun::onlyTrashed()->find($request->kode)->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore  tahun',
        ]);
    }
    public function restoreAllTrashTahun()
    {
        Tahun::onlyTrashed()->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore semua  tahun',
        ]);
    }
    public function deleteTrashTahun(Request $request)
    {
        Tahun::onlyTrashed()->find($request->kode)->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen  tahun',
        ]);
    }
    public function deleteAllTrashTahun()
    {
        Tahun::onlyTrashed()->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen semua tahun',
        ]);
    }

}
