<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDoctorRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Doctor;
use App\Hospital;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class DoctorController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('doctors_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $doctors = Doctor::all();
        $doctors = Doctor::leftJoin( 'doctor_hospital', 'doctors.id', '=', 'doctor_hospital.doctor_id' )
        ->leftJoin( 'hospitals', 'doctor_hospital.hospital_id', '=', 'hospitals.id' )
        ->select(
            'doctors.*',
            DB::raw("GROUP_CONCAT(hospitals.name SEPARATOR ', ') as hospital_name")
        )
        ->groupBy( 'doctors.id' )
        ->get();

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        // $countries = ;
        // dd( $countries );
        abort_if(Gate::denies('doctors_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $hospitals = Hospital::all()->pluck('name', 'id');
        return view('admin.doctors.create',compact('hospitals'));
    }

    public function store(StoreDoctorRequest $request)
    {
        // echo '<pre>'; print_r( $request->all() );exit;
        $inputs = $request->except( 'hospital_id' );
        $doctor = Doctor::create($inputs);
        $doctor->hospitals()->sync($request->input('hospital_id'));
        foreach ($request->input('doctors_images', []) as $file) {
            $doctors->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('doctors_images');
        }

        return redirect()->route('admin.doctors.index');
    }

    public function edit(Doctor $doctor)
    {     
        abort_if(Gate::denies('doctors_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $hospitals = Hospital::all()->pluck('name', 'id');
        return view('admin.doctors.edit', compact('doctor','hospitals'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        // var_dump($request->all());exit;
        // $doctor_data = $request->only('name','');
        $doctor->update($request->except( 'hospital_id' ));
        
        // $doctor->update($request->all());
        $doctor->hospitals()->sync($request->input('hospital_id'));

        if (count($doctor->doctors_images) > 0) {
            foreach ($doctor->doctors_images as $media) {
                if (!in_array($media->file_name, $request->input('doctors_images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $doctor->doctors_images->pluck('file_name')->toArray();

        foreach ($request->input('doctors_images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $doctors->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('doctors_images');
            }
        }

        return redirect()->route('admin.doctors.index');
    }

    public function show(Doctor $doctor)
    {
        abort_if(Gate::denies('doctors_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hospitals = $doctor->hospitals;
        $hospital_name = '';
        if( isset( $hospitals ) && count( $hospitals ) > 0 ){

            $arr_hospital_name = [];
            foreach ($hospitals as $hospital) {
                $arr_hospital_name[] = $hospital->name;
            }

            $hospital_name = implode( ', ', $arr_hospital_name );
        }

        return view('admin.doctors.show', compact('doctor', 'hospital_name'));
    }

    public function destroy(Doctor $doctor)
    {
        abort_if(Gate::denies('doctors_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctor->delete();

        return back();
    }

    public function massDestroy(MassDestroyDoctorRequest $request)
    {
        Doctor::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
