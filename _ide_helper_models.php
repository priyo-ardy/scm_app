<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog query()
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApprovalStep> $steps
 * @property-read int|null $steps_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalFlow withoutRole($roles, ?string $guard = null)
 */
	class ApprovalFlow extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $approval_flow_id
 * @property string $document_type
 * @property int $document_id
 * @property int $current_step_order
 * @property int|null $current_approver_id
 * @property string $status
 * @property string|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereApprovalFlowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereCurrentApproverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereCurrentStepOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalLog withoutRole($roles, ?string $guard = null)
 */
	class ApprovalLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $approval_flow_id
 * @property int $order
 * @property string $approver_role
 * @property int|null $approver_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\User|null $approver
 * @property-read \App\Models\ApprovalFlow $flow
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereApprovalFlowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereApproverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereApproverRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ApprovalStep withoutRole($roles, ?string $guard = null)
 */
	class ApprovalStep extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string $code
 * @property string $name
 * @property string $category
 * @property string|null $phone_ext
 * @property string|null $manager_name
 * @property int $total_manpower
 * @property string|null $address
 * @property array<array-key, mixed>|null $map_url
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereManagerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereMapUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch wherePhoneExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereTotalManpower($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch withoutTrashed()
 */
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $legal_name
 * @property string $slug
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $website
 * @property string|null $address
 * @property string|null $postal_code
 * @property string|null $tax_id
 * @property string|null $tax_address
 * @property int $is_pkp
 * @property string|null $bank_name
 * @property string|null $bank_account
 * @property string|null $bank_beneficiary
 * @property string|null $logo
 * @property string|null $favicon
 * @property int|null $is_default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $currency_id
 * @property int|null $timezone_id
 * @property-read \App\Models\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\TimeZone|null $timezone
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBankAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBankBeneficiary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsPkp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLegalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTimezoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company withoutTrashed()
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $symbol
 * @property int $decimal_digits
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExchangeRate> $exchangeRates
 * @property-read int|null $exchange_rates_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereDecimalDigits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Currency withoutTrashed()
 */
	class Currency extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string|null $category
 * @property bool $is_active
 * @property string $code
 * @property string $name
 * @property string|null $address
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $website
 * @property string|null $contact_person
 * @property string|null $contact_person_email
 * @property string|null $contact_person_phone
 * @property string|null $registration_no
 * @property string|null $tax_no
 * @property int $vat
 * @property string|null $bank_name
 * @property string|null $bank_account_no
 * @property string|null $bank_account_name
 * @property string|null $avatar
 * @property int|null $payment_term_id
 * @property string|null $short_name
 * @property int $currency_id
 * @property int|null $payment_method_id
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\Currency|null $currencyList
 * @property-read \App\Models\PaymentTerm|null $paymentList
 * @property-read \App\Models\PaymentMethod|null $paymentMethodList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereBankAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereBankAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactPersonEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactPersonPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePaymentTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereRegistrationNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereTaxNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer withoutTrashed()
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string $code
 * @property string $name
 * @property int $manager_id
 * @property string|null $remark
 * @property bool $is_active
 * @property string|null $cost_center_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $created_by
 * @property int $updated_by
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\User|null $creatorList
 * @property-read \App\Models\User|null $managerList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $updaterList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCostCenterCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Department withoutRole($roles, ?string $guard = null)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property int|null $branch_id
 * @property int|null $category_id
 * @property string $code
 * @property string|null $equipment_no
 * @property string $name
 * @property string $specification
 * @property int|null $tonnage_id
 * @property string|null $brand
 * @property string|null $model_number
 * @property string|null $serial_number
 * @property string|null $purchase_date
 * @property string|null $machine_rate
 * @property string $status
 * @property int $is_active
 * @property string|null $installation_date
 * @property int $total_shots
 * @property string|null $last_maintenance
 * @property string|null $avatar
 * @property int|null $workshop_id
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Branch|null $branchList
 * @property-read \App\Models\EquipmentCategory|null $category
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Tonnage|null $tonnageList
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\Workshop|null $workshopList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereEquipmentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereInstallationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereLastMaintenance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereMachineRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereModelNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereSpecification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereTonnageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereTotalShots($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment whereWorkshopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Equipment withoutTrashed()
 */
	class Equipment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $code
 * @property string $name
 * @property string|null $prefix
 * @property string|null $icon
 * @property string|null $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $companyList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EquipmentCategory withoutTrashed()
 */
	class EquipmentCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $currency_id
 * @property \Illuminate\Support\Carbon $rate_date
 * @property int $rates
 * @property string|null $note
 * @property string $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Currency|null $currency
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereRateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereRates($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExchangeRate withoutRole($roles, ?string $guard = null)
 */
	class ExchangeRate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property int $category_id
 * @property string $code
 * @property string|null $short_code
 * @property string $name
 * @property string $specification
 * @property int $unit_id
 * @property int $purchase_unit_id
 * @property numeric $unit_conversion_rate
 * @property int $spq
 * @property int $qty_bag
 * @property numeric $net_weight
 * @property numeric $gross_weight
 * @property numeric $sprue
 * @property numeric $cycle_time
 * @property int $shift_capacity
 * @property string $properties
 * @property string|null $color
 * @property int $cavity
 * @property int $workshop_id
 * @property string|null $cust_part_no
 * @property string|null $cust_part_name
 * @property string|null $delivery_location
 * @property string|null $avatar
 * @property bool $enable_min_stock
 * @property numeric $min_stock
 * @property bool $enable_safety_stock
 * @property numeric $safety_stock
 * @property bool $enable_max_stock
 * @property numeric $max_stock
 * @property numeric $reorder_point
 * @property string|null $description
 * @property string|null $mold_no
 * @property int|null $supplier_id
 * @property bool $is_hazardous
 * @property string|null $storage_location_id
 * @property bool $enable_expired
 * @property int $expiry_days
 * @property int $lead_time_days
 * @property string $status
 * @property string|null $drawing_no
 * @property string|null $process_routes
 * @property string|null $drawing_level
 * @property string|null $revision_no
 * @property int|null $tonnage_id
 * @property string|null $hs_code
 * @property string|null $regrind_method
 * @property string|null $carton_category
 * @property numeric $carton_length
 * @property numeric $carton_width
 * @property numeric $carton_height
 * @property int|null $dimension_unit_id
 * @property int $stacking_limit
 * @property bool $is_inspection_required
 * @property numeric $last_purchase_price
 * @property array<array-key, mixed>|null $images
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $created_by
 * @property int $updated_by
 * @property-read \App\Models\MaterialCategory|null $categoryList
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Unit|null $dimensionUnitList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Unit $purchaseUnitList
 * @property-read \App\Models\Supplier|null $supplierList
 * @property-read \App\Models\Tonnage|null $tonnageList
 * @property-read \App\Models\Unit $unitList
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\Workshop|null $workshopList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCartonCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCartonHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCartonLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCartonWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCavity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCustPartName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCustPartNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereCycleTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereDeliveryLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereDimensionUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereDrawingLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereDrawingNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereEnableExpired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereEnableMaxStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereEnableMinStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereEnableSafetyStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereExpiryDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereGrossWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereHsCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereIsHazardous($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereIsInspectionRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereLastPurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereLeadTimeDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereMaxStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereMinStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereMoldNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereNetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereProcessRoutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material wherePurchaseUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereQtyBag($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereRegrindMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereReorderPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereRevisionNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereSafetyStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereShiftCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereShortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereSpecification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereSpq($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereSprue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereStackingLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereStorageLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereTonnageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereUnitConversionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material whereWorkshopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Material withoutTrashed()
 */
	class Material extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $code
 * @property int|null $parent_id
 * @property string $name
 * @property int $sort_order
 * @property string|null $remark
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $companyList
 * @property-read MaterialCategory|null $header
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MaterialCategory withoutTrashed()
 */
	class MaterialCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $category_id
 * @property string|null $type
 * @property bool $commission_fee
 * @property string|null $payment_mode
 * @property int $is_active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\SettlementCategory|null $categoryList
 * @property-read \App\Models\User|null $creatorList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\User|null $updaterList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCommissionFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod wherePaymentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentMethod withoutTrashed()
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string|null $bill_period_basis
 * @property string $name
 * @property string|null $description
 * @property bool $is_active
 * @property int $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereBillPeriodBasis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentTerm withoutTrashed()
 */
	class PaymentTerm extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $header_id
 * @property int $material_id
 * @property int $unit_id
 * @property numeric $from_qty
 * @property numeric $to_qty
 * @property numeric $unit_price
 * @property numeric $unit_price_after_tax
 * @property numeric $tax_rate
 * @property \Illuminate\Support\Carbon|null $effective_date
 * @property \Illuminate\Support\Carbon|null $expired_date
 * @property bool $is_active
 * @property string $approval_status
 * @property int|null $approved_by
 * @property string|null $approved_date
 * @property int|null $rejected_by
 * @property string|null $rejected_date
 * @property string|null $reject_reason
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Material|null $materialList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Unit $unitList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereApprovalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereApprovedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereEffectiveDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereFromQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereHeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereRejectedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereRejectedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereToQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereUnitPriceAfterTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceDetail withoutTrashed()
 */
	class PurchasePriceDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string $code
 * @property string|null $name
 * @property int $supplier_id
 * @property int $currency_id
 * @property int|null $approved_by
 * @property string|null $approved_at
 * @property bool $is_active
 * @property string $doc_status
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchasePriceDetail> $PurchasePriceDetails
 * @property-read int|null $purchase_price_details_count
 * @property-read \App\Models\User|null $approverList
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\User|null $creatorList
 * @property-read \App\Models\Currency|null $currencyList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Supplier|null $supplierList
 * @property-read \App\Models\User|null $updaterList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereDocStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchasePriceHeader withoutTrashed()
 */
	class PurchasePriceHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $purchase_requisition_header_id
 * @property int $material_id
 * @property int $unit_id
 * @property numeric $qty
 * @property numeric $qty_approved
 * @property numeric $qty_ordered
 * @property numeric $estimated_price
 * @property numeric $subtotal
 * @property int|null $supplier_id
 * @property string $arrival_date
 * @property string $item_status
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereArrivalDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereEstimatedPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereItemStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereMaterialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail wherePurchaseRequisitionHeaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereQtyApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereQtyOrdered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionDetail whereUpdatedBy($value)
 */
	class PurchaseRequisitionDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string $code
 * @property int $department_id
 * @property int $requester_id
 * @property \Illuminate\Support\Carbon $doc_date
 * @property string $priority
 * @property string $doc_status
 * @property \Illuminate\Support\Carbon|null $required_date
 * @property string|null $reject_reason
 * @property string|null $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $created_by
 * @property int $updated_by
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property-read \App\Models\User|null $approver
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\User|null $creator
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PurchaseRequisitionDetail> $details
 * @property-read int|null $details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\User|null $requestor
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereDocDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereDocStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereRequesterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereRequiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PurchaseRequisitionHeader withoutTrashed()
 */
	class PurchaseRequisitionHeader extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property int $department_id
 * @property string $code
 * @property string $name
 * @property int|null $section_head_id
 * @property bool $is_active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Department $dept
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $sectionHead
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereSectionHeadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Section withoutRole($roles, ?string $guard = null)
 */
	class Section extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property bool $is_active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read \App\Models\User|null $creatorList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\User|null $updaterList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SettlementCategory withoutTrashed()
 */
	class SettlementCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string $code
 * @property string $name
 * @property string|null $address
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $fax
 * @property string|null $website
 * @property string|null $contact_person
 * @property string|null $contact_person_email
 * @property string|null $contact_person_phone
 * @property string|null $registration_no
 * @property string|null $tax_no
 * @property int $vat
 * @property string|null $bank_name
 * @property string|null $bank_account_no
 * @property string|null $bank_account_name
 * @property string|null $avatar
 * @property int|null $payment_term_id
 * @property bool $is_active
 * @property string $category
 * @property string|null $remark
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $default_currency
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\Currency|null $currencyList
 * @property-read \App\Models\PaymentTerm|null $paymentList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereBankAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereBankAccountNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereContactPersonEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereContactPersonPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDefaultCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePaymentTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereRegistrationNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereTaxNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Supplier withoutTrashed()
 */
	class Supplier extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $offset
 * @property string|null $description
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereOffset($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeZone withoutTrashed()
 */
	class TimeZone extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $code
 * @property string $name
 * @property numeric|null $clamping_force_kn
 * @property string|null $remark
 * @property bool $is_active
 * @property int $std_dbugging
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\User|null $creatorList
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\User|null $updaterList
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereClampingForceKn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereStdDbugging($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tonnage withoutTrashed()
 */
	class Tonnage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $category
 * @property int|null $base_unit_id
 * @property numeric $conversion_factor
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Unit|null $baseUnit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereBaseUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereConversionFactor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit withoutRole($roles, ?string $guard = null)
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property int $login_attempt
 * @property bool $is_locked
 * @property string|null $last_login
 * @property string|null $last_login_from
 * @property string|null $avatar
 * @property string|null $remark
 * @property string|null $role
 * @property bool $is_active
 * @property int|null $assign_company
 * @property int|null $department_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Company|null $companyList
 * @property-read \App\Models\Department|null $department
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAssignCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLoginAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $company_id
 * @property string $code
 * @property string $name
 * @property int|null $branch_id
 * @property string|null $location_detail
 * @property int|null $pic_id
 * @property string|null $phone
 * @property string|null $remarks
 * @property string $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $updater
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereLocationDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop wherePicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Workshop withoutTrashed()
 */
	class Workshop extends \Eloquent {}
}

