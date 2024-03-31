<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use Dompdf\Dompdf;
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
        $expenses = Expense::where('user_id', auth()->id())->get();

    
        $header = '';
    
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'user') {
                
                $user = Auth::user();
                $id=$user->id;
                $budget = Budget::all(); 
                $expensesByCategory = [];
    foreach ($categories as $category) {
        $expensesByCategory[$category->id] = [];
        foreach ($expenses as $expense) {
            if ($expense->tag_id == $category->id) {
                $expensesByCategory[$category->id][] = $expense;
            }
        }
    }
                $todayDate = Carbon::now()->format('F Y');
                $adminData=User::find($id);
                
                return view('dashboard', compact('budget', 'expenses', 'categories', 'header', 'todayDate', 'budgets','adminData','expensesByCategory')); // Ajoutez 'budgets' ici
            } elseif ($usertype == 'admin') {
                $todayDate = Carbon::now()->format('F Y');                
                $users = User::where('usertype', 'user')->get();
                $id=Auth::user()->id;
                $totalUsers = User::where('usertype', '!=', 'admin')->count();
                $adminData=User::find($id);
                $chartData = $this->getChartData();

            
                return view('admin.adminhome', compact('users', 'header','todayDate','adminData','totalUsers','chartData'));
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
    /**/
    public function Profile(){
        $header = '';
        $id=Auth::user()->id;
        $adminData=User::find($id);
        return view('admin.admin_profile',compact('adminData', 'header'));


    }
    public function adminupdate(Request $request) 
    {   
        // Get the authenticated user's ID
        $id = Auth::user()->id;
        
        // Find the user by ID
        $user = User::findOrFail($id);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Store the uploaded file in the 'photos' directory under the 'public' disk
            $photoPath = $request->file('photo')->store('photos', 'public');
            
            // Update the user's profile picture path
            $user->profile_picture = $photoPath;
        }
    
        // Update other user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        // Save the updated user record
        $user->save();
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function generateReport()
    {
        // Retrieve users who are not admins
        $users = User::where('usertype', '!=', 'admin')->get();
    
        // Load the view with the filtered users
        $html = view('admin.user_report', compact('users'));
    
        // Create a new Dompdf instance
        $pdf = new Dompdf();
    
        // Load HTML content into Dompdf
        $pdf->loadHtml($html);
    
        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');
    
        // Render PDF
        $pdf->render();
    
        // Stream the PDF to the browser
        return $pdf->stream('user_report.pdf');
    }
  
    private function getChartData()
    {
        $start_date = Carbon::now()->subDays(10); 
        $end_date = Carbon::now();
    
        // Récupérer les données pour tous les jours
        $data = [];
        $labels = [];
        $current_date = $start_date->copy();
    
        while ($current_date->lte($end_date)) {
            $date = $current_date->toDateString();
            $totalUsers = User::where('usertype', '!=', 'admin')
                              ->whereDate('created_at', $date)
                              ->count();
            $data[] = $totalUsers;
            $labels[] = $date;
            $current_date->addDay();
        }
    
        // Créer un tableau associatif avec les libellés et les données
        $chartData = [
            'labels' => $labels,
            'data' => $data,
        ];
    
        return $chartData;
    }

/* */
    public function saveBudget(Request $request)
{
    // Validez les données du formulaire
    $request->validate([
        'category' => 'required|numeric', // Assurez-vous que le champ category est numérique
        'duration' => 'required',
    ]);

        // Récupérez l'utilisateur authentifié
        $user = Auth::user();

        // Vérifiez si l'utilisateur a déjà un budget enregistré

        
            // Si l'utilisateur n'a pas de budget enregistré, créez un nouvel objet Budget
            $budget = new Budget();
            $budget->user_id = $user->id;
        

        // Récupérer le montant du budget depuis le formulaire
        $budget->budget_initial = $request->input('category');
        $budget->total_budget = $request->input('category');
        $budget->budget_type = $request->input('duration');
        $budget->save();
        
        
        // Redirigez avec un message de succès
        return redirect()->back()->with('success', 'Budget enregistré avec succès');
    
}
public function savecategorie(Request $request)
{ 
    try {
        // Enregistrez les données dans la base de données

        $category = new Tag();
        $category->name = $request->input('name');
        $category->amount = $request->input('amount');
        $category->user_id = Auth::id();

        // Fetch the budget for the authenticated user
        $budget = Budget::where('user_id', Auth::id())->first();

        // Check if budget exists
        if($budget) {
            $category->budget_id = $budget->id;
            $category->save();

            // Recalculate the total remaining budget
            $totalCategoryAmount = Tag::where('user_id', Auth::id())->sum('amount');
            $budget->total_budget = $budget->budget_initial - $totalCategoryAmount;
            $budget->save();

            return redirect()->back()->with('success', 'Catégorie enregistrée avec succès');
        } else {
            return redirect()->back()->with('error', 'Aucun budget trouvé pour cet utilisateur');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement de la catégorie');
    }
}

    public function updateProfile(Request $request) 
    {   
        //dd($request->all());
        // Get the authenticated user's ID
        $id = Auth::user()->id;
        
        // Find the user by ID
        $user = User::findOrFail($id);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Store the uploaded file in the 'photos' directory under the 'public' disk
            $profileImagePath = $request->file('photo')->store('profile_images', 'public');
            
            // Update the user's profile picture path
            $user->profile_picture = $profileImagePath ;
        }
    
        // Update other user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
        
        // Save the updated user record
        $user->save();
    
        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function saveExpense(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'tag_id' => 'required|exists:tags,id',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);
    
        try {
            // Création d'une nouvelle dépense
            $expense = new Expense();
            $id = Auth::user()->id;
            $expense->user_id=$id;
            $expense->tag_id = $request->input('tag_id');
            $expense->description = $request->input('description');
            $expense->amount =$request->input('amount');
           
            $expense->save();
    
            // Redirection avec un message de succès
            return redirect()->back()->with('success', 'Expense added successfully!');
        } catch (\Exception $e) {
            // En cas d'erreur, rediriger avec un message d'erreur
            return redirect()->back()->with('error', 'An error occurred while adding the expense.');
        }
    }
    public function getCategoryExpenses()
    {
        // Récupérer toutes les catégories de l'utilisateur authentifié
        $categories = Tag::where('user_id', auth()->id())->get();
    
        // Tableau pour stocker les dépenses de chaque catégorie
        $categoryExpenses = [];
    
        // Boucler à travers chaque catégorie et récupérer les dépenses correspondantes
        foreach ($categories as $category) {
            // Récupérer les dépenses pour la catégorie actuelle
            $expenses = Expense::where('tag_id', $category->id)->get();
            
            // Ajouter les dépenses de la catégorie actuelle au tableau
            $categoryExpenses[] = [
                'tag_id' => $category->id,
                'expenses' => $expenses
            ];
        }
    
        // Retourner les dépenses de chaque catégorie au format JSON
        return response()->json($categoryExpenses);
    }
    
         
    
}




   
    
