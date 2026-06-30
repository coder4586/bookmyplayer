<?php

namespace App\Http\Controllers\Admin\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use App\Models\Adm_orders;
use App\Models\Adm_plans;
use Illuminate\Routing\Controller as BaseController;


class PaymentController extends BaseController
{
    public function index()
    {
        return view("static.payment");
    }

    private function validatePlan($planId, $amount, $userType)
    {
        if ($userType == 2) { // Assuming type_id 2 is for academy
            if (!(($planId == 1 && $amount == 1) || ($planId == 2 && $amount == 2))) {
                return [
                    'success' => false,
                    'error' => 'Invalid plan selection for academy. Payment cannot be processed.'
                ];
            }
        }
        return ['success' => true];
    }


    public function createOrder(Request $request)
    {
        try {
            $userId = session()->get('userId');
            $planId = $request->input('planId');
            $user = get_data_row(null, 'bmp_user', 'id', $userId);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not found'
                ]);
            }

            if (!$planId) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid plan selection. Payment cannot be processed.'
                ]);
            }

            $plan = Adm_plans::where('id', $planId)
                ->where('active', 1)
                ->where('type_id', $user->type_id)
                ->first();

            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid plan selection. Payment cannot be processed.'
                ]);
            }

            $amount = $plan->offer_price;

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $order = $api->order->create([
                'amount' => $amount * 100,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            session()->put('razorpay_order_id', $order['id']);
            session()->put('amount', $amount);

            return response()->json([
                'order_id' => $order['id'],
                'razorpay_key' => env('RAZORPAY_KEY'),
                'amount' => $amount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function verifyPayment(Request $request)
    {
        try {
            $userId = session()->get('userId');
            $planId = $request->input('planId');
            $user = get_data_row(null, 'bmp_user', 'id', $userId);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not found'
                ]);
            }


            $plan = Adm_plans::where('id', $planId)
                ->where('active', 1)
                ->where('type_id', $user->type_id)
                ->first();

            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid plan selection. Payment cannot be processed.'
                ]);
            }

            $object_id = $user->parent_id;
            $type_id = $user->type_id;
            $user_id = $user->id;
            $object_types = [1 => 'coach', 2 => 'academy', 3 => 'player'];
            $object_type = $object_types[$type_id] ?? 'unknown';

            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $verification_response = $api->utility->verifyPaymentSignature($attributes);
            $payment = $api->payment->fetch($request->razorpay_payment_id);

            $adm_order = Adm_orders::create([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'object_type' => $object_type ?? '',
                'object_id' => $object_id ?? '',
                'user_id' => $user_id ?? '',
                'plan_id' => $planId ?? '',
                'resp' => json_encode($payment)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'data' => $attributes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }


}
