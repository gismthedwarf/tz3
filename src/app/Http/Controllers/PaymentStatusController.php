<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class PaymentStatusController extends Controller
{
    public function index (): array
    {
        return [
            PaymentStatus::OPEN->value,
            PaymentStatus::PAID->value,
        ];
    }

    public function toggle (Payment $payment): JsonResponse
    {

        $payment->status = ($payment->status === PaymentStatus::OPEN->value) ? PaymentStatus::PAID->value : PaymentStatus::OPEN->value;

        if (!$payment->save()) {
            return response()->json(['errors' => ['general' => ['...']]], 500);
        }

        return response()->json($payment);
    }
}
