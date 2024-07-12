<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class ReservationController extends Controller
{

    //index
    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->orderBy('reserved_datetime', 'desc')
            ->paginate(15);

        return view('reservations.index', compact('reservations'));
    }

    //create
    public function create(Restaurant $restaurant)
    {
        return view('reservations.create', compact('restaurant'));
    }

    //store
    public function store(Request $request, Restaurant $restaurant)
    {
        // バリデーション
        $request->validate([
            'reservation_date' => 'required|date_format:Y-m-d',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_people' => 'required|integer|min:1|max:50',
        ]);

        $reserved_datetime = $request->reservation_date . ' ' . $request->reservation_time;

        Reservation::create([
            'reserved_datetime' => $reserved_datetime,
            'number_of_people' => $request->number_of_people,
            'restaurant_id' => $restaurant->id,
            'user_id' => Auth::id(),
        ]);

        // フラッシュめっせーじ
        return redirect()->route('reservations.index')->with('flash_message', '予約が完了しました。');
    }

    //destroy
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('flash_message', '予約を削除しました。');
    }
}
