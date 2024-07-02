<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class KasirController extends Controller
{
//     public function index(Request $request)
// {
//     $barangs = Barang::all();
//     $selectedBarang = null;

//     if ($request->has('kode_barang')) {
//         $selectedBarang = Barang::where('KodeBarang', $request->kode_barang)->first();
//     }

//     return view('kasir', compact('barangs', 'selectedBarang'));
// }
    public function index(Request $request)
    {
        $barangs = Barang::all();
    
        if ($request->ajax()) {
            $kodeBarang = $request->kode_barang;
            $barang = Barang::findOrFail($kodeBarang);
            return response()->json([
                'kode_barang' => $barang->kodeBarang,
                'kode_barang'=>$barang->kodeBarang, // Pastikan konsisten dan benar
                'stok' => $barang->Stok,
                'harga_jual' => $barang->HargaJual,
            ]);
        }
    
        // return view('kasir', compact('barangs'));
        return view('kasir')->with('barangs', $barangs);
    }
    
    public function getBarangDetails($kodeBarang)
    {
        $barang = Barang::findOrFail($kodeBarang);
        return response()->json([
            'kode_barang1' => $barang->KodeBarang,
            'kode_barang'=>$barang->KodeBarang,
            'stok' => $barang->Stok,
            'harga_jual' => $barang->HargaJual
        ]);
    }
    // public function index()
    // {
    //     $barangs = Barang::all();
    //     return view('kasir', compact('barangs'));
    // }

    // public function getBarangDetails($kodeBarang)
    // {
    //     $barang = Barang::findOrFail($kodeBarang);
    //     return response()->json([
    //         'kode_barang' => $barang->KodeBarang,
    //         'stok' => $barang->Stok,
    //         'harga_jual' => $barang->HargaJual
    //     ]);
    // }
    // public function submitOrder(Request $request)
    // {
    //     $validated = $request->validate([
    //         'total_harga' => 'required|numeric',
    //         'items' => 'required|array'
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         // Create an order
    //         $order = Order::create([
    //             'total_harga' => $validated['total_harga'],
    //             'tanggal_order' => now(),
    //         ]);

    //         // Update the quantity of each product in the Barang table
    //         foreach ($validated['items'] as $item) {
    //             $barang = Barang::where('Nama', $item['nama_barang'])->firstOrFail();
    //             $barang->Stok -= $item['quantity'];
    //             $barang->save();
    //         }

    //         DB::commit();

    //         return response()->json(['success' => true]);

    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error processing order:', ['exception' => $e]);
    //         return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
    //     }
    // }

    public function submitOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'total_harga' => 'required|numeric'
            ]);

            Order::create([
                'total_harga' => $validated['total_harga'],
                'tanggal_order' => now(),
            ]);

            return response()->json(['success' => true]);

        } catch (Exception $e) {
            Log::error('Error processing order:', ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    public function showOrder()
    {
        $orders = \App\Models\Order::all();
        return view('orders', compact('orders'));
    }
}