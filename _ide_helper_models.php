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
 * @property int $id
 * @property int $student_id
 * @property int $item_id
 * @property int|null $approved_by_user_id
 * @property int|null $returned_by_user_id
 * @property int $qty
 * @property \Illuminate\Support\Carbon $borrow_date
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property \Illuminate\Support\Carbon|null $return_date
 * @property string $status
 * @property string $call_status
 * @property string|null $call_note
 * @property \Illuminate\Support\Carbon|null $called_at
 * @property int|null $called_by
 * @property string|null $notes
 * @property int|null $approved_by
 * @property int|null $returned_by
 * @property string|null $return_notes
 * @property string|null $condition
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $approvedByUser
 * @property-read \App\Models\User|null $calledByUser
 * @property-read \App\Models\Item $item
 * @property-read \App\Models\User|null $returnedByUser
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereApprovedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereBorrowDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereCallNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereCallStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereCalledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereCalledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereReturnDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereReturnNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereReturnedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereReturnedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Borrow whereUpdatedAt($value)
 */
	class Borrow extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $group_id
 * @property string $group_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUpdatedAt($value)
 */
	class Group extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $Itemid
 * @property string $name
 * @property string|null $name_kh
 * @property numeric $available
 * @property string|null $image
 * @property int $qty
 * @property int $borrow
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Borrow> $borrows
 * @property-read int|null $borrows_count
 * @property-read string $display_name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereBorrow($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereItemid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereNameKh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Item whereUpdatedAt($value)
 */
	class Item extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $borrow_id
 * @property int|null $student_id
 * @property int|null $item_id
 * @property int|null $user_id
 * @property int|null $approved_by
 * @property int|null $returned_by
 * @property string $action
 * @property string|null $details
 * @property \Illuminate\Support\Carbon|null $action_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $approvedByUser
 * @property-read \App\Models\Borrow|null $borrow
 * @property-read \App\Models\Item|null $item
 * @property-read \App\Models\User|null $returnedByUser
 * @property-read \App\Models\Student|null $student
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereActionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereBorrowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereReturnedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ItemHistory whereUserId($value)
 */
	class ItemHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $student_id
 * @property string $student_name
 * @property string|null $phone_number
 * @property string|null $gender
 * @property int|null $group_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Borrow> $borrows
 * @property-read int|null $borrows_count
 * @property-read \App\Models\Group|null $group
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStudentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUpdatedAt($value)
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $student_name
 * @property string|null $phone_number
 * @property int|null $group_id
 * @property int|null $item_id
 * @property int $qty
 * @property string $status
 * @property string|null $notes
 * @property string|null $due_date
 * @property int|null $student_id
 * @property int $is_student_existing
 * @property int $is_student_added
 * @property int $is_borrow_approved
 * @property int $skip_group_change
 * @property string|null $gender
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Group|null $group
 * @property-read \App\Models\Item|null $item
 * @property-read \App\Models\Student|null $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereIsBorrowApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereIsStudentAdded($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereIsStudentExisting($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereSkipGroupChange($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereStudentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentSubmission whereUpdatedAt($value)
 */
	class StudentSubmission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property int $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $approvedByUser
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $returnedByUser
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

