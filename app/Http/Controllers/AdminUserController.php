<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\MultiTenant;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDocument;
use App\Models\Vcard;
use App\Models\Receipt;
use App\Models\RedirectLink;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserController extends AppBaseController
{
  /**
   * UserController constructor.
   */
  public function __construct(UserRepository $userRepository)
  {
    $this->userRepo = $userRepository;
  }

  public function index(): \Illuminate\View\View
  {
    return view('admin_users.index');
  }

  /**
   * @return Application|Factory|View
   */
  public function show($id): \Illuminate\View\View
  {
    $user = User::find($id);

    if (! empty($user) && in_array($user->getRoleNames()[0], ['super_admin', 'sales'])) {
      return view('admin_users.show', compact('user'));
    }
    abort(404);
  }

  /**
   * @return Application|Factory|View
   */
  public function create(): \Illuminate\View\View
  {
    return view('admin_users.create');
  }

  /**
   * @return Application|RedirectResponse|Redirector
   */
  public function store(CreateUserRequest $request): RedirectResponse
  {
    $input = $request->all();
    $input['role'] = $request->role;


    $this->userRepo->store($input);

    Flash::success(__('messages.admin.admin_created_successfully'));

    return redirect(route('admins.index'));
  }

  /**
   * @return Application|Factory|View
   */
  public function edit($id): \Illuminate\View\View
  {
    $user = User::find($id);

    return view('admin_users.edit', compact('user'));
  }

  /**
   * @return Application|RedirectResponse|Redirector
   */
  public function update(UpdateUserRequest $request, $id): RedirectResponse
  {
    $user = User::findOrFail($id);


    $this->userRepo->update($request->all(), $user);

    Flash::success(__('messages.admin.admin_updated_successfully'));

    return redirect(route('admins.index'));
  }

  /**
   * Update the active status of the admin user
   */
  public function updateStatus(User $admin)
  {
    $admin->update([
      'is_active' => ! $admin->is_active,
    ]);

    return $this->sendSuccess(__('messages.flash.user_status'));
  }

  /**
   * Get user credentials for WhatsApp
   */

  public function getCredentials($id)
  {
    if (!Auth::user()->hasAnyRole(['super_admin', 'sales_agency'])) {
      return $this->sendError('Unauthorized');
    }

    $user = User::find($id);

    if (Auth::user()->hasRole('sales_agency')) {
      if (!$user || !$user->hasRole('sales') || $user->agency_id != Auth::id()) {
        return $this->sendError('Unauthorized');
      }
    } else {
      if (!$user || !$user->hasAnyRole(['super_admin', 'sales', 'sales_agency'])) {
        return $this->sendError('User not found or not authorized');
      }
    }

    // generate new password
    $newPassword = Str::random(8);

    // save hashed version
    $user->password = Hash::make($newPassword);
    $user->save();

    // Construct WhatsApp message
    $message = "عزيزي، {$user->first_name} {$user->last_name}\n\nيمكنك الدخول للوحة التحكم عبر الرابط\n\nhttps://nfcjo.com/login\n\nاسم الدخول {$user->email}\n\nالباسوورد {$newPassword}\n\nيرجى الدخول وتحميل صورة الهوية الشخصية الوجهين";

    // URL encode the message
    $encodedMessage = urlencode($message);

    // Construct WhatsApp URL
    $whatsappUrl = "https://wa.me/{$user->contact}?text={$encodedMessage}";

    return response()->json([
      'success' => true,
      'data' => [
        'email' => $user->email,
        'password' => $newPassword, // plaintext once
        'phone' => $user->contact,
        'whatsapp_url' => $whatsappUrl,
      ],
      'message' => 'Password has been reset successfully',
    ]);
  }


  /**
   * @param  User  $user
   * @return mixed
   */
  public function destroy(User $admin)
  {
    $adminDate = $admin->created_at;
    $loggedInAdminDate = Auth::user()->created_at;

    if ($loggedInAdminDate > $adminDate) {
      return $this->sendError(__('messages.admin.not_allowed_to_access'));
    }

    // Check if user has receipts
    if (Receipt::where('user_id', $admin->id)->exists()) {
      return $this->sendError(__('messages.admin.cannot_delete_user_with_receipts'));
    }

    // Check if user has assigned redirect links (active cards)
    if (RedirectLink::where('assigned_id', $admin->id)->exists()) {
      return $this->sendError(__('messages.admin.cannot_delete_user_with_active_cards'));
    }

    Vcard::where('tenant_id', $admin->tenant_id)->delete();
    MultiTenant::where('id', $admin->tenant_id)->delete();
    $admin->delete();

    return $this->sendSuccess(__('messages.admin.admin_delete_successfully'));
  }

  public function deleteDocument(UserDocument $document)
  {
    // Only super_admin can delete documents
    if (!auth()->user()->hasRole('super_admin')) {
      return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Delete the file from storage
    if (Storage::disk('public')->exists($document->file_path)) {
      Storage::disk('public')->delete($document->file_path);
    }

    // Delete the record
    $document->delete();

    return response()->json(['message' => __('messages.documents.document_deleted_successfully')]);
  }
}
