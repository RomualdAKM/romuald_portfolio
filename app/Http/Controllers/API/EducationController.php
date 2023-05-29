<?php

namespace App\Http\Controllers\API;

use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EducationController extends Controller
{
    public function get_all_education(){

        $educations = Education::orderBy('id','DESC')->get();

        return response()->json([

                'educations' => $educations

        ],200);
    }

    public function create_education(Request $request) {
        $this->validate($request,[
           'institution' => 'required'
        ]);

        $education = new  Education();
        $education->institution = $request->institution;
        $education->degree = $request->degree;
        $education->period = $request->period;
        $education->department = $request->department;
        $education->save();

    }

    public function update_education (Request $request,$id){

        $education = Education::find($id);

        $this->validate($request, [
            'institution' => 'required'
        ]);

        $education->institution = $request->institution;
        $education->degree = $request->degree;
        $education->period = $request->period;
        $education->department = $request->department;
        $education->save();
    }

    public function delete_education($id) {

        $education = Education::findOrFail($id);
        
        $education->delete();
    }
}
