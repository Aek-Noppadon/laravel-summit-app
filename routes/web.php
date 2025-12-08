<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Application\ApplicationCreate;
use App\Livewire\Application\ApplicationLists;
use App\Livewire\Crm\CrmCreate;
use App\Livewire\Crm\CrmDeleteLists;
use App\Livewire\Crm\CrmLists;
use App\Livewire\Crm\CrmListsDelete;
use App\Livewire\Customer\CustomerCreate;
use App\Livewire\Customer\CustomerLists;
use App\Livewire\CustomerGroup\CustomerGroupCreate;
use App\Livewire\CustomerGroup\CustomerGroupLists;
use App\Livewire\CustomerType\CustomerTypeCreate;
use App\Livewire\CustomerType\CustomerTypeLists;
use App\Livewire\Department\DepartmentCreate;
use App\Livewire\Department\DepartmentLists;
use App\Livewire\Probability\ProbabilityCreate;
use App\Livewire\Probability\ProbabilityLists;
use App\Livewire\Product\ProductCreate;
use App\Livewire\Product\ProductLists;
use App\Livewire\SalesStage\SalesStageCreate;
use App\Livewire\SalesStage\SalesStageLists;
use App\Livewire\User\UserProfile;
use App\Livewire\VolumeUnit\VolumeUnitCreate;
use App\Livewire\VolumeUnit\VolumeUnitLists;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', CrmLists::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('/crm/list', AllCrm::class)->name('crm.list');
    // Route::get('/crm/create', CrmCreate::class)->name('crm.create');
});

require __DIR__ . '/auth.php';

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => ['auth']
], function () {
    Route::get('/profile', UserProfile::class)->name('profile');
});

Route::group([
    'prefix' => 'departments',
    'as' => 'department.',
    'middleware' => ['auth']
], function () {
    Route::get('/', DepartmentLists::class)->name('list');
    Route::get('/create', DepartmentCreate::class)->name('create');
    Route::get('/update/{id}', DepartmentCreate::class)->name('update');
    Route::get('/delete/{id}', DepartmentCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'crms',
    'as' => 'crm.',
    'middleware' => ['auth']
], function () {
    Route::get('/lists', CrmLists::class)->name('list');
    Route::get('/create', CrmCreate::class)->name('create');
    Route::get('/update/{id}', CrmCreate::class)->name('update');
    // Route::get('/delete/{id}', CrmCreate::class)->name('delete');
    Route::get('/lists/delete', CrmListsDelete::class)->name('list.delete');
});

Route::group([
    'prefix' => 'customers',
    'as' => 'customer.',
    'middleware' => ['auth']
], function () {
    Route::get('/', CustomerLists::class)->name('list');
    Route::get('/create', CustomerCreate::class)->name('create');
    Route::get('/update/{id}', CustomerCreate::class)->name('update');
    Route::get('/delete/{id}', CustomerCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'products',
    'as' => 'product.',
    'middleware' => ['auth']
], function () {
    Route::get('/', ProductLists::class)->name('list');
    Route::get('/create', ProductCreate::class)->name('create');
    Route::get('/update/{id}', ProductCreate::class)->name('update');
    Route::get('/delete/{id}', ProductCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'customer-types',
    'as' => 'customer-type.',
    'middleware' => ['auth']
], function () {
    Route::get('/', CustomerTypeLists::class)->name('list');
    Route::get('/create', CustomerTypeCreate::class)->name('create');
    Route::get('/update/{id}', CustomerTypeCreate::class)->name('update');
    Route::get('/delete/{id}', CustomerTypeCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'customer-groups',
    'as' => 'customer-group.',
    'middleware' => ['auth']
], function () {
    Route::get('/', CustomerGroupLists::class)->name('list');
    Route::get('/create', CustomerGroupCreate::class)->name('create');
    Route::get('/update/{id}', CustomerGroupCreate::class)->name('update');
    Route::get('/delete/{id}', CustomerGroupCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'applications',
    'as' => 'application.',
    'middleware' => ['auth']
], function () {
    Route::get('/', ApplicationLists::class)->name('list');
    Route::get('/create', ApplicationCreate::class)->name('create');
    Route::get('/update/{id}', ApplicationCreate::class)->name('update');
    Route::get('/delete/{id}', ApplicationCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'sales-stages',
    'as' => 'sales-stage.',
    'middleware' => ['auth']
], function () {
    Route::get('/', SalesStageLists::class)->name('list');
    Route::get('/create', SalesStageCreate::class)->name('create');
    Route::get('/update/{id}', SalesStageCreate::class)->name('update');
    Route::get('/delete/{id}', SalesStageCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'probabilities',
    'as' => 'probability.',
    'middleware' => ['auth']
], function () {
    Route::get('/', ProbabilityLists::class)->name('list');
    Route::get('/create', ProbabilityCreate::class)->name('create');
    Route::get('/update/{id}', ProbabilityCreate::class)->name('update');
    Route::get('/delete/{id}', ProbabilityCreate::class)->name('delete');
});

Route::group([
    'prefix' => 'volume-units',
    'as' => 'volume-unit.',
    'middleware' => ['auth']
], function () {
    Route::get('/', VolumeUnitLists::class)->name('list');
    Route::get('/create', VolumeUnitCreate::class)->name('create');
    Route::get('/update/{id}', VolumeUnitCreate::class)->name('update');
    Route::get('/delete/{id}', VolumeUnitCreate::class)->name('delete');
});
