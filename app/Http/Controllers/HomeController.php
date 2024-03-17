<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
class HomeController extends Controller
{
    public function index()
    {
        $header = '';
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'user') {
                $user = Auth::user();
                $budget = budget::all() ; 
                
                $expenses = $user->expense;
                $todayDate = Carbon::now()->format('F Y');
      

        return view('dashboard', compact('budget', 'expenses','header','todayDate'));
            } elseif ($usertype == 'admin') {
                $todayDate = Carbon::now();
                $users = User::where('usertype', 'user')->get();
                return view('admin.adminhome', compact('users', 'header','todayDate'));
            } else {
                return redirect()->back();
            }
        }
    }

    
    public function edit($id)
    {
        $header = '';
        $user = User::findOrFail($id);
        return view('admin.edit', compact('user', 'header'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('admin.index')->with('success', 'User updated successfully');
    }
   
    
}