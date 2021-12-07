<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AppointmentController extends Controller
{

    public function myAppointment($id)
    {
        // $appointment = Appointment::find($id);    
        // return response()->json($appointment);

        $appointment = Appointment::find($id);    

    Storage::download(
        public_path('/images/').$appointment->file
        // ,now()->addHour()
        // ,
        // [
        //   'ResponseContentType' => 'application/png',
        //   'ResponseContentDisposition' => 'attachment; filename=' . $appointment->file
        // ]
    );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allAppointment()
    {
        $appointment = DB::table('appointments')
        ->select(
            'appointments.id',
            'appointments.name',
            'appointments.branch',
            'appointments.test',
            'appointments.date',
            'appointments.time',
            'appointments.status',
            'appointments.addressofHomeService',
            'appointments.type',
            'appointments.otherconcerns',
            'appointments.remarks',
            'appointments.file',
            'appointments.created_at'
        )
        ->join('users', 'users.id', '=', 'appointments.user_id')
        ->orderBy('appointments.created_at','desc')
        // ->where('items.activeInactive', '=', 'Active')
        ->get();

        return response()->json($appointment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function makeAppointment(Request $request)
    {
        $user = Auth::user();

        // dd($user);
        $request->validate([
            'user_id'=> 'required',
            'name'=> 'string',
            'branch'=> 'string',
            'test'=> 'string',
            'date'=> 'string',
            'time'=> 'string',
            'type'=> 'string',
            'addressofHomeService'=> 'string',
            'otherconcerns'=> 'string',
            'remarks'=> 'string',
            'file'    =>'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
        ]);

        // if($file = $request->file('file'))
        // {
        // $allowedfileExtension=['pdf','jpg','png','docx', 'pdf'];
        // $destinationPath = 'image/';
        // $appointmentImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
        // // $file->in_array($extension,$allowedfileExtension);
        // $file->move($destinationPath, $appointmentImage);
        // $fields['file'] = "$appointmentImage";
        
        // $fields = $request->all();
        // $fields['test'] = implode(', ', (array)$request->test);
        // $fields['user_id'] = $user->id;
        // $appointment = Appointment::create($fields);
        // return response()->json($appointment);

        // }

        $input = $request->all();
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_extension = $file->getClientOriginalName();
            $destination_path = public_path() . '/images/';
            $filename = $file_extension;
            $request->file('file')->move($destination_path, $filename);
            $input['file'] = $filename;
        }
        $fields['test'] = implode(', ', (array)$request->test);
        $fields['user_id'] = $user->id;
        $appointment = Appointment::create($input);
        return response()->json($appointment);
    }
        
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string',
            'branch' => 'string',
            'test' => 'string',
            'type' => 'string',
            'addressofHomeService' => 'string',
            'otherconcerns' => 'string',
            'remarks' => 'string',
            'image' => 'string',
            ]);
            $doctor = Appointment::find($id);
            
        $appointment = $request->all();
        $appointment['test'] = implode(', ', (array)$request->test);
        $appointment['user_id'] = $user->id;
        $imageRegister = time().'.'.$request->image->extension();  
        
        $appointment['image'] = $request->image->move(public_path('image'), $imageRegister);

            $appointment->name = $request->name;
            $appointment->branch = $request->branch;
            $appointment->test = $request->test;
            $appointment->type = $request->type;
            $appointment->addressofHomeService = $request->addressofHomeService;
            $appointment->otherconcerns = $request->otherconcerns;
            $appointment->remarks = $request->remarks;
            $appointment->image = $request->image;
            $appointment->save();

            return response()->json([
                'Doctor' => $appointment,
                'message' => 'Doctor Updated Successfully'
            ], 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
