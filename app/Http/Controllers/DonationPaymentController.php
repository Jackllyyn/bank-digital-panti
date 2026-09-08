<?php
// app/Http/Controllers/DonationPaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaanDonasi;
use App\Models\Donatur;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class DonationPaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'required|string|max:20',
            'jumlah' => 'required|numeric|min:10000',
            'jenis_donasi' => 'required|string',
        ]);

        // Buat order ID unik
        $orderId = 'DON-' . date('Ymd') . '-' . rand(1000, 9999);

        // Dapatkan user_id
        $userId = Auth::check() ? Auth::id() : 1;

        // Simpan data donasi
        $donasi = PenerimaanDonasi::create([
            'no_transaksi' => $orderId,
            'order_id' => $orderId,
            'tanggal' => now(),
            'jenis' => $request->jenis_donasi,
            'keterangan' => $request->pesan ?? '',
            'jumlah' => $request->jumlah,
            'cara_bayar' => 'online',
            'payment_status' => 'pending',
            'user_id' => $userId
        ]);

        // Siapkan parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->jumlah,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'email' => $request->email,
                'phone' => $request->telepon,
            ],
            'item_details' => [
                [
                    'id' => 'donasi',
                    'price' => (int) $request->jumlah,
                    'quantity' => 1,
                    'name' => 'Donasi ' . ucfirst($request->jenis_donasi),
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            // Update snap token
            $donasi->update(['snap_token' => $snapToken]);

            return view('public.payment', compact('snapToken', 'orderId', 'donasi'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        $orderId = $request->order_id;
        $donasi = PenerimaanDonasi::where('order_id', $orderId)->first();

        if (!$donasi) {
            abort(404);
        }

        return view('public.payment-success', compact('donasi'));
    }

    public function paymentFailed(Request $request)
    {
        return view('public.payment-failed');
    }

    public function notificationHandler(Request $request)
    {
        try {
            $notification = new Notification();

            $orderId = $notification->order_id;
            $statusCode = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            $donasi = PenerimaanDonasi::where('order_id', $orderId)->first();

            if (!$donasi) {
                return response()->json(['error' => 'Transaction not found'], 404);
            }

            // Update payment status
            $paymentStatus = 'pending';
            $paymentResponse = json_encode((array) $notification);

            if ($statusCode == 'capture') {
                if ($fraudStatus == 'accept') {
                    $paymentStatus = 'success';
                    $donasi->update(['paid_at' => now()]);
                }
            } elseif ($statusCode == 'settlement') {
                $paymentStatus = 'success';
                $donasi->update(['paid_at' => now()]);
            } elseif ($statusCode == 'deny') {
                $paymentStatus = 'failed';
            } elseif ($statusCode == 'cancel' || $statusCode == 'expire') {
                $paymentStatus = 'expired';
            } elseif ($statusCode == 'pending') {
                $paymentStatus = 'pending';
            }

            $donasi->update([
                'payment_status' => $paymentStatus,
                'payment_response' => $paymentResponse
            ]);

            return response()->json(['status' => 'OK']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}