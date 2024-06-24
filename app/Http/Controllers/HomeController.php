<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use Dompdf\Dompdf;
use App\Models\Expense;
use App\Models\Budget;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BudgetAlert;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

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
        $tags = Tag::where('user_id', auth()->id())->get();
        $initialBudget = $budgets->sum('budget_initial');
        $totalExpenses = $tags->sum('amount');
        $totalBudget = $initialBudget - $totalExpenses;


        $header = '';

        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'user') {

                $user = Auth::user();
                $id = $user->id;
                $budget = Budget::all();
                $expensesByCategory = [];
                $weatherData = $this->getWeatherData();

                foreach ($categories as $category) {
                    $expensesByCategory[$category->id] = [];
                    foreach ($expenses as $expense) {
                        if ($expense->tag_id == $category->id) {
                            $expensesByCategory[$category->id][] = $expense;
                        }
                    }
                }
                $todayDate = Carbon::now()->format('F Y');
                $adminData = User::find($id);
                // Check if any budget is exceeded or approaching the limit
                foreach ($budgets as $budget) {
                    // Vérifier si la clé existe dans le tableau $expensesByCategory
                    if (array_key_exists($budget->id, $expensesByCategory)) {
                        $totalExpenses = 0;
                        foreach ($expensesByCategory[$budget->id] as $expense) {
                            $totalExpenses += $expense->amount;
                        }
                    } else {
                        $totalExpenses = 0;
                    }

                    $remainingBudget = $budget->budget_initial - $totalExpenses;
                    $budgetThreshold = $budget->budget_initial * 0.8; // Example: 80% of the budget limit

                    if ($remainingBudget <= 0) {
                        // Send notification for exceeded budget
                        $this->sendBudgetAlert($budget, 'exceeded');
                    } elseif ($remainingBudget <= $budgetThreshold) {
                        // Send notification for approaching budget limit
                        $this->sendBudgetAlert($budget, 'approaching');
                    }
                }



                return view('dashboard', compact('budget', 'expenses', 'categories', 'header', 'todayDate', 'budgets', 'adminData', 'expensesByCategory', 'weatherData', 'initialBudget', 'totalBudget')); // Ajoutez 'budgets' ici
            } elseif ($usertype == 'admin') {
                $todayDate = Carbon::now()->format('F Y');
                $users = User::where('usertype', 'user')->get();
                $id = Auth::user()->id;
                $totalUsers = User::where('usertype', '!=', 'admin')->count();
                $adminData = User::find($id);
                $chartData = $this->getChartData();

                return view('admin.adminhome', compact('users', 'header', 'todayDate', 'adminData', 'totalUsers', 'chartData'));
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
    public function Profile()
    {
        $header = '';
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile', compact('adminData', 'header'));
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

        // Validate the form data
        $validatedData = $request->validate([
            'category' => 'required|numeric', // Ensure the category field is numeric
            'duration' => 'required',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if there is already a budget of the same type for the same period
       /* $existingBudget = Budget::where('user_id', $user->id)
            ->where('budget_type', $request->input('duration'))
            ->where('created_at', '>=', now()->startOfWeek()) // Adjust this condition based on your duration (week or month)
            ->where('created_at', '<=', now()->endOfWeek()) // Adjust this condition based on your duration (week or month)
            ->first();

        if ($existingBudget) {
            // If a budget of the same type for the same period already exists, redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'You have already set a budget of the same type for this period.']);
        }
*/
        // Create a new budget
        $budget = new Budget();
        $budget->user_id = $user->id;
        $budget->total_budget = $request->input('category');
        $budget->budget_initial = $request->input('category');
        $budget->budget_type = $request->input('duration');
        $budget->description = $request->input('description');

        $budget->save();
        // Redirect with a success message
        return redirect()->back()->with('success', 'Budget saved successfully.');
    }
    public function savecategorie(Request $request)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
    
            // Get the submitted data from the request
            $name = $request->input('name');
            $amount = $request->input('amount');
            $budgetId = $request->input('budget_id');
    
            // Get the total amount spent on categories
            $totalCategoryAmount = Tag::where('user_id', $user->id)->sum('amount');
    
            // Get the budget associated with the category
            $budget = Budget::findOrFail($budgetId);
    
            // Calculate the remaining budget after adding the new category amount
            $remainingBudget = $budget->budget_initial - $totalCategoryAmount;
    
            // Check if the new category amount exceeds the remaining budget
            if ($amount > $remainingBudget) {
                return redirect()->back()->withErrors(['error' => 'Category amount exceeds remaining budget.']);
            }
    
            // Create a new category
            $category = new Tag();
            $category->name = $name;
            $category->amount = $amount;
            $category->user_id = $user->id;
            $category->budget_id = $budgetId;
    
            // Save the category to the database
            $category->save();
    
            // Update the total category amount for the budget
            $totalCategoryAmount = Tag::where('user_id', $user->id)->sum('amount');
            $budget->total_budget = $budget->budget_initial - $totalCategoryAmount;
            $budget->save();
    
            return redirect()->back()->with('success', 'Category saved successfully');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error while saving category: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while saving the category');
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
            $user->profile_picture = $profileImagePath;
        }

        // Update other user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->city = $request->input('city');

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
            $expense->user_id = $id;
            $expense->tag_id = $request->input('tag_id');
            $expense->description = $request->input('description');
            $expense->amount = $request->input('amount');

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

    private function getWeatherData()
    {
        $userCity = auth()->user()->city;
        $apiKey = config('services.openweathermap.key');

        if ($userCity) {
            try {
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q=$userCity&appid=$apiKey&units=metric");
                $weatherData = $response->json();
                return $weatherData;
            } catch (\Exception $e) {
                return [];
            }
        } else {
            return [];
        }
    }
    public function getBudgetVariationData()
    {
        $budgets = Budget::where('user_id', auth()->id())->orderBy('created_at')->get();

        $labels = $budgets->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        });

        $data = $budgets->pluck('total_budget');

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
    private function sendBudgetAlert($budget, $status)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Determine the appropriate message based on the status
        $message = '';
        if ($status === 'exceeded') {
            $message = "Your budget for {$budget->budget_type} has been exceeded.";
        } elseif ($status === 'approaching') {
            $message = "Your budget for {$budget->budget_type} is approaching its limit.";
        }

        // Send notification to the user
        Notification::send($user, new BudgetAlert($message));
    }
    public function updateBudget(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'category' => 'required|numeric',
            'duration' => 'required',
        ]);
        $id = $request->input('budget_id');
        // Trouvez le budget par ID
        $budget = Budget::findOrFail($id);

        // Mettez à jour les détails du budget
        $budget->budget_initial = $request->input('category');
        $budget->total_budget = $request->input('category');
        $budget->budget_type = $request->input('duration');
        $budget->save();

        // Redirigez avec un message de succès
        return redirect()->back()->with('success', 'Budget updated successfully');
    }

    public function deleteBudget($id)
    {
        // Trouvez le budget par ID
        $budget = Budget::findOrFail($id);

        // Supprimez le budget
        $budget->delete();

        // Redirigez avec un message de succès
        return redirect()->back()->with('success', 'Budget deleted successfully');
    }
    public function deleteCategory($id)
    {
        try {
            // Find the category by its ID
            $category = Tag::findOrFail($id);

            // Get the user ID associated with this category
            $userId = $category->user_id;

            // Delete the category
            $category->delete();

            // Recalculate the total remaining budget
            $totalCategoryAmount = Tag::where('user_id', $userId)->sum('amount');
            $budget = Budget::where('user_id', $userId)->first();
            if ($budget) {
                $budget->total_budget = $budget->budget_initial - $totalCategoryAmount;
                $budget->save();
            }

            // Redirect with a success message
            return redirect()->back()->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            // In case of error, redirect with an error message
            return redirect()->back()->with('error', 'An error occurred while deleting the category.');
        }
    }


    public function updateCategory(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);

        try {

            $id = $request->input('tag_id');
            // Trouver la catégorie à mettre à jour
            $category = Tag::findOrFail($id);

            // Sauvegarder l'ancien montant de la catégorie
            $oldAmount = $category->amount;

            // Mettre à jour les attributs de la catégorie
            $category->name = $validatedData['name'];
            $category->amount = $validatedData['amount'];
            $category->save();

            // Calculer la différence entre l'ancien montant et le nouveau montant
            $difference = $validatedData['amount'] - $oldAmount;

            // Mettre à jour le montant total du budget restant
            $userId = $category->user_id;
            $totalCategoryAmount = Tag::where('user_id', $userId)->sum('amount');
            $budget = Budget::where('user_id', $userId)->first();
            if ($budget) {
                // Mettre à jour le montant total du budget restant en tenant compte de la différence
                $budget->total_budget = $budget->budget_initial - $totalCategoryAmount;
                $budget->save();
            }

            // Rediriger vers une page appropriée après la mise à jour
            return redirect()->back()->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            // En cas d'erreur, rediriger avec un message d'erreur
            return redirect()->back()->with('error', 'An error occurred while updating the category.');
        }
    }
    public function deleteExpense($id)
    {
        try {
            // Trouver la dépense par son ID
            $expense = Expense::findOrFail($id);

            // Récupérer l'ID de la catégorie associée à cette dépense
            $categoryId = $expense->category_id;

            // Supprimer la dépense
            $expense->delete();

            // Mettre à jour le budget total de la catégorie correspondante
            $totalExpenseAmount = Expense::where('category_id', $categoryId)->sum('amount');
            $category = Tag::find($categoryId);
            if ($category) {
                $category->total_budget = $category->initial_budget - $totalExpenseAmount;
                $category->save();
            }

            // Redirection avec un message de succès
            return redirect()->back()->with('success', 'Expense deleted successfully!');
        } catch (\Exception $e) {
            // En cas d'erreur, rediriger avec un message d'erreur
            return redirect()->back()->with('error', 'An error occurred while deleting the expense.');
        }
    }
    public function updateExpense(Request $request)
    {
        try {
            $id = $request->input('expense_id');
            // Trouver la dépense par son ID
            $expense = Expense::findOrFail($id);

            // Mettre à jour les attributs de la dépense
            $expense->description = $request->input('description');
            $expense->amount = $request->input('amount');
            $expense->save();

            // Redirection avec un message de succès
            return redirect()->back()->with('success', 'Expense updated successfully');
        } catch (\Exception $e) {
            // En cas d'erreur, rediriger avec un message d'erreur
            return redirect()->back()->with('error', 'An error occurred while updating the expense.');
        }
    }
}
