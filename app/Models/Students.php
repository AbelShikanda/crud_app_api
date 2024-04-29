<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'course', 'phone',
    ];

    // Validation rules
    // public static $rules = [
    //     'name' => 'required|string|max:255',
    //     'email' => 'required|email|unique:students,email',
    //     'course' => 'required|string|max:191',
    //     'phone' => 'required|digits:10',
    // ];

    // Validation messages
    public static $messages = [
        'name.required' => 'The name field is required.',
        'name.string' => 'The name must be a string.',
        'name.max' => 'The name may not be greater than 255 characters.',
        'email.required' => 'The email field is required.',
        'email.email' => 'The email must be a valid email address.',
        'email.unique' => 'The email has already been taken.',
        'course.required' => 'The course field is required.',
        'course.string' => 'The course must be a string.',
        'course.max' => 'The course may not be greater than 191 characters.',
        'phone.required' => 'The phone field is required.',
        'phone.digits' => 'The phone must be exactly 10 digits.',
    ];
}
