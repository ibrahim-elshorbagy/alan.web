<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class SalesAgencySalesUserController extends AppBaseController
{
  /**
   * @var UserRepository
   */
  private $userRepo;

  /**
   * @param UserRepository $userRepository
   */
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepo = $userRepository;
  }

  /**
   * @return Application|Factory|View
   */
  public function index(): \Illuminate\View\View
  {
    return view('sales_agency.sales_users.index');
  }

  /**
   * @return Application|Factory|View
   */
  public function create(): \Illuminate\View\View
  {
    return view('sales_agency.sales_users.create');
  }

  /**
   * @return Application|RedirectResponse|Redirector
   */
  public function store(CreateUserRequest $request): RedirectResponse
  {
    $input = $request->all();
    $input['role'] = 'sales';
    $input['agency_id'] = Auth::id();

    $this->userRepo->store($input);

    Flash::success(__('messages.admin.admin_created_successfully'));

    return redirect(route('sales-agency.sales-users.index'));
  }

  /**
   * @return Application|Factory|View
   */
  public function edit($id): \Illuminate\View\View
  {
    $user = User::find($id);

    if (!$user || $user->agency_id != Auth::id() || !$user->hasRole('sales')) {
      abort(403);
    }

    return view('sales_agency.sales_users.edit', compact('user'));
  }

  /**
   * @return Application|RedirectResponse|Redirector
   */
  public function update(UpdateUserRequest $request, $id): RedirectResponse
  {
    $user = User::findOrFail($id);

    if ($user->agency_id != Auth::id() || !$user->hasRole('sales')) {
      abort(403);
    }

    $input = $request->all();
    $input['role'] = 'sales';
    $input['agency_id'] = Auth::id();

    $this->userRepo->update($input, $user);

    Flash::success(__('messages.admin.admin_updated_successfully'));

    return redirect(route('sales-agency.sales-users.index'));
  }

  /**
   * @param $id
   * @return Application|RedirectResponse|Redirector|JsonResponse
   */
  public function destroy($id)
  {
    $user = User::findOrFail($id);

    if ($user->agency_id != Auth::id() || !$user->hasRole('sales')) {
      abort(403);
    }

    $user->delete();

    if (request()->expectsJson() || request()->ajax()) {
      return $this->sendSuccess(__('messages.admin.admin_deleted_successfully'));
    }

    Flash::success(__('messages.admin.admin_deleted_successfully'));

    return redirect(route('sales-agency.sales-users.index'));
  }
}