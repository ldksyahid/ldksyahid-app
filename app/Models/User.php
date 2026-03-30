<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Controllers\LibraryFunctionController as LFC;
use App\Notifications\VerifyEmailNotification;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * Protected user ID that cannot be deleted/edited
     */
    public const PROTECTED_USER_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Allowed sort columns
     */
    protected static array $allowedSorts = [
        'name',
        'email',
        'created_at',
        'email_verified_at'
    ];

    /**
     * Get table configuration for admin index table component
     */
    public static function getTableConfig(): array
    {
        return [
            'idKey' => 'id',
            'emptyMessage' => 'No users found',
            'emptyIcon' => 'fa-users',
            'colspan' => 9,
            'columns' => [
                [
                    'key' => 'name',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'email',
                    'type' => 'text',
                    'class' => 'text-start',
                ],
                [
                    'key' => 'email_verified_at',
                    'type' => 'verification-badge',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'role_name',
                    'type' => 'role-badge',
                    'class' => 'text-center',
                ],
                [
                    'key' => 'created_at',
                    'type' => 'datetime',
                    'class' => 'text-center',
                    'dateFormat' => 'DD MMMM YYYY',
                    'timeFormat' => 'H:i T',
                ],
            ],
            'actions' => [
                'view' => [
                    'enabled' => true,
                    'route' => 'admin.user.preview',
                    'routeKey' => 'id',
                ],
                'edit' => [
                    'enabled' => true,
                    'type' => 'link',
                    'route' => 'admin.user.edit',
                    'routeKey' => 'id',
                    'protectedId' => self::PROTECTED_USER_ID,
                ],
                'delete' => [
                    'enabled' => true,
                    'btnClass' => 'delete-user-btn',
                    'protectedId' => self::PROTECTED_USER_ID,
                ],
            ],
        ];
    }

    /**
     * Search and filter users for admin panel with pagination
     */
    public static function searchAdminUsers(Request $request)
    {
        $query = self::query();

        // Search by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Search by email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Filter by verification status
        if ($request->filled('verification')) {
            if ($request->verification === 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->verification === 'not_verified') {
                $query->whereNull('email_verified_at');
            }
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Filter by date range
        if ($request->filled('created_at')) {
            $dates = explode(' - ', $request->created_at);
            if (count($dates) == 2) {
                try {
                    $startDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                    $endDate = \Carbon\Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } catch (\Exception $e) {
                    // Invalid date format, skip filter
                }
            }
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        if (!in_array($sortBy, static::$allowedSorts)) {
            $sortBy = 'created_at';
        }

        $query->orderBy($sortBy, $sortOrder);

        // Get paginated results with role info
        $users = $query->paginate(15)->appends($request->query());

        // Add role_name to each user
        $users->getCollection()->transform(function ($user) {
            $user->role_name = LFC::getRoleName($user->getRoleNames()) ?? 'User';
            return $user;
        });

        return $users;
    }

    /**
     * Get all roles for filter dropdown
     */
    public static function getRoles()
    {
        return Role::orderBy('name')->pluck('name');
    }

    /**
     * Validate request for store
     */
    public static function validateStoreRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'roleName' => 'required|exists:roles,name'
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'roleName.required' => 'Role is required.',
            'roleName.exists' => 'Selected role does not exist.',
        ]);
    }

    /**
     * Validate request for update
     */
    public static function validateUpdateRequest(Request $request, $id)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'roleName' => 'required|exists:roles,name'
        ], [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'This email is already registered.',
            'password.min' => 'Password must be at least 6 characters.',
            'roleName.required' => 'Role is required.',
            'roleName.exists' => 'Selected role does not exist.',
        ]);
    }

    /**
     * Save new user
     */
    public static function saveModel(Request $request): array
    {
        $validator = static::validateStoreRequest($request);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->all()
            ];
        }

        $role = Role::where('name', $request->roleName)->first();

        $user = self::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);

        return [
            'success' => true,
            'message' => 'User has been created successfully!',
            'data' => $user
        ];
    }

    /**
     * Update existing user
     */
    public function updateModel(Request $request): array
    {
        if ($this->id == self::PROTECTED_USER_ID) {
            return [
                'success' => false,
                'errors' => ["You can't edit this protected account."]
            ];
        }

        $validator = static::validateUpdateRequest($request, $this->id);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->all()
            ];
        }

        $role = Role::where('name', $request->roleName)->first();

        // Remove old role
        $oldRoleName = LFC::getRoleName($this->getRoleNames());
        if ($oldRoleName != null) {
            $this->removeRole($oldRoleName);
        }

        // Update user data
        $this->name = $request->name;
        $this->email = $request->email;

        if ($request->filled('password')) {
            $this->password = Hash::make($request->password);
        }

        $this->updated_at = now();
        $this->save();

        // Assign new role
        $this->assignRole($role);

        return [
            'success' => true,
            'message' => 'User has been updated successfully!',
            'data' => $this
        ];
    }

    /**
     * Delete user
     */
    public function deleteModel(): array
    {
        if ($this->id == self::PROTECTED_USER_ID) {
            return [
                'success' => false,
                'message' => "You can't delete this protected account."
            ];
        }

        // Delete profile picture if exists
        if ($this->profile != null && $this->profile->profilepicture != null) {
            File::delete($this->profile->profilepicture);
        }

        $this->delete();

        return [
            'success' => true,
            'message' => 'User has been deleted successfully!'
        ];
    }

    /**
     * Bulk delete users
     */
    public static function bulkDeleteModel(array $ids): array
    {
        // Filter out protected user
        $ids = array_filter($ids, fn($id) => $id != self::PROTECTED_USER_ID);

        if (empty($ids)) {
            return [
                'success' => false,
                'message' => 'No users selected for deletion or all selected users are protected.'
            ];
        }

        $users = self::whereIn('id', $ids)->get();

        foreach ($users as $user) {
            if ($user->profile != null && $user->profile->profilepicture != null) {
                File::delete($user->profile->profilepicture);
            }
        }

        self::whereIn('id', $ids)->delete();

        return [
            'success' => true,
            'message' => 'Selected users have been deleted successfully!'
        ];
    }

    /**
     * Check if user is protected
     */
    public function isProtected(): bool
    {
        return $this->id == self::PROTECTED_USER_ID;
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile');
    }

    public function article()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News');
    }
}
