<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Services\Midtrans\CallbackService;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        try {
            $callback = new CallbackService;

            if ($callback->isSignatureKeyVerified()) {
                $notification = $callback->getNotification();
                $order = $callback->getOrder();

                if ($callback->isSuccess()) {
                    Transaction::where('order_id', $order->order_id)->update([
                        'stts' => 'dibayar',
                    ]);
                }

                if ($callback->isExpire()) {
                    Transaction::where('order_id', $order->order_id)->update([
                        'stts' => 'kadaluarsa',
                    ]);
                }

                if ($callback->isCancelled()) {
                    Transaction::where('order_id', $order->order_id)->update([
                        'stts' => 'batal',
                    ]);
                }

                return response()
                    ->json([
                        'success' => true,
                        'message' => 'Notification successfully processed',
                    ]);
            } else {
                return response()
                    ->json([
                        'error' => true,
                        'message' => 'Signature key not verified',
                    ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
