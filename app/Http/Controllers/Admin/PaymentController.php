<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentRequest;
use App\Models\Payment;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentRepository $paymentRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function index(Request $request): View
    {
        $payments = $this->paymentRepository->paginate($request);

        return view('payments.index', [
            'payments' => $payments,
        ]);
    }

    public function create(): View
    {
        $users = $this->userRepository->get();

        return view('payments.create', [
            'users' => $users,
        ]);
    }

    public function store(PaymentRequest $request): RedirectResponse
    {
        $this->paymentRepository->create($request->validated());

        return to_route('payments.index')->with('success', __('success.create'));
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $this->paymentRepository->delete($payment);

        return back()->with('success', __('success.delete'));
    }
}
