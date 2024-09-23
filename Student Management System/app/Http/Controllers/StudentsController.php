<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;



class StudentsController extends Controller
{
    public function index()
    {
        $data = array("students"=>DB::table('students')->orderBy('created_at','desc')->paginate(10));
        return view('students.index',$data);

        // $data = Students::where('age','<',19)-> orderBy('first_name','asc') -> limit('5')->get();
        // $data = DB::table('students') // comment this code is to group by the gender of students male and female
        //         ->select(DB::raw('count(*) as gender_count, gender'))->groupBy('gender')->get();
        // $data = Students::where('id', 31)->firstOrFail()->get();


    }




    public function create(){
        return view('students.create')->with('title','Add New');

        
    }
    public function store(Request $request){     // Validate the request data
        $validated = $request ->validate([
            "first_name" => ['required', 'max:255'],
            "last_name" => ['required', 'max:255'],
            "gender" =>['required'],
            "age" => ['required'],
            "email" => ['required','email', Rule::unique('students', 'email')]

        ]);
        if($request->hasFile('student_image')){
            $request-> validate([
                'student_image' => 'mimes:jpg,png,bmp,tiff | max:4096'
            ]);

            $filenameWithExtension = $request->file("student_image");

            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            $extension = $request -> file("student_image")->getClientOriginalExtension();

            $filenameToStore = $filename.'_'.time().'.'.$extension;

            $smallThumbnail = $filename.'_'.time().'.'.$extension;

            $request->file('student_image')->storeAs('public/student',
            $filenameToStore);

            $request->file('student_image')->storeAs('public/student/thumbnail', 
            $smallThumbnail);

            $thumbNail = 'storage/student/thumbnail/' . $smallThumbnail;

            $this->createThumbnail($thumbNail, 150, 93);

            $validated['student_image'] = $filenameToStore; 


        }
        // Create the user with the validated data
       Students::create($validated);

       return redirect('/')->with('message','New Student was added successfully');
    
    }
    
    public function show($id){

        $data = Students::findOrFail($id);

        return view('students.edit', ['student' =>$data]);
    }

    public function update(Request $request, Students $student){

        $validated = $request ->validate([
            "first_name" => ['required', 'max:255'],
            "last_name" => ['required', 'max:255'],
            "gender" =>['required'],
            "age" => ['required'],
            "email" => ['required','email']

        ]);

 
       if($request->hasFile('student_image')){
            $request-> validate([
                'student_image' => 'mimes:jpg,png,bmp,tiff | max:4096'
            ]);

            $filenameWithExtension = $request->file("student_image");

            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);

            $extension = $request -> file("student_image")->getClientOriginalExtension();

            $filenameToStore = $filename.'_'.time().'.'.$extension;

            $smallThumbnail = $filename.'_'.time().'.'.$extension;

            $request->file('student_image')->storeAs('public/student',
            $filenameToStore);

            $request->file('student_image')->storeAs('public/student/thumbnail', 
            $smallThumbnail);

            $thumbNail = 'storage/student/thumbnail/' . $smallThumbnail;

            $this->createThumbnail($thumbNail, 150, 93);

            $validated['student_image'] = $filenameToStore; 


        }
        $updated = $student ->update($validated);
        if($updated){
            return redirect('/')->with('message','Student was updated successfully');
        }else{
            return back()->with('message','Failed to update student');
        }
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function 
        ($constraint) {
            $constraint->aspectRatio();
        });
    
        // Save the image
        $img->save($path);
    }
    
    public function destroy(Students $student){
        $delete = $student ->delete();

        if($delete){
            return redirect('/')->with('message','the student has been deleted');
        }else{
            return back()->with('message','The student has not been deleted');
        }
    }
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $students = Students::where('last_name', 'LIKE', "%{$searchTerm}%")
                           ->orWhere('id', $searchTerm)
                           ->orWhere('first_name',$searchTerm)
                           ->get();

        return view('/students.search', compact('students'));
    }

}
