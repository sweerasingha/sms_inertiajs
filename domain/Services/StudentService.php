<?php

namespace domain\Services;

use App\Models\Student;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\File;

class StudentService
{
    protected $student;

    public function __construct()
    {
        $this->student = new Student();
    }

    public function all()
    {
        return $this->student->all();
    }

    public function store1($data)
    {
        $this->student->create($data);
    }

    public function store(\Illuminate\Http\Request $request)
{
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $path = 'uploads/student/';
        $file->move($path, $filename);

        $this->student->create([
            'name' => $request['name'],
            'age' => $request['age'],
            'image' => $path . $filename,
        ]);
    }
}


    public function get($id)
    {
        return $this->student->find($id);
    }

    public function update1(array $data, $student_id)
    {
        $student = $this->student->find($student_id);
        $student->update($this->edit($student, $data));
    }

    public function update(\Illuminate\Http\Request $request, $student_id)
{
    $student = $this->student->find($student_id);

    // Corrected syntax for checking if the request has a file named 'image'
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $path = 'uploads/student/';
        $file->move(public_path($path), $filename); // Ensure you're moving the file to the public path

        // Delete the old image, if it exists
        if(File::exists(public_path($student->image))) {
            File::delete(public_path($student->image));
        }

        // Update the student's record with new data
        $student->update([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'image' => $path . $filename,
        ]);
    } else {
        // Update the student without changing the image
        $student->update($request->only(['name', 'age']));
    }
}


    protected function edit(Student $student, $data)
    {
        return array_merge($student->toArray(), $data);
    }

    public function delete($id)
    {
        $student = $this->student->find($id);
        if(File::exists(public_path($student->image))) {
            File::delete(public_path($student->image));
        }
        $student->delete();
    }

    public function status($id)
    {
        $student = $this->student->find($id);
        $student->status = !$student->status;
        $student->save();
    }
}
