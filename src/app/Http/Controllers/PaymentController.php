<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        // paginate
        $perPage = 15;
        if (
            request()->has('perPage')
            && request()->input('perPage') > 0
            && request()->input('perPage') <= 10000
        ) {
            $perPage = request()->input('perPage');
        }

        // search by login
        $payments = Payment::query()
            ->when(request('search_login'), function ($query) {
                $query->where('login', 'like', '%' . request('search_login') . '%');
            })
            ->with(['currency:id,code,symbol,title'])
            ->paginate($perPage);

        return PaymentResource::collection($payments);

    }

    public function show(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function store(StorePaymentRequest $request)
    {
//        $this->authorize('payments.store');
        $data = $request->validated();

        $payment = Payment::create(
            [
                'creds' => $data['creds'],
                'sum' => ((float)$data['sum'] * 100),
                'currency_id' => $data['currency_id'],
                'user_id' => $data['user_id'],
            ]
        );

        return new PaymentResource($payment);
    }

    public function update(Payment $payment, StorePaymentRequest $request)
    {
//        $this->authorize('payments.update');

        $data = $request->validated();

        $payment->update([
            'creds' => $data['creds'],
            'sum' => ((float)$data['sum'] * 100),
            'currency_id' => $data['currency_id'],
            'user_id' => $data['user_id'],
        ]);

        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {
//        $this->authorize('payments.delete');
        if (!$payment->delete()) {
            return response()->json(['errors' => ['general' => ['damn..']]], 500);
        }

        return response()->noContent();
    }
}
