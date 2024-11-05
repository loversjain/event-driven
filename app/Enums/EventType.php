<?php

namespace App\Enums;

enum EventType: string {
    case SIGNUP = "signup";
    case RENEWAL = "renewal";
    case PAYMENT_FAILURE = "payment_failure";
}