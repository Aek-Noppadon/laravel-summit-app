<?php

use App\Livewire\Application\ApplicationLists;
use App\Livewire\Crm\CrmCreate;
use App\Livewire\Crm\CrmLists;
use App\Livewire\Crm\CrmListsDelete;
use App\Livewire\Customer\CustomerLists;
use App\Livewire\CustomerGroup\CustomerGroupLists;
use App\Livewire\CustomerType\CustomerTypeLists;
use App\Livewire\Department\DepartmentLists;
use App\Livewire\Event\EventLists;
use App\Livewire\Probability\ProbabilityLists;
use App\Livewire\Product\ProductLists;
use App\Livewire\Role\RoleLists;
use App\Livewire\SalesStage\SalesStageLists;
use App\Livewire\User\UserLists;
use App\Livewire\User\UserProfile;
use App\Livewire\VolumeUnit\VolumeUnitLists;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', UserProfile::class)->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';

Route::group([
    'prefix' => 'users',
    'as' => 'user.',
    'middleware' => ['auth']
], function () {
    Route::get('/', UserLists::class)->name('list')->middleware('permission:user.view');
    Route::get('/profile', UserProfile::class)->name('profile');
});

Route::group([
    'prefix' => 'departments',
    'as' => 'department.',
    'middleware' => ['auth']
], function () {
    Route::get('/', DepartmentLists::class)->name('list')->middleware('permission:department.view');
});

Route::group([
    'prefix' => 'crms',
    'as' => 'crm.',
    'middleware' => ['auth']
], function () {
    Route::get('/', CrmLists::class)->name('list')->middleware('permission:crm.view');
    Route::get('/create', CrmCreate::class)->name('create')->middleware('permission:crm.create');
    Route::get('/edit/{id}', CrmCreate::class)->name('edit')->middleware('permission:crm.edit');
    Route::get('/delete', CrmListsDelete::class)->name('list.delete')->middleware('permission:crmDelete.view');
});

Route::group([
    'prefix' => 'customers',
    'as' => 'customer.',
    'middleware' => ['auth']
], function () {
    Route::get('/', CustomerLists::class)->name('list')->middleware('permission:customer.view');
});

Route::group([
    'prefix' => 'products',
    'as' => 'product.',
    'middleware' => ['auth']
], function () {
    Route::get('/', ProductLists::class)->name('list')->middleware('permission:product.view');
});

Route::group([
    'prefix' => 'customer-types',
    'as' => 'customer-type.',
    'middleware' => ['auth']
], function () {
    Route::get('/', CustomerTypeLists::class)->name('list')->middleware('permission:customerType.view');
});

Route::group([
    'prefix' => 'customer-groups',
    'as' => 'customer-group.',
    'middleware' => ['auth']
], function () {
    Route::get('/', CustomerGroupLists::class)->name('list')->middleware('permission:customerGroup.view');
});

Route::group([
    'prefix' => 'applications',
    'as' => 'application.',
    'middleware' => ['auth']
], function () {
    Route::get('/', ApplicationLists::class)->name('list')->middleware('permission:application.view');
});

Route::group([
    'prefix' => 'sales-stages',
    'as' => 'sales-stage.',
    'middleware' => ['auth']
], function () {
    Route::get('/', SalesStageLists::class)->name('list')->middleware('permission:salesStage.view');
});

Route::group([
    'prefix' => 'probabilities',
    'as' => 'probability.',
    'middleware' => ['auth']
], function () {
    Route::get('/', ProbabilityLists::class)->name('list')->middleware('permission:probability.view');
});

Route::group([
    'prefix' => 'volume-units',
    'as' => 'volume-unit.',
    'middleware' => ['auth']
], function () {
    Route::get('/', VolumeUnitLists::class)->name('list')->middleware('permission:volumeUnit.view');
});

Route::group([
    'prefix' => 'events',
    'as' => 'event.',
    'middleware' => ['auth']
], function () {
    Route::get('/', EventLists::class)->name('list')->middleware('permission:event.view');
});

Route::group([
    'prefix' => 'roles',
    'as' => 'role.',
    'middleware' => ['auth']
], function () {
    Route::get('/', RoleLists::class)->name('list')->middleware('permission:role.view');
});
