<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Repositories\Booking\IBookingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BookingsController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard');
    }

    public function list(): JsonResponse
    {
        return response()->json(Booking::with('room', 'user')
            ->where('user_id', auth()->id())
            ->get());
    }

    public function store(BookingRequest $request, IBookingRepository $bookingRepository): JsonResponse
    {
        $result = $bookingRepository->store($request->all());

        return $this->sendResponse(
            $result->getMessage(),
            $result->getData(),
            $result->getStatusCode()
        );
    }

    public function update(
        BookingUpdateRequest $bookingUpdateRequest,
        IBookingRepository $bookingRepository,
        Booking $booking
    ) {
        $result = $bookingRepository->update($booking, $bookingUpdateRequest->all());

        return $this->sendResponse(
            $result->getMessage(),
            $result->getData(),
            $result->getStatusCode()
        );
    }

    public function destroy(Booking $booking, IBookingRepository $bookingRepository)
    {
        $result = $bookingRepository->destroy($booking);

        return $this->sendResponse(
            $result->getMessage(),
            $result->getData(),
            $result->getStatusCode()
        );
    }
}
