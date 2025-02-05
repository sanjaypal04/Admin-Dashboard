<?php
namespace App\Http\Controllers;

use App\Models\User; // Use the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // List all students (treated as users)
    public function list()
    {
        return User::all(); // This will return all users, assuming you're treating students as users
    }

    // Add a new student (treated as a user)
    public function addStudent(Request $request)
    {return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 422);
            }else{
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->save();
                return response()->json(['message' => 'Student added successfully'], 201);
            }

    }

    public function update(Request $request){
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return response()->json(['message'=>'Updated Successfully']);
    }

    public function delete($id){
        $user = User::find($id);
        if(isset($user)){
            $user->delete();
        }else{
            return response()->json(['message'=>'User not found'],404);
        }
        return response()->json(['message'=>'deleted']);
    }

    public function search($name)
{
    // Perform the search using the 'like' query
    $user = User::where('name', 'like', "%$name%")->get();

    // Check if the result is empty
    if ($user->isEmpty()) {
        return response()->json(['message' => 'User not found'], 404);
    } else {
        return response()->json(['user' => $user]);
    }
}


}
