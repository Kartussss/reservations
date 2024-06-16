<?php

namespace App\Http\Controllers;

use App\Models\TableReservation;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Inertia\Inertia;
use phpDocumentor\Reflection\Types\Integer;
use Ramsey\Collection\Collection;
use Ramsey\Uuid\Type\Time;

class ReservationsController extends Controller
{
    protected $numOfTables = 7;

    public function __construct($numOfTables = 7)
    {
        $this->numOfTables = $numOfTables;
    }

    public function index (Request $request) : Response
    {
        $reservations = TableReservation::where('user_id',Auth::id())->get();
        return Inertia::render('Reservations/Index', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'reservations' => $reservations
        ]);
    }

    public function create ( Request $request)
    {
        $validated = $request->validate([
            'date'    => 'required  | date_format:Y-m-d',
            'timeFrom'=> 'required  | date_format:H:i',
            'timeTo'  =>  'required | date_format:H:i'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        $overlappingreservations =\DB::table('tableReservations')
            ->where(function ($query) use ($data){
                $query ->whereBetween('timeFrom', [$data['timeFrom'], $data['timeTo']])
                    ->orWhereBetween('timeTo', [$data['timeFrom'], $data['timeTo']]);
            })
            ->where('date', $data['date'])
            ->count();

        // restaurant has default of 7 tables so there cannot be more than 7 overlapping reservations
        if ($overlappingreservations < $this->numOfTables){
           $status = 'success';
           $statusCode = 200;
           $response = TableReservation::create($data);
        }
        else
        {
            $status = 'failed';
            $statusCode = 400;
            $response = ['message' => 'Sorry but we are overbooked for selected date and time. Try selecting a different date or time'];
        }

        return response()->json([
            'status' => $status,
            $response
        ], $statusCode);
    }

    public function myReservations ()
    {
        return TableReservation::where('user_id',Auth::id())->where('date','>=', Carbon::now())->orderBy('date')->get();
    }

    public function delete (int $id, Request $request)
    {

        TableReservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
        'status' => 'success',
         'data' => ['message' => 'Reservation with id '. $id. ' has been canceled.']
    ]);
    }
}
