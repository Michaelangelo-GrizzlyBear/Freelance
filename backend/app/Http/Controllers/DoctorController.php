<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DoctorController extends Controller
{
    
    public function getAllDoctors()
    {
        // $doctors = Doctor::get()->orderBy('created_at','desc');
        $doctors =  DB::table('doctors')
        -> orderBy('created_at', 'desc')
        -> get();
        return response()->json($doctors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addDoctor(Request $request)
    {
        $user = Auth::user();
        $fields = $request->validate([
            'user_id' => 'required',
            'doctorname'=> 'required|string',
            'specialization'=> 'required|string',
            'location'=> 'required|string',
            'branch'=> 'required|string',
            'schedule'=> 'required',
        ]);

        $doctors = Doctor::create([
            'user_id' => $user->id,
            'doctorname'=> $fields['doctorname'],
            'specialization'=> $fields['specialization'],
            'location'=>  $fields['location'],
            'branch'=>    $fields['branch'],
            'schedule'=>  $fields['schedule'],
        ]);

        return response()->json([$doctors],201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function updateDoctor(Request $request, $id)
    {
        // if(Doctor::where('id', $id)->exists()){
        //     $doctor = Doctor::find($id);

        //     $doctor->doctorname = $request->input('doctorname');
        //     $doctor->specialization = $request->input('specialization');
        //     $doctor->location = $request->input('location');
        //     $doctor->branch = $request->input('branch');
        //     $doctor->schedule = $request->input('schedule');
        //     $doctor->update();

        //     return response()->json([
        //         'Doctor' => $doctor,
        //         'message' => 'Doctor Updated Successfully'
        //     ], 200);
        // }else{
        //     return response()->json([
        //         "message" => "Doctor not found"
        //     ], 404);
        // }

        $request->validate([
            'doctorname' => 'string',
            'specialization' => 'string',
            'location' => 'string',
            'branch' => 'string',
            'schedule' => 'string',
            ]);
            $doctor = Doctor::find($id);
            $doctor->doctorname = $request->doctorname;
            $doctor->specialization = $request->specialization;
            $doctor->location = $request->location;
            $doctor->branch = $request->branch;
            $doctor->schedule = $request->schedule;
            $doctor->save();

            return response()->json([
                'Doctor' => $doctor,
                'message' => 'Doctor Updated Successfully'
            ], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function removeDoctor($id)
    {
        $doctor = Doctor::find($id);
        $doctor->delete();

        return response()->json('Doctor has been deleted.');
    }
}
