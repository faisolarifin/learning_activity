<?php

namespace App\Http\Controllers;

use App\Models\{
    Aktivitas,
    Bulan, 
    Metode,
    Tahun
};
use Illuminate\Http\Request;

class Activity extends Controller
{
    public function index()
    {
        $bulan = Bulan::get();
        $tahun = Tahun::get();
        return view('jadwal', compact('bulan', 'tahun'));
    }

    public function jadwalAktivitas(Request $request)
    {
        $awal = $request->awal ?? 1;
        $akhir = $request->akhir ?? 6;
        $tahun = $request->tahun;
        $result = array();

        foreach(Metode::where(['id_thn' => $tahun])->orderBy('id_mtd')->get() as $row)
        {
            if (Aktivitas::where('id_mtd', $row->id_mtd)->get()->count() == 0) {
                $result[$row->nm_metode] = array();
                continue;
            }
            $result[$row->nm_metode] = Bulan::whereBetween('id_bln', [$awal, $akhir])->with(['aktivitas' => function($q) use ($row, $tahun) {
                $q->where([
                    'id_thn' => $tahun,
                    'id_mtd' => $row->id_mtd,
                ]);
            }])->get();
        }

        return response()->json($result);
    }
   
    public function indexAktivitas()
    {
        $pjw = Aktivitas::where(['id_thn' => Aktivitas::min('id_thn')])->with('metode')->with('bulan')->get();
        $metode = Metode::where('id_thn', Tahun::min('id_thn'))->get();
        $bulan = Bulan::get();
        $tahun = Tahun::get();
        return view('pjw', compact('pjw', 'metode', 'bulan', 'tahun'));
    }
    public function getAktivitas(Request $request, $id=null)
    {
        if ($id == null) $pjw = Aktivitas::where(['id_thn' => $request->tahun])->with('metode')->with('bulan')->get();
        else $pjw = Aktivitas::find($id);

        return response()->json($pjw);
    }
    public function saveAktivitas(Request $request)
    {
        Aktivitas::create([
            'id_mtd' => $request->metode,
            'id_thn' => $request->tahun,
            'id_bln' => $request->bulan,
            'acara' => $request->acara,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan kegiatan',
        ]);
    }
    public function updateAktivitas(Request $request)
    {
        Aktivitas::find($request->kode)->update([
            'id_mtd' => $request->metode,
            'id_thn' => $request->tahun,
            'id_bln' => $request->bulan,
            'acara' => $request->acara,
            'tgl_awal' => $request->tgl_awal,
            'tgl_akhir' => $request->tgl_akhir,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil mengubah kegiatan',
        ]);
    }
    public function deleteAktivitas(Request $request)
    {
        Aktivitas::find($request->kode)->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus kegiatan',
        ]);
    }

    public function indexTrashAktivitas()
    {
        $pjw = Aktivitas::onlyTrashed()->get();
        return view('trash_pjw', compact('pjw'));
    }
    public function getTrashAktivitas()
    {
        $pjw = Aktivitas::with('tahun')->with('metode')->with('bulan')->onlyTrashed()->get();
        return response()->json($pjw);
    }
    public function restoreTrashAktivitas(Request $request)
    {
        Aktivitas::onlyTrashed()->find($request->kode)->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore kegiatan',
        ]);
    }
    public function restoreAllTrashAktivitas()
    {
        Aktivitas::onlyTrashed()->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil merestore semua kegiatan',
        ]);
    }
    public function deleteTrashAktivitas(Request $request)
    {
        Aktivitas::onlyTrashed()->find($request->kode)->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen kegiatan',
        ]);
    }
    public function deleteAllTrashAktivitas()
    {
        Aktivitas::onlyTrashed()->forceDelete();
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus permanen semua kegiatan',
        ]);
    } 
}
