<?php

namespace App\Http\Controllers;
use App\Http\Controllers\DB;
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
        // Récupérer les budgets
        $budgets = Budget::where('user_id', auth()->id())->get();
        
        // Récupérer les catégories
        $categories = Tag::where('user_id', auth()->id())->get();
    
        $header = '';
    
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'user') {
                $user = Auth::user();
                $budget = Budget::all(); 
                $expenses = $user->expense;
                $todayDate = Carbon::now()->format('F Y');
                return view('dashboard', compact('budget', 'expenses', 'categories', 'header', 'todayDate', 'budgets')); // Ajoutez 'budgets' ici
            } elseif ($usertype == 'admin') {
                $todayDate = Carbon::now();
                $users = User::where('usertype', 'user')->get();
                return view('admin.adminhome', compact('users', 'header', 'todayDate', 'budgets')); // Ajoutez 'budgets' ici
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
    public function saveBudget(Request $request)
{
    // Validez les données du formulaire
    $request->validate([
        'category' => 'required',
        'duration' => 'required',
    ]);

    try {
        // Enregistrez les données dans la base de données

        $budget = new Budget();
        $budget->user_id = Auth::id(); // ou utilisez $request->user()->id
        // Récupérer le montant du budget depuis le formulaire
        
        $budget->total_budget = $request->input('category');
        $budget->budget_type = $request->input('duration');
        $budget->save();
        $latestBudget = Budget::latest()->where('user_id', Auth::id())->first();
        $latestBudget->bugget_initial= $request->input('category');

        return redirect()->back()->with('success', 'Budget enregistré avec succès');
    } catch (\Exception $e) {
        // En cas d'erreur, renvoyez un message d'erreur
        return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement du budget');
    }
}
public function savecategorie(Request $request)
{ 
    try {
        // Enregistrez les données dans la base de données

        $category = new Tag();
        $category->name =$request->input('name'); // Vous pouvez définir le nom directement car il semble statique dans le formulaire
        $category->amount = $request->input('amount');
        $category->user_id = Auth::id(); // ou utilisez $request->user()->id
        $category->save();
        // Mettez à jour le budget initial
        $latestBudget = Budget::latest()->where('user_id', Auth::id())->first();
        $latestBudget->total_budget -= $request->input('amount');
        $latestBudget->save();
        

        return redirect()->back()->with('success', 'Catégorie enregistrée avec succès');
    } catch (\Exception $e) {
        // En cas d'erreur, renvoyez un message d'erreur
        return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement de la catégorie');
    }
}




   
    
}