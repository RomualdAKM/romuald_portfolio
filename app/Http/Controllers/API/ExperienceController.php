<?php

namespace App\Http\Controllers\API;

use App\Models\Experience;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExperienceController extends Controller
{
    public function get_all_experience(){

        $experiences = Experience::orderBy('id','DESC')->get();

        return response()->json([

            'experiences' => $experiences

        ],200);
    }

    public function create_experience(Request $request){
        $this->validate($request,[
            'company' => 'required'
        ]);

        $experience = new Experience();
        $experience->company = $request->company;
        $experience->period = $request->period;
        $experience->position = $request->position;
        $experience->save();


    }

    public function update_experience(Request $request,$id){

        $experience = Experience::find($id);

        $this->validate($request, [
            'company' => 'required'
        ]);

        $experience->company = $request->company;
        $experience->period = $request->period;
        $experience->position = $request->position;
        $experience->save();

    }

    public function delete_experience($id){
        
        $experience = Experience::findOrFail($id);

        $experience->delete();
    }
}